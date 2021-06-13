<?php

namespace App\Providers;

use App\Services\Callback\PurchaseCalbackProvider;
use App\Services\Callback\PurchseCallbackProviderInterface;
use App\Services\Repository\DeviceRepository\DeviceRepository;
use App\Services\Repository\DeviceRepository\DeviceRepositoryInterface;
use App\Services\Repository\PurchaseRepository\PurchaseRepository;
use App\Services\Repository\PurchaseRepository\PurchaseRepositoryInterface;
use App\Services\ResolveSubscription\ResolveSubscriptionManager;
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
        $this->app->bind(PurchaseRepositoryInterface::class, PurchaseRepository::class);
        $this->app->bind(ResolveSubscriptionManager::class, ResolveSubscriptionManager::class);
        $this->app->bind(PurchseCallbackProviderInterface::class, PurchaseCalbackProvider::class);
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
