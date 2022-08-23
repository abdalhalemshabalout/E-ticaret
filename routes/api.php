<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WorkerController;
use App\Http\Controllers\Api\CustomerController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    
});

Route::group([
    'prefix' => 'admin',
], function () {
    // authenticated staff routes here
    Route::post('site-register', [AdminController::class, 'eCommerceRegister'])->middleware('auth:sanctum');
    Route::get('get-admin-profile', [AdminController::class, 'getAdminProfile'])->middleware('auth:sanctum');
    Route::post('add-product', [AdminController::class, 'addProduct'])->middleware('auth:sanctum');
    Route::get('get-product', [AdminController::class, 'getProduct'])->middleware('auth:sanctum');
    Route::post('update-product/{id}', [AdminController::class, 'updateProduct'])->middleware('auth:sanctum');
    Route::delete('delete-product/{id}', [AdminController::class, 'deleteProduct'])->middleware('auth:sanctum'); 

});

Route::group([
    'prefix' => 'worker',
], function () {

    //Profil
    Route::get('get-worker-profile', [WorkerController::class, 'getWorkerProfile'])->middleware('auth:sanctum');
    Route::post('update-profile', [WorkerController::class, 'updateProfile'])->middleware('auth:sanctum');
    Route::post('worker-image-update', [WorkerController::class, 'profileImageUpdateandAdd'])->middleware('auth:sanctum');
    Route::post('update-password/{id}', [WorkerController::class, 'passwordUpdate'])->middleware('auth:sanctum');

    //ÜRÜNLER
    Route::post('add-product', [WorkerController::class, 'addProduct'])->middleware('auth:sanctum');
    Route::post('update-product/{id}', [WorkerController::class, 'updateProduct'])->middleware('auth:sanctum');
    Route::delete('delete-product/{id}', [WorkerController::class, 'deleteProduct'])->middleware('auth:sanctum');
    Route::get('get-peoduct', [WorkerController::class, 'getProduct'])->middleware('auth:sanctum');

    //ÜRÜNLERE AİT DUYURULAR
    Route::post('add-announcement', [WorkerController::class, 'addAnnouncement'])->middleware('auth:sanctum');
    Route::post('update-announcement/{id}', [WorkerController::class, 'updateAnnouncement'])->middleware('auth:sanctum');
    Route::delete('delete-announcement/{id}', [WorkerController::class, 'deleteAnnouncement'])->middleware('auth:sanctum');
    Route::get('announcements', [WorkerController::class, 'getAnnouncement'])->middleware('auth:sanctum');

});

Route::group([
    'prefix' => 'customer',
], function () {
    //Profil
    Route::get('customer-get-profile', [CustomerController::class, 'getVustomerProfile'])->middleware('auth:sanctum');
    Route::post('customer-profile-update', [CustomerController::class, 'profileUpdate'])->middleware('auth:sanctum');
    Route::post('customer-image-update', [CustomerController::class, 'profileImageUpdateandAdd'])->middleware('auth:sanctum');
    Route::post('update-password/{id}', [CustomerController::class, 'passwordUpdate'])->middleware('auth:sanctum');

    //Sitedeki bulunan ürünler
    Route::get('get-product', [CustomerController::class, 'getProduct'])->middleware('auth:sanctum');
    Route::get('customer-product', [CustomerController::class, 'getCustomerProduct'])->middleware('auth:sanctum');

});


