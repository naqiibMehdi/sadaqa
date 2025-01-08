<?php

use App\Http\Controllers\Api\CampaignController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\AuthController;

Route::prefix("auth")->group(function () {
    Route::post("/register", [AuthController::class, "store"]);
    Route::post("/login", [AuthController::class, "login"]);

});

Route::prefix("campaigns")->group(function () {
    Route::get("/", [CampaignController::class, "index"]);
    Route::get("/{id}", [CampaignController::class, "show"])->where("id", "[0-9]+");

});

Route::middleware("auth:sanctum")->group(function () {
    Route::post("auth/logout", [AuthController::class, "logout"]);
    Route::post("/campaigns", [CampaignController::class, "store"]);
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
