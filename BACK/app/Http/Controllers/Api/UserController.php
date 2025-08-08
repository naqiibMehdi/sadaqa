<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserProfileFormRequest;
use App\Http\Requests\UpdateUserPasswordFormRequest;
use App\Http\Resources\CampaignRessource;
use App\Http\Resources\UserRessource;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @group Utilisateurs
 * @authenticated
 */
class UserController extends Controller
{
  /**
   * permet d'afficher le dashboard de l'utilisateur connecté
   *
   * @return JsonResponse|AnonymousResourceCollection
   */
  public function dashboard(): JsonResponse|AnonymousResourceCollection
  {
    $getCampaignsFromUser = Campaign::with(["recovery", "participant"])->where("user_id", Auth::id())->get();

    if ($getCampaignsFromUser->isEmpty()) {
      return response()->json(["message" => "aucune cagnotte trouvée pour cet utilisateur"], 404);
    }

    return CampaignRessource::collection($getCampaignsFromUser);
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
      return response()->json(["message" => "Il n'y a aucun participants pour les cagnottes actuelles"], 400);
    }

    return response()->json($participants);
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
   * Permet à l'utilisateur de modifier ses informations de base
   *
   * @param StoreUpdateUserProfileFormRequest $request
   * @return JsonResponse
   */
  public function updateUserProfile(StoreUpdateUserProfileFormRequest $request): JsonResponse
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
   * Permet à un utilisateur connecté de modifier son mot de passe
   *
   * @param UpdateUserPasswordFormRequest $request
   * @return JsonResponse
   */
  public function updatePassword(UpdateUserPasswordFormRequest $request): JsonResponse
  {
    $validated = $request->validated();
    $user = User::where("id", auth()->id())->first();

    $user->password = Hash::make($validated["password"]);
    $user->save();

    return response()->json(["message" => "Mise à jour du mot de passe avec succès"]);
  }

  /**
   * Permet à l'utilisateru de suppriemr définitivement son compte
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function deleteAccount(Request $request): JsonResponse
  {
    $user = User::with("campaign")->where("id", auth()->id())->first();
    $listCampaignsImages = $user->campaign()->get()->pluck("image");
    $listImageDescription = $user->campaign()->get()->pluck("description");


    if (!Str::contains($user->img_profile, "http")) {
      Storage::disk("public")->delete($user->img_profile);
    }

    if ($listCampaignsImages->isNotEmpty()) {
      $listCampaignsImages->each(function ($image) {
        if (!Str::contains($image, "default_cover")) {
          Storage::disk("public")->delete($image);
        }
      });
    }

    if ($listImageDescription->isNotEmpty()) {
      $listImageDescription->each(function ($description) {
        if (preg_match_all('/<img[^>]+src=["\'](.*?)["\']/', $description, $matches)) {
          $matches = collect($matches[1]);

          if ($matches->isNotEmpty()) {
            $matches->each(function ($imageUrl) {
              Storage::disk("public")->delete(Str::after($imageUrl, "storage"));
            });
          }
        }
      });
    }

    $request->user()->tokens()->each(function ($token) {
      $token->delete();
    });

    User::destroy(auth()->id());

    return response()->json(["message" => "Votre compte a bien été supprimé"]);
  }
}


