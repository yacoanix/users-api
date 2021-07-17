<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


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

});
