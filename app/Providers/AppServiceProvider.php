<?php

namespace App\Providers;

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::USeBootstrap();
        //$generalSetting = auth()->user()->generalSetting;
        //view()->share('generalSetting',$generalSetting);
    }
}
