<?php 

namespace App\Services\Callback;

use App\Models\PurchaseCallback;
use GuzzleHttp\Client;

class PurchaseCalbackProvider implements PurchaseCallbackProviderInterface {

    private $client;
    private $callbackPurchaseInfo;
    private $deviceId;
    private $appId;
    public function __construct($deviceId, $appId)
    {
        $this->client = new Client(['http_errors' => false]);
        $this->callbackPurchaseInfo = PurchaseCallback::first();
        $this->deviceId = $deviceId;
        $this->appId = $appId;
    }

    public function requestForStarted()
    {
        $this->client->request("POST", 
                            $this->callbackPurchaseInfo->endpoint, 
                            ['query' => [
                                "deviceId" => $this->deviceId,
                                "appId" => $this->appId,
                                "type"=> PurchaseCallbackEnum::STARTED
                              ]
                            ]);
    }

    public function requestForRenewed()
    {
        $this->client->request("POST", 
                            $this->callbackPurchaseInfo->endpoint, 
                            ['query' => [
                                "deviceId" => $this->deviceId,
                                "appId" => $this->appId,
                                "type"=> PurchaseCallbackEnum::RENEWED
                              ]
                            ]);
    }

    public function requestForCanceled()
    {
        $this->client->request("POST", 
                            $this->callbackPurchaseInfo->endpoint, 
                            ['query' => [
                                "deviceId" => $this->deviceId,
                                "appId" => $this->appId,
                                "type"=> PurchaseCallbackEnum::CANCELED
                              ]
                            ]);
    }
}