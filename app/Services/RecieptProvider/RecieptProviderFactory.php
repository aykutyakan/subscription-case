<?php

  namespace App\Services\RecieptProvider;

use App\Models\Device;

class RecieptProviderFactory {

  /**
   * @param Device
   * @return BaseRecieptProvider
  */
  public static function make(string $deviceOs) {
    return $deviceOs == Device::OS_ANDROID 
      ? new AndroidRecieptProvider()
      : new IosRecieptProvider();
    }
}