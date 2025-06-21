<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Resources\CampaignRessource;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
   *   "message" => "Aucune cagnottes disponibles"
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
  public function index(Request $request, string|null $categoryName = null): AnonymousResourceCollection|JsonResponse
  {
    $query = Campaign::query()->with("participant", "user");

    if ($categoryName) {
      $query->whereRelation("category", "name", $categoryName);
    }

    if ($request->has("search")) {
      $search = $request->input("search");
      $query->where("title", "like", "%$search%");
    }

    $campaigns = $query->latest()->paginate(9);

    if ($campaigns->isEmpty()) {
      return response()->json(["message" => "Aucune cagnottes disponibles"], 404);
    }

    return CampaignRessource::collection($campaigns);
  }


  /**
   * Permet d'afficher une seule cagnotte
   *
   * @param string $slug
   * @param string $id L'id de la cagnotte. No-example
   *
   * @urlParam  slug string required Le slug de la cagnotte. Example: Titre-de-la-cagnotte
   * @urlParam  id string required L'id de la cagnotte. Example: 1
   *
   * @return CampaignRessource|JsonResponse
   *
   * @response 404 {
   *   "message" => "Cette cagnotte n'existe pas"
   * }
   *
   * @response 200 {
   *  "data": {
   *    "id": 19,
   *   "title": "Dolorem qui corrupti qui ducimus iste quo enim dolores odit atque repellendus.",
   *   "description": "Sunt provident et sed dolorem. Qui similique voluptate fuga maxime eveniet.",
   *   "slug": "perspiciatis-eos-consequatur-assumenda-quia-quae-saepe",
   *   "target_amount": 52776,
   *   "collected_amount": 587,
   *   "created_at": "2025-03-18T23:18:17+00:00",
   *   "limit_date": "2025-04-29T11:23:01+00:00",
   *   "category_id": 6,
   *   "closing_date": "2025-03-13T17:46:57+00:00",
   *   "url_image": "http://localhost:8000/storage/campaigns/default_cover_campaign.png",
   *   "user": {
   *      "id": 4,
   *      "name": "Jean Delaunay",
   *      "first_name": "Thomas",
   *      "public_name": "Claudine Pineau",
   *      "birth_date": "1999-01-29T00:00:00+00:00",
   *      "email": "laetitia99@example.org",
   *      "subscribe_date": "2013-08-04T00:00:00+00:00",
   *      "image_profile": "http://localhost:8000/storage/profile/3LadULEk1ydAR7sylwtkSXSGAGF4B2YwKGeL6JQU.jpg"
   *    },
   *   "participants": []
   *  }
   * }
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
   * @authenticated
   *
   * @bodyParam title string required Le titre. Example: Ma première cagnotte
   * @bodyParam description string required La description. Example: Ma description
   * @bodyParam image file Une image de cagnotte.
   * @bodyParam target_amount number required Le montant à atteindre. Example: 5000
   * @bodyParam limit_date date La date limite. Example: 01/01/2025
   * @bodyParam category_id number required L'id de la catégorie à associer. Example: 9
   *
   * @param StoreCampaignRequest $request
   * @return JsonResponse
   *
   * @response 401 {
   *   "message":"Unauthenticated."
   * }
   *
   * @response 422 {
   *   "message": "Le titre est obligatoire. (and 3 more errors)",
   *   "errors": {
   *      "title": [
   *        "Le titre est obligatoire."
   *      ],
   *      "description": [
   *        "La description est obligatoire."
   *      ],
   *      "target_amount": [
   *        "Le montant minimal doit être de 1 euros"
   *      ],
   *      "category_id": [
   *        "Cette catégorie n'éxiste pas"
   *      ]
   * }
   * }
   *
   * @response 201 {
   *   "message": "votre cagnotte a été créée avec succès !",
   *   "data": {
   *      "id": 28,
   *      "title": "ma première cagnotte",
   *      "description": "description de la cagnotte",
   *      "slug": "ma-premiere-cagnotte",
   *      "target_amount": 20,
   *      "collected_amount": 0,
   *      "created_at": "2025-04-28T18:38:29+00:00",
   *      "limit_date": null,
   *      "category_id": 3,
   *      "closing_date": null,
   *      "url_image": "http://localhost:8000/storage/default_cover_campaign.png"
   *   }
   * }
   */
  public function store(StoreCampaignRequest $request): JsonResponse
  {
    $validated = $request->validated();
    $slug = Str::slug($validated["title"]);
    $imagePath = "campaigns/default_cover_campaign.png";


    if ($request->hasFile("image") && $request->file("image")->isValid()) {
      $imagePath = $request->file("image")->store("campaigns", "public");
    }

    $campaign = Campaign::create([
      ...$validated,
      "slug" => $slug,
      "image" => $imagePath,
      "user_id" => Auth::id(),
    ]);

    return response()->json(["message" => "votre cagnotte a été créée avec succès !", "data" => new CampaignRessource($campaign)], 201);
  }

  /**
   * Permet de mettre à jour une cagnotte
   *
   * @authenticated
   *
   * @urlParam  slug string required Le slug de la cagnotte. Example: Titre-de-la-cagnotte
   * @urlParam  id string required L'id de la cagnotte. Example: 1
   *
   * @bodyParam title string required Le titre. Example: Ma première cagnotte
   * @bodyParam description string required La description. Example: Ma description
   * @bodyParam image file Une image de cagnotte.
   * @bodyParam target_amount number required Le montant à atteindre. Example: 5000
   * @bodyParam limit_date date La date limite. Example: 01/01/2025
   * @bodyParam category_id number required L'id de la catégorie à associer. Example: 9
   *
   * @param string $slug
   * @param string $id
   * @param StoreCampaignRequest $request
   * @return JsonResponse
   *
   * @response 403 {
   *   "message" => "vous n'êtes pas autorisé à modifier cette cagnotte"
   * }
   *
   * @response 200 {
   *    "message": "Cagnotte mis à jour avec succès",
   *    "data": {
   *       "id": 28,
   *       "title": "ma première cagnotte",
   *       "description": "description de la cagnotte",
   *       "slug": "ma-premiere-cagnotte",
   *       "target_amount": 20,
   *       "collected_amount": 0,
   *       "created_at": "2025-04-28T18:38:29+00:00",
   *       "limit_date": null,
   *       "category_id": 3,
   *       "closing_date": null,
   *       "url_image": "http://localhost:8000/storage/default_cover_campaign.png"
   *    }
   *  }
   */
  public function update(string $slug, string $id, StoreCampaignRequest $request): JsonResponse
  {
    $campaign = Campaign::where("id", $id)->where('slug', $slug)->firstOrFail();
    $validated = $request->validated();

    if ($campaign->user_id !== Auth::id()) {
      return response()->json(["message" => "vous n'êtes pas autorisé à modifier cette cagnotte"], 403);
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


    return response()->json(["message" => "Cagnotte mis à jour avec succès", "data" => new CampaignRessource($campaign)]);
  }

  /**
   * Permet de supprimer une cagnotte
   *
   * @authenticated
   *
   * @urlParam  slug string required Le slug de la cagnotte. Example: Titre-de-la-cagnotte
   * @urlParam  id string required L'id de la cagnotte. Example: 1
   *
   * @param string $slug
   * @param string $id
   * @return JsonResponse
   *
   * @response 403 {
   *   "message" => "vous n'êtes pas autorisé à supprimer cet cagnotte"
   * }
   *
   * @response 200 {
   *   "message" => "Cagnotte supprimée avec succès"
   * }
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

    return response()->json(["message" => "Cagnotte supprimée avec succès"]);
  }
}
