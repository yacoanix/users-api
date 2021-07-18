<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\CustomerController;


//  Auth routes
Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function() {

        Route::get('logout', [AuthController::class, 'logout']);

    });

});

Route::group(['middleware' => 'auth:api'], function() {

    Route::group(['middleware' => ['role:Admin']], function () {

//    User routes
        Route::post('users/{user}/change-admin', [UserController::class, 'changeAdminRole']);
        Route::resource('users', UserController::class)->except(['create', 'edit', 'show']);

    });

//    Customer routes
    Route::post('customers/{customer}/upload-photo', [CustomerController::class, 'uploadPhoto']);
    Route::delete('customers/{customer}/delete-photo', [CustomerController::class, 'deletePhoto']);
    Route::resource('customers', CustomerController::class)->except(['create', 'edit']);

});
