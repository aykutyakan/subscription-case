<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MockApiController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::put('device-register', [DeviceController::class, "register"]);
Route::get('check-subscription',[DeviceController::class, "check"]);
Route::get('app-subscription', [DeviceController::class, "purchase"]);


Route::get('mock-android-verify', [MockApiController::class, "googleVerify"]);
Route::get('mock-ios-verify', [MockApiController::class, "iosVerify"]);