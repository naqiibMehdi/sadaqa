<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserProfileFormRequest;
use App\Http\Resources\CampaignRessource;
use App\Http\Resources\UserRessource;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

  public function updateUserProfile(StoreUpdateUserProfileFormRequest $request)
  {
    $user = User::where("id", Auth::id())->first();
    $validated = $request->validated();

    if ($request->hasFile("image") && $request->file("image")->isValid()) {
      if (!Str::contains($user->img_profile, "http")) {
        Storage::disk("public")->delete($user->img_profile);
      }
      $imagePath = $request->file("image")->store("profile", "public");
      $user->img_profile = $imagePath;
    }

    $user->update($validated);

    return response()->json(["message" => "Mise à jour effectuée", "data" => new UserRessource($user)]);
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


