<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetAdminGuard
{
  public function handle(Request $request, Closure $next)
  {
    if ($request->is("admin/*")) {
      // Force Laravel à utiliser le guard 'admin' pour cette requête
      Auth::shouldUse('admin');
    }

    return $next($request);

  }
}
