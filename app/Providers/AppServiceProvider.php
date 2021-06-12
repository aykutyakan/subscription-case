<?php

namespace App\Providers;

use App\Services\Repository\DeviceRepository\DeviceRepository;
use App\Services\Repository\DeviceRepository\DeviceRepositoryInterface;
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
        $this->app->bind(DeviceRepositoryInterface::class ,DeviceRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
