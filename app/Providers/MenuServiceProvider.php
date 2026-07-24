<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    // Resolved at render time so we can pick the menu for the logged-in role:
    // admins get the full admin menu, artists get their portal menu.
    View::composer(
      ['layouts.sections.menu.verticalMenu', 'layouts.sections.menu.horizontalMenu'],
      function ($view) {
        $user = auth()->user();

        $verticalFile = ($user && $user->role === 'artist')
          ? base_path('resources/menu/portalMenu.json')
          : base_path('resources/menu/verticalMenu.json');

        $verticalMenuData = json_decode(file_get_contents($verticalFile));
        $horizontalMenuData = json_decode(file_get_contents(base_path('resources/menu/horizontalMenu.json')));

        $view->with('menuData', [$verticalMenuData, $horizontalMenuData]);
      }
    );
  }
}
