<?php

namespace App\Services\Repository\PurchaseRepository;

use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class PurchaseRepository implements PurchaseRepositoryInterface {

  public function storePurchase(array $purchaseArr)
  {
    $newPurchase = new Purchase($purchaseArr);
    return $newPurchase->save() 
      ? $newPurchase
      : null;
  }

  public function getExpiredSubscription($limit)
  {
      $limit = $limit > 0 ? $limit : 1;
      $result = Purchase::select("device_app_id", "reciept", "expire_date", "is_active")
                          ->with("ownerDevice")
                          ->whereDate("expire_date", "<", Carbon::now())
                          ->active()
                          ->limit($limit)
                          ->get();
      return $result;
  }

  public function updateSubscription($purchase, $expireDate, $isActive)
  {
      $purchase->expire_date = $expireDate;
      $purchase->is_active = $isActive;
      $purchase->update();
  }
  public function checkPurchaseItem($deviceAppId)
  {
    return Purchase::find($deviceAppId);
  }
  public function startedSubscription($deviceAppId, $expireDate, $isActive, $reciept)
  { 
    $newPurchase = new Purchase();
    $newPurchase->device_app_id = $deviceAppId;
    $newPurchase->expire_date = $expireDate;
    $newPurchase->is_active = $isActive;
    $newPurchase->reciept = $reciept;
    return $newPurchase->save() 
                          ? $newPurchase->only("expire_date", "is_active") 
                          : null;
  }
}