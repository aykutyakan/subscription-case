<?php 

namespace App\Services\Repository\PurchaseRepository;

use App\Models\Purchase;

interface PurchaseRepositoryInterface 
{
  public function storePurchase(array $purchaseArr);

  public function getExpiredSubscription($limit);

  public function updateSubscription($purchase, $expireDate, $isActive);
}