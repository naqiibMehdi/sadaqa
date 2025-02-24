<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\StripeWebHookController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post("webhook", [StripeWebHookController::class, "webhook"]);

Route::post("/forgot-password", [PasswordResetController::class, "sendResetLinkEmail"])->name("password.email");
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name("password.reset");

Route::post("/upload-image", [ImageController::class, "upload"])->name("upload.image");
Route::post("/delete-image", [ImageController::class, "delete"])->name("delete.image");


//routes for authentication
Route::prefix("auth")->group(function () {
  Route::post("/register", [AuthController::class, "store"]);
  Route::post("/login", [AuthController::class, "login"]);

});

//routes for categories
Route::prefix("categories")->group(function () {
  Route::get("/", [CategoryController::class, "index"]);
});

//routes for campaigns
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

  /**
   * User route
   */
  Route::prefix("user")->group(function () {
    Route::get("/dashboard", [UserController::class, "dashboard"]);
    Route::get("/profile", [UserController::class, "profile"]);
    Route::get("/participants", [UserController::class, "getAllParticipants"]);
  });
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
