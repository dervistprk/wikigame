<?php

namespace App\Providers;

use App\Models\Categories;
use App\Models\Settings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        //Paginator::useBootstrap();
        Paginator::defaultView('vendor.pagination.custom');
        \View::composer(['errors::401', 'errors::403', 'errors::404', 'errors::419', 'errors::429', 'errors::500', 'errors::503'], function ($view) {
            $settings = Settings::find(1);
            $categories = Categories::get();
            $view->with(['settings' => $settings, 'categories' => $categories]);
        });
    }
}
