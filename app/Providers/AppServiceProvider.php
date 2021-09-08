<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //View composer para el sidebar
        View::composer('layouts.navigation', function($view){
            $role_id = session()->get('user_role');
            $menuSidebar = cache()->tags('Menu')->rememberForever("MenuSidebar.roleid.$role_id", function(){
                return Menu::getMenu(true);
            });

            $view->with('menuSidebar', $menuSidebar);
        });
    }
}
