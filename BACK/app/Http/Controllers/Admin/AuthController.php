<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
  public function showLoginForm()
  {
    // Si déjà connecté, rediriger vers le dashboard
    if (Auth::guard('admin')->check()) {
      return redirect()->route('admin.dashboard');
    }

    return view('admin.auth.login');
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:6',
    ], [
      'email.required' => 'L\'adresse email est obligatoire.',
      'email.email' => 'L\'adresse email doit être valide.',
      'password.required' => 'Le mot de passe est obligatoire.',
      'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->boolean('remember');

    if (Auth::guard('admin')->attempt($credentials, $remember)) {
      $request->session()->regenerate();

      return redirect()->intended(route('admin.dashboard'))
        ->with('success', 'Connexion réussie ! Bienvenue dans votre espace d\'administration.');
    }

    return back()->withErrors([
      'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
    ])->withInput($request->except('password'));
  }

  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login')
      ->with('success', 'Vous avez été déconnecté avec succès.');
  }
}
