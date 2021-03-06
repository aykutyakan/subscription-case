<?php

namespace App\Services\Repository\DeviceRepository;

use App\Models\Device;

class  DeviceRepository implements DeviceRepositoryInterface{

  public function registerWithAppId(array $deviceInfo)
  {
    $deviceModel = new Device($deviceInfo);
    $deviceModel->device_id = $deviceInfo["uid"];
    $deviceModel->client_token = time();
    return $deviceModel->save() ? $deviceModel : null; 
  }

  public function getDeviceIInfoWithPurchase($clientToken)
  {
    $existDevice = Device::
                  select("id","device_id", "app_id", "operating_system", "client_token", "os_username", "os_password")
                  ->with("purchase")
                  ->where("client_token", $clientToken)
                  ->firstOrFail();
    return $existDevice;
  }

  /**
   * @param string $deviceId
   * @param string $appId
   * @return Device|null
  */
  public function checkDeviceWithAppId($deviceId, $appId)
  {
    $existDevice = Device::where("device_id", $deviceId)->where("app_id", $appId)->first();
    if($existDevice){
      $existDevice->client_token = time();
      $existDevice->update();
    }
    return $existDevice;
  }
}