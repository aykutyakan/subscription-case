<?php 

namespace App\Services\Callback;

use App\Models\Purchase;
use App\Models\PurchaseCallback;
use GuzzleHttp\Client;

class PurchaseCalbackProvider implements PurchseCallbackInterface {

    private $client;
    private $purchase;
    private $callbackPurchaseInfo;
    public function __construct()
    {
        $this->client =new Client();
        $this->callbackPurchaseInfo = PurchaseCallback::first();
    }

    public function setPurchase(Purchase $purchase)
    {
     $this->purchase = $purchase;
     return $this;   
    }

    public function requestForCreated()
    {

    }

    public function requestForUpdate()
    {}

    public function requestForDeleted()
    {}
}