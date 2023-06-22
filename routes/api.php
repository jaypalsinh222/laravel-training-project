<?php

use App\Http\Controllers\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ApiController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::controller(ApiController::class)->group(function () {
//    Route::get('get-country', 'getCountry')->name('get.country');
    Route::get('users', 'index');
    Route::post('create', 'store')->name('api.user.store');
    Route::get('user/{id?}/{cityId?}', 'show')->name('api.edit.user');
    Route::post('user', 'update')->name('api.update.user');
    Route::delete('user-delete/{user?}', 'destroy')->name('api.user.delete');
});

//---API------

Route::controller(ApiUserController::class)->group(function () {
//    Route::prefix('api')->group(function () {
//    Route::get('register', 'create')->name('view-user-admin');
//    Route::get('api-users', 'index')->name('view.users');
//    Route::get('api-user-edit/{id?}/{cityId?}', 'edit')->name('get.user.details');
//    Route::post('api-store-user', 'store')->name('register');
    Route::delete('api-user-delete/{user?}', 'destroy')->name('register.delete');

//    });
});
