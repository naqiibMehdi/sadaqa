<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use \App\Http\Controllers\UserController;

Route::prefix("auth")->group(function () {
    Route::post("/register", [UserController::class, "index"]);
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
