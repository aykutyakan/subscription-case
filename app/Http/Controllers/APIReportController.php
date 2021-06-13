<?php

namespace App\Http\Controllers;

use App\Services\Repository\PurchaseRepository\PurchaseRepositoryInterface;
use App\Services\SubscriptionReport\SubscriptionReportProvider;

class APIReportController extends Controller
{
    private $subscriptionReportProvider;
    public function __construct(SubscriptionReportProvider $subscriptionReportProvider)
    {
        $this->subscriptionReportProvider = $subscriptionReportProvider;
        $this->subscriptionReportProvider->initializeSubscription();
    }

    public function report()
    {
        $result = [
            "started"   => $this->subscriptionReportProvider->getStartedSubsriptionCount(),
            "renewed"   => $this->subscriptionReportProvider->getRenewedSubscriptionCount(),
            "canceled"  => $this->subscriptionReportProvider->getCanceledSubscriptionCount(),
        ];
        return response()->json($result);
    }
}
