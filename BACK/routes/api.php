<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\StripeWebHookController;
use Illuminate\Support\Facades\Route;

Route::post("webhook", [StripeWebHookController::class, "webhook"]);

Route::post("/forgot-password", [PasswordResetController::class, "sendResetLinkEmail"])->name("password.email");
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name("password.reset");

Route::prefix("auth")->group(function () {
    Route::post("/register", [AuthController::class, "store"]);
    Route::post("/login", [AuthController::class, "login"]);

});

Route::prefix("campaigns")->group(function () {
    Route::get("/", [CampaignController::class, "index"]);
    Route::get("/{slug}-{id}", [CampaignController::class, "show"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"]);
    Route::post("/{slug}-{id}/payment", [StripeController::class, "createCheckoutSession"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"]);

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
