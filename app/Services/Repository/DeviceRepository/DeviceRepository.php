<?php

namespace App\Services\Repository\DeviceRepository;

use App\Models\Device;

class  DeviceRepository implements DeviceRepositoryInterface{

  public function registerWithAppId(array $deviceInfo)
  {
    $deviceModel = new Device($deviceInfo);
    $deviceModel->client_token = time();
    return $deviceModel->save() ? $deviceModel : null; 
  }

  public function getDeviceIInfoWithPurchase($clientToken)
  {
    $existDevice = Device::with("purchase")->where("client_token", $clientToken)->firstOrFail();
    return $existDevice;
  }

  public function checkDeviceWithAppId($deviceId, $appId)
  {
    $existDevice = Device::where("uid", $deviceId)->where("app_id", $appId)->first();
    if($existDevice){
      $existDevice->client_token = time();
      $existDevice->update();
    }
    return $existDevice;
  }
}