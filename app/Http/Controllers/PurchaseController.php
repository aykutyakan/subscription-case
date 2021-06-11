<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Services\RecieptProvider\RecieptProviderFactory;
use App\Services\Repository\DeviceRepository\DeviceRepositoryInterface;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    //
    private $deviceRepository;
    public function __construct(DeviceRepositoryInterface $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    public function purchaseApp(PurchaseRequest $request)
    {
        $device = $this->deviceRepository->getDeviceIInfoWithPurchase($request->client_token);

        $recieptProvider = RecieptProviderFactory::make($device->app_id);
        $recieptResult = $recieptProvider
                            ->setCredentials($request->userName, $request->password)
                            ->setRecieptCode($device->purchase->reciept)
                            ->subscription();
        $device->purchase->expire_date = $recieptResult["expireDate"];
        $device->purchase->is_active = $recieptResult["status"];
        $device->purchase->update();

        return response()->json($device->toArray());
    }
}
