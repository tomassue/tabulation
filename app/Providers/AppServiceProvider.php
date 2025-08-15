<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use App\Models\Setting;

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
        Config::set('settings.api_url', env('API_URL'));
        if (Schema::hasTable('settings')) {
            foreach (Setting::all() as $setting) {
                Config::set('settings.' . $setting->name, $setting->value);
            }
        }
    }
}
