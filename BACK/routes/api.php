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
    Route::get("/{slug}-{id}", [CampaignController::class, "show"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"]);

});

Route::middleware("auth:sanctum")->group(function () {
    /**
     * Auth route
     */
    Route::post("auth/logout", [AuthController::class, "logout"]);

    /**
     * Campaigns route
     */
    Route::post("/campaigns", [CampaignController::class, "store"]);
    Route::put("/campaigns/{slug}-{id}/edit", [CampaignController::class, "update"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"]);
    Route::delete("/campaigns/{slug}-{id}", [CampaignController::class, "destroy"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"]);
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
