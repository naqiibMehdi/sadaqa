<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Resources\CampaignRessource;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @group Cagnottes
 */
class CampaignController extends Controller
{
  /**
   * Afficher les cagnottes
   *
   * Permet d'afficher 9 cagnottes par page
   *
   * @return AnonymousResourceCollection|JsonResponse
   *
   * @response 404 {
   *   "message" => "Aucune campagnes disponible"
   * }
   *
   * @response 200 {
   *  "data": [
   *    {
   *      "id": 19,
   *      "title": "Dolorem qui corrupti qui ducimus iste quo enim dolores odit atque repellendus.",
   *      "description": "Sunt provident et sed dolorem. Qui similique voluptate fuga maxime eveniet.",
   *      "slug": "perspiciatis-eos-consequatur-assumenda-quia-quae-saepe",
   *      "target_amount": 52776,
   *      "collected_amount": 587,
   *      "created_at": "2025-03-18T23:18:17+00:00",
   *      "limit_date": "2025-04-29T11:23:01+00:00",
   *      "category_id": 6,
   *      "closing_date": "2025-03-13T17:46:57+00:00",
   *      "url_image": "http://localhost:8000/storage/campaigns/default_cover_campaign.png",
   *      "user": {
   *        "id": 4,
   *        "name": "Jean Delaunay",
   *        "first_name": "Thomas",
   *        "public_name": "Claudine Pineau",
   *        "birth_date": "1999-01-29T00:00:00+00:00",
   *        "email": "laetitia99@example.org",
   *        "subscribe_date": "2013-08-04T00:00:00+00:00",
   *        "image_profile": "http://localhost:8000/storage/profile/3LadULEk1ydAR7sylwtkSXSGAGF4B2YwKGeL6JQU.jpg"
   *      },
   *      "participants": []
   *    },
   *  ],
   *  "links": {
   *  "first": "http://localhost:8000/api/campaigns?page=1",
   *  "last": "http://localhost:8000/api/campaigns?page=3",
   *  "prev": "http://localhost:8000/api/campaigns?page=2",
   *  "next": null
   *  },
   *  "meta": {
   *    "current_page": 3,
   *    "from": 19,
   *    "last_page": 3,
   *    "links": [
   *      {
   *        "url": "http://localhost:8000/api/campaigns?page=2",
   *        "label": "pagination.previous",
   *        "active": false
   *      },
   *      {
   *        "url": "http://localhost:8000/api/campaigns?page=1",
   *        "label": "1",
   *        "active": false
   *      },
   *      {
   *        "url": "http://localhost:8000/api/campaigns?page=2",
   *        "label": "2",
   *        "active": false
   *      },
   *      {
   *        "url": "http://localhost:8000/api/campaigns?page=3",
   *        "label": "3",
   *        "active": true
   *      },
   *      {
   *        "url": null,
   *        "label": "pagination.next",
   *        "active": false
   *      }
   * ],
   *    "path": "http://localhost:8000/api/campaigns",
   *    "per_page": 9,
   *    "to": 26,
   *    "total": 26
   *  }
   * }
   */
  public function index(): AnonymousResourceCollection|JsonResponse
  {
    $campaigns = Campaign::with(["participant", "user"])->paginate(9);
    if ($campaigns->isEmpty()) {
      return response()->json(["message" => "Aucune campagnes disponible"], 404);
    }

    return CampaignRessource::collection($campaigns);
  }


  /**
   *Permet d'afficher une seule cagnotte
   *
   * @param string $slug
   * @param string $id
   * @return CampaignRessource|JsonResponse
   */
  public function show(string $slug, string $id): CampaignRessource|JsonResponse
  {
    $campaign = Campaign::with("participant", "user")->where("id", $id)->where('slug', $slug)->first();
    if (!$campaign) {
      return response()->json(["message" => "Cette cagnotte n'existe pas"], 404);
    }
    return new CampaignRessource($campaign);
  }

  /**
   * Permet de créer une cagnotte
   *
   * @param StoreCampaignRequest $request
   * @return JsonResponse
   */
  public function store(StoreCampaignRequest $request): JsonResponse
  {
    $validated = $request->validated();
    $slug = Str::slug($validated["title"]);
    $imagePath = "default_cover_campaign.png";


    if ($request->hasFile("image") && $request->file("image")->isValid()) {
      $imagePath = $request->file("image")->store("campaigns", "public");
    }

    $campaign = Campaign::create([
      ...$validated,
      "slug" => $slug,
      "image" => $imagePath,
      "user_id" => Auth::id(),
    ]);

    return response()->json(["message" => "votre cagnotte a été créée avec succès !", "data" => $campaign]);
  }

  /**
   * permet de mettre à jour une cagnotte
   *
   * @param string $slug
   * @param string $id
   * @param StoreCampaignRequest $request
   * @return JsonResponse
   */
  public function update(string $slug, string $id, StoreCampaignRequest $request): JsonResponse
  {
    $campaign = Campaign::where("id", $id)->where('slug', $slug)->firstOrFail();
    $validated = $request->validated();

    if ($campaign->user_id !== Auth::id()) {
      return response()->json(["message" => "vous n'êtes pas autorisé à modifier cet cagnotte"], 403);
    }

    if ($request->validated("title") !== $campaign->title) {
      $campaign->slug = Str::slug($request->validated("title"));
    }

    if ($request->hasFile("image") && $request->file("image")->isValid()) {
      $imagePath = $request->file("image")->store("campaigns", "public");

      if ($campaign->image === "campaigns/default_cover_campaign.png") {
        $validated["image"] = $imagePath;
      } else {
        Storage::disk("public")->delete($campaign->image);
        $validated["image"] = $imagePath;
      }
    }

    $campaign->update($validated);


    return response()->json(["message" => "Cagnotte mis à jour avec succès", "data" => $campaign]);
  }

  /**
   * Permet de supprimer une cagnotte
   *
   * @param string $slug
   * @param string $id
   * @return JsonResponse
   */
  public function destroy(string $slug, string $id): JsonResponse
  {
    $campaign = Campaign::where("id", $id)->where('slug', $slug)->firstOrFail();


    if ($campaign->user_id !== Auth::id()) {
      return response()->json(["message" => "vous n'êtes pas autorisé à supprimer cet cagnotte"], 403);
    }

    if ($campaign->image !== "default_cover_campaign.png") {
      Storage::disk("public")->delete($campaign->image);
    }

    $campaign->delete();

    return response()->json(["message" => "Cagnotte surrpimée avec succès"]);
  }
}
