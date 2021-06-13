<?php

use App\Http\Controllers\APIDeviceController;
use App\Http\Controllers\APIReportController;
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

Route::put('device-register', [APIDeviceController::class, "register"]);
Route::get('check-subscription',[APIDeviceController::class, "check"]);
Route::get('app-subscription', [APIDeviceController::class, "purchase"]);

Route::get('subscription-report', [APIReportController::class, "report"]);

Route::group(["prefix" => "mock", "middleware" => ["api","rateLimitForMock"]], function(){
    Route::get('android-verify', [MockApiController::class, "androidVerify"]);
    Route::get('ios-verify', [MockApiController::class, "iosVerify"]);
});