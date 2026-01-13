<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Route;

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

      // Share all menuData to all the views
      View::share('menuData', [$verticalMenuData]);
    } catch (\Exception $e) {
      // Log the error and provide empty menu as fallback
      \Log::error("MenuServiceProvider error: " . $e->getMessage());
      
      // Provide a default empty menu structure
      $defaultMenu = (object) ['menu' => []];
      View::share('menuData', [$defaultMenu]);
    }
  }
}
