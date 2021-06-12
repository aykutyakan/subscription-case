<?php 

namespace App\Services\ResolveSubscription;

use App\Services\RecieptProvider\RecieptProviderFactory;
use App\Services\Repository\PurchaseRepository\PurchaseRepository;

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
                                ->setCredentials($ownerDevice->userName, $ownerDevice->password)
                                ->setRecieptCode($purchase->reciept)
                                ->verify();
            if(isset($recieptResult["status"]) && isset($recieptResult["expire_date"]))
                $this->purchaseRepository->updateSubscription($purchase, $recieptResult["expire_date"], $recieptResult["status"]);
        }
    }
}