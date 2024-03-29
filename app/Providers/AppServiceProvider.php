<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use View;

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
        View::composer(
            [
                'errors::401',
                'errors::403',
                'errors::404',
                'errors::419',
                'errors::429',
                'errors::500',
                'errors::503',
                'frontend.lang_switcher'
            ], function($view) {
            $settings   = Setting::find(1);
            $categories = Category::active()->get();
            $view->with(['settings' => $settings, 'categories' => $categories, 'available_locales' => config('app.available_locales')]);
        });

        if (!app()->runningInConsole()) {
            view()->share('categories', Category::active()->get());
            view()->share('settings', Setting::find(1));
            view()->share('available_locales', config('app.available_locales'));
        }
    }
}
