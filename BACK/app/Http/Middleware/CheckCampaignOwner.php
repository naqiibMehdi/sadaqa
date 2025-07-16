<?php

namespace App\Http\Middleware;

use App\Models\Campaign;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCampaignOwner
{
  /**
   * Handle an incoming request.
   *
   * @param \Closure(Request): (Response) $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $id = $request->route("id");
    $slug = $request->route("slug");
    $campaign = Campaign::where("id", $id)->where('slug', $slug)->firstOrFail();


    if ($campaign->user_id !== Auth::id()) {
      return response()->json(["message" => "vous n'êtes pas autorisé à modifier cette cagnotte"], 403);
    }

    $request->merge(["campaign" => $campaign]);

    return $next($request);
  }
}
