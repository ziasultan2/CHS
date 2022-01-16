<?php

use App\Http\Controllers\PackageBookingController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\SportTypeController;
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

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::group(['middleware' =>[ 'auth:api']], function () {
    Route::resource('sport-types', SportTypeController::class)->middleware('role:admin');
    Route::resource('packages', PackageController::class)->middleware('role:coach');
    Route::resource('bookings', PackageBookingController::class)->middleware('role:athlete');
});