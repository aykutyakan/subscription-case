<?php 

namespace App\Services\ResolveSubscription;

use App\Services\RecieptProvider\RecieptProviderFactory;
use App\Services\Repository\PurchaseRepository\PurchaseRepository;
use GuzzleHttp\Client;

class ResolveSubscrpitionManager {

    private $purchaseRepository;
    private $client;
    private $expirePurchaseList;
    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->client = new Client();
        $this->purchaseRepository = $purchaseRepository;
    }

    public function resolveExpire($limit)
    {
        if($limit > 0 ) {
            $this->expirePurchaseList = $this->purchaseRepository->getExpiredSubscription($limit);
        }
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
            $this->purchaseRepository->updateSubscription($purchase, $recieptResult["expireDate"], $recieptResult["status"]);
        }
    }
}