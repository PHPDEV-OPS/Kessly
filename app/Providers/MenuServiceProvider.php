<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Use View::composer to ensure Auth::user() is available when the menu is rendered
    // Targeting both the original template view AND the new Flux sidebar component
    View::composer(['layouts.sections.menu.verticalMenu', 'components.layouts.app.sidebar'], function ($view) {
      try {
        $menuPath = base_path('resources/menu/verticalMenu.json');

        if (!file_exists($menuPath)) {
          throw new \Exception("Menu file not found at: {$menuPath}");
        }

        $verticalMenuJson = file_get_contents($menuPath);
        $verticalMenuData = json_decode($verticalMenuJson);

        if (json_last_error() !== JSON_ERROR_NONE) {
          throw new \Exception("Invalid JSON in menu file: " . json_last_error_msg());
        }

        if ($verticalMenuData === null) {
          throw new \Exception("Menu data is null after decoding");
        }

        // Filter menu based on user role
        // Since we are in a composer, Auth::user() should be available now
        $filteredMenuData = $this->filterMenuByRole($verticalMenuData);

        // Verify what we are passing (Debugging - remove in production if needed, but safe for now)
      if (empty($filteredMenuData->menu) && Auth::check()) {
          $u = Auth::user();
          $rName = $u->role ? $u->role->name : 'No Role';
          
          // Double check if this is an admin who got filtered out
          if ($u->email === 'admin@kessly.com' || in_array($rName, ['Administrator', 'Super Admin', 'Admin'])) {
               \Log::warning("Admin user ({$u->email}) had empty menu. Forcing full menu.");
               $filteredMenuData = $verticalMenuData;
          }
      }

        // Pass the array wrapping the object, as expected by the view: $menuData[0]->menu
        $view->with('menuData', [$filteredMenuData]);

      } catch (\Exception $e) {
        // Log the error
        \Log::error("MenuServiceProvider error: " . $e->getMessage());

        // Provide a default empty menu structure
        $defaultMenu = (object) ['menu' => []];
        $view->with('menuData', [$defaultMenu]);
      }
    });
  }

  /**
   * Filter menu items based on user role and permissions
   */
  private function filterMenuByRole($menuData)
  {
    if (!Auth::check()) {
      return (object) ['menu' => []]; // Return empty if not logged in
    }

    $user = Auth::user();
    $userRole = $user->role ? $user->role->name : 'Guest';

    // Emergency Override: Ensure the main system admin always has Administrator access
    // This protects against broken role relationships or DB inconsistencies
    if ($user->email === 'admin@kessly.com') {
        $userRole = 'Administrator';
    }

    // Administrators see all menu items
    // Normallize role checks to be safe against minor naming variations
    $userRoleNormalized = trim($userRole);
    // Explicitly check logical combinations
    if ($userRoleNormalized === 'Administrator' || $userRoleNormalized === 'Super Admin' || $userRoleNormalized === 'Admin') {
      return $menuData;
    }

    $filteredMenu = new \stdClass();
    $filteredMenu->menu = [];
    
    // 1. Get Access List
    $allowedSlugs = $this->getAllowedSlugsForRole($userRoleNormalized);

    // 2. Iterate and rebuild menu
    $activeSectionHeader = null;
    $activeSectionItems = [];

    foreach ($menuData->menu as $item) {
        // If it's a header, assume previous section is done
        if (isset($item->menuHeader)) {
            // Flush previous section if it has valid items
            if (!empty($activeSectionItems)) {
                if ($activeSectionHeader) {
                    $filteredMenu->menu[] = $activeSectionHeader;
                }
                foreach ($activeSectionItems as $validItem) {
                    $filteredMenu->menu[] = $validItem;
                }
            }
            
            // Start new section
            $activeSectionHeader = $item;
            $activeSectionItems = [];
        } 
        // If it's a menu item
        elseif (isset($item->slug)) {
            if (in_array($item->slug, $allowedSlugs)) {
                $activeSectionItems[] = $item;
            }
        }
    }
    
    // Flush the last section if any
    if (!empty($activeSectionItems)) {
        if ($activeSectionHeader) {
            $filteredMenu->menu[] = $activeSectionHeader;
        }
        foreach ($activeSectionItems as $validItem) {
            $filteredMenu->menu[] = $validItem;
        }
    }

    return $filteredMenu;
  }

  /**
   * Get list of allowed menu slugs for a specific role
   */
  private function getAllowedSlugsForRole($role)
  {
      // Group A: Business Management (Dashboard, Inventory, Sales, Customers, Reports)
      // Roles: Sales Rep, Sales Manager, Inventory Manager, Customer Service, Warehouse
      $businessManagement = ['dashboard', 'inventory', 'sales', 'customers', 'reports', 'pos'];

      // Group B: HR & Operations (Business + HR, Branches)
      // Roles: HR Manager
      $hrOperations = array_merge($businessManagement, ['hr', 'branches']);

      // Group C: Finance & Analytics (Business + HR/Ops + Finance, Analytics)
      // Roles: Accountant, Branch Manager
      $financeAnalytics = array_merge($hrOperations, ['finance', 'analytics']);

      // Group D: Admin/Super Admin (Full Access handled by first check, but just in case)
      $adminAccess = array_merge($financeAnalytics, ['settings']);

      // Normalize role checking (case insensitive for clearer matching)
      // but switch is case sensitive, so we list variations or rely on exact match.
      // The user roles from Seeder are capitalized.
      
      switch ($role) {
          case 'Sales Representative':
          case 'Sales Manager':
          case 'Inventory Manager':
          case 'Customer Service':
          case 'Warehouse Supervisor':
          case 'Employee':
              return $businessManagement;

          // Handle casing variants for HR Manager
          case 'HR Manager':
          case 'Hr Manager': 
              return $hrOperations;

          case 'Accountant':
          case 'Branch Manager':
              return $financeAnalytics;

          case 'Administrator':
          case 'Super Admin':
          case 'Admin':
              return $adminAccess;

          default:
              // Fallback: Check for case-insensitive matches if exact match failed
              $lowerRole = strtolower($role);
              
              if (in_array($lowerRole, ['sales representative', 'sales manager', 'inventory manager', 'customer service', 'warehouse supervisor', 'employee'])) {
                  return $businessManagement;
              }
              if (in_array($lowerRole, ['hr manager'])) {
                  return $hrOperations;
              }
              if (in_array($lowerRole, ['accountant', 'branch manager'])) {
                  return $financeAnalytics;
              }
              // Add Admin variants here too
              if (in_array($lowerRole, ['administrator', 'super admin', 'admin'])) {
                  return $adminAccess;
              }

              // Return everything for admin-like roles even if they fell through
              return ['dashboard'];
      }
  }
}
