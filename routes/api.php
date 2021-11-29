<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\AuthController as adminAuth;
use App\Http\Controllers\OrderController as Order;
use App\Http\Controllers\Customer\AuthController as customerAuth;
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

// Public Routes
Route::get('products/search/{name}', [ProductsController::class, 'search']);
Route::get('products/sort/{data}', [ProductsController::class, 'sort']);
Route::get('products/show/{id}', [ProductsController::class, 'show']);
Route::get('products', [ProductsController::class, 'index']);
Route::prefix('admin')->group(function () {
    Route::post('register', [adminAuth::class, 'register']);
    Route::post('logout', [adminAuth::class, 'logout']);
    Route::post('login', [adminAuth::class, 'login']);
});
Route::prefix('user')->group(function () {
    Route::post('login', [customerAuth::class, 'login']);
    Route::post('logout', [customerAuth::class, 'logout']);
    Route::post('register', [customerAuth::class, 'register']);
});
// User Protected Routes
Route::POST('placemyorder', [Order::class, 'placeOrder']);
Route::group(['middleware' => ['auth:users']], function () {
    Route::post('logout', [customerAuth::class, 'logout']);
    Route::get('get_customer', [customerAuth::class, 'getCustomer']);
    Route::post('getOrders', [Order::class, 'getOrders']);
    Route::get('editOrders', [Order::class, 'editOrder']);
    Route::post('order/sort/{key}/{values}', [Order::class, 'orderSort']);
    Route::POST('updateOrders', [Order::class, 'updateOrder']);
});
Route::get('order/audithistory/{product_id}', [Order::class, 'AuditHistory']);
// Admin Protected Routes
Route::group(['middleware' => ['auth:admins']], function () {
    Route::post('order/change_approval_status', [Order::class, 'change_approval_status']);
    Route::post('order/change_process_status', [Order::class, 'change_process_status']);
    Route::get('getAllOrders', [Order::class, 'getAllOrders']);
    Route::get('order/search/{stk_id}', [Order::class, 'search']);
    Route::post('products/store', [ProductsController::class, 'create']);
    Route::get('products/edit/{id}', [ProductsController::class, 'edit']);
    Route::post('products/update/{id}', [ProductsController::class, 'update']);
    Route::get('products/destroy/{id}', [ProductsController::class, 'destroy']);
    Route::get('getNumberOfData/{keys}/{values}', [Order::class, 'getNoD']);
    Route::get('countCustomer/', [customerAuth::class, 'countCustomer']);
    Route::get('CountProduct/', [ProductsController::class, 'CountProduct']);
});
