<?php

namespace App\Services\Callback;

use App\Models\Purchase;

interface PurchseCallbackProviderInterface {

    public function setPurchase(Purchase $purchase);

    public function requestForCreated();

    public function requestForUpdate();

    public function requestForDeleted();
}