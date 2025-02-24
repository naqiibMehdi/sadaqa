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
use Illuminate\Support\Facades\DB;

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

  /**
   * retourne la liste de tous les participants récents liés aux cagnottes de l'utilisateur
   *
   * @return JsonResponse
   */
  public function getAllParticipants(): JsonResponse
  {
    $participants = DB::table('participants')
      ->join('campaigns', 'participants.campaign_id', '=', 'campaigns.id')
      ->join('users', 'campaigns.user_id', '=', 'users.id')
      ->where('users.id', Auth::id())
      ->select('participants.*', 'campaigns.title')
      ->orderBy('participants.participation_date', 'desc')
      ->get();

    if ($participants->isEmpty()) {
      return response()->json(["message" => "Il n'y a aucun participants pour les cagnottes actuelles"]);
    }

    return response()->json($participants);
  }
}


