<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Paksa QrCode pakai SVG renderer (tidak butuh Imagick/GD)
    $this->app->bind('qrcode', function () {
        return new \SimpleSoftwareIO\QrCode\Generator;
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
