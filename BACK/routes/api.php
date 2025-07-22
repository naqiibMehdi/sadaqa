<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CampaignRecoveryController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\IbanController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\PdfController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\StripeWebHookController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\CheckCampaignOwner;
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
  Route::get("/{categoryName?}", [CampaignController::class, "index"])->where("categoryName", "[a-z]*");
  Route::get("/{slug}-{id}", [CampaignController::class, "show"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"]);
  Route::post("/{slug}-{id}/payment", [StripeController::class, "createCheckoutSession"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"]);

});


Route::middleware("auth:sanctum")->group(function () {
  /**
   * Auth route
   */
  Route::post("auth/logout", [AuthController::class, "logout"]);

  /**
   * route to manage PDF File
   */

  Route::get("pdf/{id}", [PdfController::class, "generatePdf"])->where("id", "[0-9]+");

  /**
   * CampaignRecovery route
   */
  Route::post("recovery/{id}", [CampaignRecoveryController::class, "requestTransfer"])->where("id", "[0-9]+");
  Route::get("recoveries", [CampaignRecoveryController::class, "getRecoveriesFromUser"]);

  /**
   * Campaigns route
   */
  Route::post("/campaigns", [CampaignController::class, "store"]);
  Route::put("/campaigns/{slug}-{id}/edit", [CampaignController::class, "update"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"])->middleware(CheckCampaignOwner::class);
  Route::delete("/campaigns/{slug}-{id}", [CampaignController::class, "destroy"])->where(["slug" => "[a-z0-9\-]+", "id" => "[0-9]+"])->middleware(CheckCampaignOwner::class);

  /**
   * User route
   */
  Route::prefix("user")->group(function () {
    Route::controller(UserController::class)->group(function () {
      Route::get("/dashboard", "dashboard");
      Route::get("/participants", "getAllParticipants");
      Route::get("/profile", "profile");
      Route::put("/profile/edit", "updateUserProfile");
      Route::put("/profile/edit/password", "updatePassword");
      Route::delete("/profile", "deleteAccount");
    });

    Route::controller(AddressController::class)->group(function () {
      Route::post("/address", "registerAddress");
      Route::put("/address/edit", "editAddress");
      Route::get("/address", "getAddress");
    });

    Route::controller(IbanController::class)->group(function () {
      Route::get("/iban", "show");
      Route::post("/iban", "store");
      Route::put("/iban/edit", "edit");
      Route::delete("/iban", "destroy");
    });
  });

});

