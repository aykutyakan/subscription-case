<?php

namespace App\Services\Repository\DeviceRepository;

interface  DeviceRepositoryInterface {

public function registerWithAppId(array $deviceInfo);

public function checkDeviceWithAppId($deviceId, $appId);

public function getDeviceIInfoWithPurchase($clientToken);
}