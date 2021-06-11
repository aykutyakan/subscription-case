<?php

  namespace App\Services\RecieptProvider;

use App\Models\Device;

class RecieptProviderFactory {

  /**
   * @param Device
   * @return BaseRecieptProvider
  */
  public static function make(Device $deviceOs) {
    $deviceOs->operating_system == Device::OS_ANDROID 
      ? new AndroidRecieptProvider()
      : new IosRecieptProvider();
    }
}