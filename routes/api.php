<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ConfigController;

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

Route::group(['prefix' => 'products'], function () {
    Route::get('popular', [ProductController::class,'get_popular_products']);
    Route::get('recommended', [ProductController::class,'get_recommended_products']);
    Route::get('test', [ProductController::class,'test_get_recommended_products']);
});
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [CustomerAuthController::class,'register']);
    Route::post('login', [CustomerAuthController::class,'login']);
});

Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {
    Route::get('notifications', [NotificationController::class,'get_notifications']);
    Route::get('info', [CustomerController::class,'info']);
    Route::post('update-profile', [CustomerController::class,'update_profile']);
    Route::post('update-interest', [CustomerController::class,'update_interest']);
    Route::put('cm-firebase-token', [CustomerController::class,'update_cm_firebase_token']);
    Route::get('suggested-foods', [CustomerController::class,'get_suggested_food']);

    Route::group(['prefix' => 'address'], function () {
        Route::get('list', [CustomerController::class,'address_list']);
        Route::post('add', [CustomerController::class,'add_new_address']);
        Route::put('update/{id}', [CustomerController::class,'update_address']);
        Route::delete('delete', [CustomerController::class,'delete_address']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('list', [OrderController::class,'get_order_list']);
        Route::get('running-orders', [OrderController::class,'get_running_orders']);
        Route::get('details', [OrderController::class,'get_order_details']);
        Route::post('place', [OrderController::class,'place_order']);
        Route::put('cancel', [OrderController::class,'cancel_order']);
        Route::put('refund-request', [OrderController::class,'refund_request']);
        Route::get('track', [OrderController::class,'track_order']);
        Route::put('payment-method', [OrderController::class,'update_payment_method']);
    });
});

Route::group(['prefix' => 'config'], function () {
    Route::get('/', [ConfigController::class,'configuration']);
    Route::get('/get-zone-id', [ConfigController::class,'get_zone']);
    Route::get('place-api-autocomplete', [ConfigController::class,'place_api_autocomplete']);
    Route::get('distance-api', [ConfigController::class,'distance_api']);
    Route::get('place-api-details', [ConfigController::class,'place_api_details']);
    Route::get('geocode-api', [ConfigController::class,'geocode_api']);
});
