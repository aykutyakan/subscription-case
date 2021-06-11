<?php

namespace App\Services\Repository\PurchaseRepository;

use App\Models\Purchase;

class  PurchaseRepository implements PurchaseRepositoryInterface {

  public function storePurchase(array $purchaseArr)
  {
    $newPurchase = new Purchase($purchaseArr);
    return $newPurchase->save() 
      ? true
      : false;
  }

  public function getPurchaseByAppId(string $appId)
  {}

  public function renewExpireDatePurchase(Purchase $purchase)
  {}

  public function canceledPurchase($purchase)
  {}

  public function getExpiredPurchaseNonDeactive($limit = 500)
  {}
}