<?php

namespace App\Providers;

use App\Models\System;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*', function ($view) {
            $routeName = Route::currentRouteName();
            $requestList = request()->route('request_list');
    
            if ($requestList) {
                $routeName =  ucfirst($requestList) . ' Users';
            }else{
                $routeName = str_replace('_', ' ', ucfirst($routeName));
            }
    
            $params['title'] = $routeName;
            $view->with($params);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Paginator::useBootstrap();
        // Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
    }
}
