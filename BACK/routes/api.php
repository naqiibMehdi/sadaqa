<?php

use App\Http\Controllers\Api\CampaignController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UserController;

Route::prefix("auth")->group(function () {
    Route::post("/register", [UserController::class, "store"]);
    Route::post("/login", [UserController::class, "login"]);
    
});

Route::prefix("campaigns")->group(function () {
    Route::get("/", [CampaignController::class, "index"]);
    Route::get("/{id}", [CampaignController::class, "show"])->where("id", "[0-9]+");
    
});

Route::middleware("auth:sanctum")->group(function() {
    Route::post("auth/logout", [UserController::class, "logout"]);
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
