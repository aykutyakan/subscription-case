<?php

namespace App\Services\Callback;

use Illuminate\Support\Facades\Log;

class PurchaseCallbackFacede {

    public static function handle($deviceId, $appId, $type) 
    {
        $callback = new PurchaseCalbackProvider($deviceId, $appId);
        switch($type){
            case PurchaseCallbackEnum::STARTED:
                $callback->requestForStarted();
                break;
            case PurchaseCallbackEnum::RENEWED:
                $callback->requestForRenewed();
                break;
            case PurchaseCallbackEnum::CANCELED:
                $callback->requestForStarted();
                break;
            default:
                Log::info("Unknow type");
        }
    }
}