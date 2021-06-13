<?php 

namespace App\Services\ResolveSubscription;

use App\Jobs\PurchaseCallbackCanceledJob;
use App\Jobs\PurchaseCallbackRenewedJob;
use App\Services\RecieptProvider\RecieptProviderFactory;
use App\Services\Repository\PurchaseRepository\PurchaseRepository;
use Illuminate\Support\Facades\Log;

class ResolveSubscriptionManager {

    private $purchaseRepository;
    private $expirePurchaseList;
    public function __construct()
    {
        $this->purchaseRepository = new PurchaseRepository();
    }

    public function resolveExpire($limit)
    {
        $this->expirePurchaseList = $this->purchaseRepository
                                            ->getExpiredSubscription($limit);
        return $this;
    }

    public function verifySubscription()
    {
        foreach($this->expirePurchaseList as $purchase){
            $ownerDevice = $purchase->ownerDevice;
            $recieptProvider = RecieptProviderFactory::make($ownerDevice->operating_system);
            $recieptResult = $recieptProvider
                                ->setCredentials($ownerDevice->os_username, $ownerDevice->os_password)
                                ->setRecieptCode($purchase->reciept)
                                ->verify();
            if(isset($recieptResult->expire_date) && isset($recieptResult->status)){
                if($recieptResult->status)
                    PurchaseCallbackRenewedJob::dispatch($ownerDevice->device_id, $ownerDevice->app_id);
                else 
                    PurchaseCallbackCanceledJob::dispatch($ownerDevice->device_id, $ownerDevice->app_id);
                $this->purchaseRepository->updateSubscription($purchase, $recieptResult->expire_date, $recieptResult->status);
            }
        }
    }
}