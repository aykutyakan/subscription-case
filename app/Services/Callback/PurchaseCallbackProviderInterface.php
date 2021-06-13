<?php

namespace App\Services\Callback;

interface PurchaseCallbackProviderInterface {

    public function requestForStarted();

    public function requestForRenewed();

    public function requestForCanceled();
}