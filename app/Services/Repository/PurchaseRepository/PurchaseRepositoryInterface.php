<?php 

namespace App\Services\Repository\PurchaseRepository;

use App\Models\Purchase;

interface PurchaseRepositoryInterface 
{
  public function storePurchase(array $purchaseArr);

  public function getPurchaseByAppId(string $appId);

  public function renewExpireDatePurchase(Purchase $purchase);

  public function canceledPurchase($purchase);

  public function getExpiredPurchaseNonDeactive($limit = 500);
}