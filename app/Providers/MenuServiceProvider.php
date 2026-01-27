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
      $filteredMenuData = $this->filterMenuByRole($verticalMenuData);

      // Share filtered menuData to all the views
      View::share('menuData', [$filteredMenuData]);
    } catch (\Exception $e) {
      // Log the error and provide empty menu as fallback
      \Log::error("MenuServiceProvider error: " . $e->getMessage());

      // Provide a default empty menu structure
      $defaultMenu = (object) ['menu' => []];
      View::share('menuData', [$defaultMenu]);
    }
  }

  /**
   * Filter menu items based on user role and permissions
   */
  private function filterMenuByRole($menuData)
  {
    if (!Auth::check()) {
      return $menuData;
    }

    $user = Auth::user();
    $userRole = $user->role?->name;

    // Administrators see all menu items
    if (in_array($userRole, ['Administrator', 'Super Admin'])) {
      return $menuData;
    }

    $filteredMenu = ['menu' => []];

    foreach ($menuData->menu as $item) {
      // Keep menu headers
      if (isset($item->menuHeader)) {
        $filteredMenu['menu'][] = $item;
        continue;
      }

      // Filter menu items based on role
      if ($this->canAccessMenuItem($item, $userRole)) {
        $filteredMenu['menu'][] = $item;
      }
    }

    return (object) $filteredMenu;
  }

  /**
   * Check if user role can access a specific menu item
   */
  private function canAccessMenuItem($item, $userRole)
  {
    $slug = $item->slug ?? '';

    // Define role-based menu access
    $roleMenuAccess = [
        'Sales Manager' => ['dashboard', 'sales', 'customers', 'reports'],
        'Sales Representative' => ['dashboard', 'sales', 'customers'],
        'Branch Manager' => ['dashboard', 'inventory', 'sales', 'customers', 'branches', 'reports'],
        'Inventory Manager' => ['dashboard', 'inventory'],
        'Accountant' => ['dashboard', 'finance', 'reports'],
        'HR Manager' => ['dashboard', 'hr', 'reports'],
        'Customer Service' => ['dashboard', 'customers', 'sales'],
        'Warehouse Supervisor' => ['dashboard', 'inventory'],
    ];

    // Check if role has access to this menu item
    return isset($roleMenuAccess[$userRole]) && in_array($slug, $roleMenuAccess[$userRole]);
  }
}
