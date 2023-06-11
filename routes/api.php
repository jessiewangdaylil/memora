<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::namespace ('App\Http\Controllers\Api')->group(function () {
    Route::get('addr', 'FetchAddrDataController@getAddrApi');
    Route::get('addr_store/{isTrue}', 'FetchAddrDataController@store');
    Route::get('country_phone', 'FetchCountryPhoneDataController@getCountryPhoneCodeApi');
    // Route::get('country_store/{isTrue}', 'FetchCountryPhoneDataController@cityStore');

});
