<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // مشاركة الإعدادات مع كل الصفحات
        View::composer('*', function ($view) {
            try {
                $settings = Setting::all()->pluck('value', 'key')->toArray();
                $view->with('appSettings', $settings);
            } catch (\Exception $e) {
                $view->with('appSettings', []);
            }
        });
    }
}
