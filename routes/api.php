<?php

use App\Http\Controllers\APIReportController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MockApiController;
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

Route::put('device-register', [DeviceController::class, "register"]);
Route::get('check-subscription',[DeviceController::class, "check"]);
Route::get('app-subscription', [DeviceController::class, "purchase"]);

Route::get('subscription-report', [APIReportController::class, "report"]);

Route::group(["prefix" => "mock", "middleware" => ["rateLimitForMock"]], function(){
    Route::get('android-verify', [MockApiController::class, "androidVerify"]);
    Route::get('ios-verify', [MockApiController::class, "iosVerify"]);
});