<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\SectorController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', function (Request $request) {
        return [
            'user' => $request->user(),
            'currentToken' => $request->bearerToken()
        ];;
    });
    Route::put('user/update/profile', [ProfileController::class, 'updateUserInfos']);
    Route::put('user/update/password', [ProfileController::class, 'updateUserPassword']);
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::get('sectors', [SectorController::class, 'index']);
    Route::put('parking/{place}/start', [PlaceController::class, 'startParking']);
    Route::put('parking/{place}/end', [PlaceController::class, 'endParking']);
    Route::post('parking/pay',[PaymentController::class,'payByStripe']);
});

Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'auth']);
