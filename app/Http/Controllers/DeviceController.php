<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Services\RecieptProvider\RecieptProviderFactory;
use App\Services\Repository\DeviceRepository\DeviceRepositoryInterface;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    private $deviceRepository;
    public function __construct(DeviceRepositoryInterface $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
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
                            ->setCredentials($request->userName, $request->password)
                            ->setRecieptCode($request->reciept)
                            ->verify();
        $device->purchase->expire_date = $recieptResult["expireDate"];
        $device->purchase->is_active = $recieptResult["status"];
        $device->purchase->update();

        return response()->json($device->toArray());
    }
}
