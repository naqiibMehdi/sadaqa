<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignRessource;
use App\Http\Resources\UserRessource;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  /**
   * permet d'afficher le dashboard de l'utilisateur connecté
   *
   * @return JsonResponse|AnonymousResourceCollection
   */
  public function dashboard(): JsonResponse|AnonymousResourceCollection
  {
    $getCampaignsFromUser = Campaign::with("participant")->where("user_id", Auth::id())->get();

    if ($getCampaignsFromUser->isEmpty()) {
      return response()->json(["message" => "aucune cagnotte trouvée pour cet utilisateur"], 404);
    }

    return CampaignRessource::collection($getCampaignsFromUser);
  }

  /**
   * retourne les informations de l'utilisateur connecté actuellement
   *
   * @return UserRessource
   */
  public function profile(): UserRessource
  {
    $getUserInfos = User::where("id", Auth::id())->first();

    return new UserRessource($getUserInfos);
  }
}
