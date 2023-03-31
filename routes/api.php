<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\WebstoreToken;
use App\Http\Controllers\Api\ShipmentController;
use Illuminate\Support\Facades\Hash;

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
Route::middleware('apiAuthentication')->group(function () {
    Route::post('/shipment/create', [ShipmentController::class, 'create'])->middleware('apiRole:api shipment create');
    Route::post('/shipment/updateStatus', [ShipmentController::class, 'updateStatus'])->middleware('apiRole:api shipment status update');
});

