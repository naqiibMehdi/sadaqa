<?php

namespace App\Http\Middleware;

use App\Helpers\UrlHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
  public function handle(Request $request, Closure $next)
  {
    if (!Auth::guard('admin')->check()) {
      return redirect(UrlHelper::assetUrl('admin/login'))
        ->with('error', 'Vous devez être connecté en tant qu\'administrateur pour accéder à cette page.');
    }

    return $next($request);
  }
}
