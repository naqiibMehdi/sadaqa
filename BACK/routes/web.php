<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\SitemapController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//  return view('welcome');
//});

Route::get("/sitemap.xml", [SitemapController::class, "handle"]);

// Routes publiques (page de connexion par défaut pour l'admin)
Route::prefix('admin')->name('admin.')->group(function () {
  // Routes d'authentification (accessibles sans connexion)
  Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
  });

  // Routes protégées (nécessitent une authentification admin)
  Route::middleware(['auth:admin'])->group(function () {
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (page par défaut après connexion)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Gestion des utilisateurs
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Autres routes admin à ajouter selon vos besoins
    Route::resource('campaigns', CampaignController::class);
  });
});

// Redirection de la racine vers l'admin si nécessaire
Route::get('/', function () {
  return redirect()->route('admin.login');
});

