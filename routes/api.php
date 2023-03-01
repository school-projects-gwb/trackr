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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('apiAuthenticate')->get('/test', function(Request $request){
//    $user = User::find($request->id);
//    return($user->tokens);
//});

Route::middleware('apiAuthentication')->group(function () {
    // Test route for checking the api middleware
   Route::get('/test', function (Request $request) {
       if($request->type == "user"){
           $token = WebstoreToken::find($request->id);
           return($token->user);
       } else {
           $user = User::find($request->id);
           return $user->tokens;
       }
   });

    Route::post('/shipment/create', [ShipmentController::class, 'create']);
    Route::post('/shipment/updateStatus', [ShipmentController::class, 'updateStatus']);
});

Route::get('/makeApiToken', function (Request $request) {
    $apitoken = bin2hex(random_bytes(32));
    $data = [
        'hashedToken' => Hash::make($apitoken),
        'apiToken' => $apitoken,
        ];
    return response()->json($data);
});
