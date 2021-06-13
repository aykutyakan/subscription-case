<?php 

namespace App\Services\SubscriptionReport;

use App\Services\Repository\PurchaseRepository\PurchaseRepositoryInterface;
use Carbon\Carbon;

class SubscriptionReportProvider {
    
    private $todayPurchase;
    private $purchaseRepository;

    public function __construct(PurchaseRepositoryInterface $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }
    public function initializeSubscription() 
    {   
        $this->todayPurchase = $this->purchaseRepository->getTodaySubscriptionActivity();
    }
    public function getStartedSubsriptionCount() 
    {
        
        $filtered = $this->todayPurchase->filter(function ($value, $key) {
            return $value->updated_at->isSameday($value->created_at);
        });
        return $filtered->count();
    }

    public function getRenewedSubscriptionCount() 
    {
        $filtered = $this->todayPurchase->filter(function ($value, $key) {
            return !$value->updated_at->isSameday($value->created_at);
        });
        return $filtered->count();
    }

    public function getCanceledSubscriptionCount() 
    {
        $filtered = $this->todayPurchase->filter(function ($value, $key) {
            return $value->is_active == true;
        });
        return $filtered->count();
    }
}