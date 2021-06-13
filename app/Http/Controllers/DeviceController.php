<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Services\RecieptProvider\RecieptProviderFactory;
use App\Services\Repository\DeviceRepository\DeviceRepositoryInterface;
use App\Services\Repository\PurchaseRepository\PurchaseRepository;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    private $deviceRepository;
    public function __construct(DeviceRepositoryInterface $deviceRepository, PurchaseRepository $purchaseRepository)
    {
        $this->deviceRepository  = $deviceRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    public function register(DeviceRequest $request)
    {
        $responseToken = null;
        if($existsDevice = $this->deviceRepository->checkDeviceWithAppId($request->uid, $request->app_id)){
            $responseToken = $existsDevice->client_token;
        }
        else {
            $newDeivce = $this->deviceRepository->registerWithAppId($request->all());
            $responseToken = $newDeivce->client_token;
        }

        return response()->json([
            "client_token" => $responseToken,
        ]);
    }

    public function check(Request $request)
    {
        $device = $this->deviceRepository->getDeviceIInfoWithPurchase($request->client_token);
        $returnJson["subsriction"] = false;
        if($device->purchase)
        {
            $now = new \DateTime("now");
            $expireDate = new \DateTime($device->purchase->expire_date);

            if( ($expireDate->getTimestamp() - $now->getTimestamp()) > 0 && $device->purchase->is_active) {
                $returnJson["subsriction"] = true;
            }

        }
        return response()->json($returnJson);
    }

    public function purchase(Request $request)
    {
        $device = $this->deviceRepository->getDeviceIInfoWithPurchase($request->client_token);

        $recieptProvider = RecieptProviderFactory::make($device->operating_system);
        $recieptResult = $recieptProvider
                            ->setCredentials($device->os_username, $device->os_password)
                            ->setRecieptCode($request->reciept)
                            ->verify();
        if(isset($recieptResult->expire_date) && isset($recieptResult->status)) {
            $this->purchaseRepository->updateSubscription($device->purchase, $recieptResult->expire_date, $recieptResult->status);
            return response()->json($device->toArray());
        }
        else
            return response()->json(["errors" => $recieptResult->errors]);

    }
}
