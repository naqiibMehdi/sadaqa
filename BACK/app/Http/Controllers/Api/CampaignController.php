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

class CampaignController extends Controller
{
    /**
     * Permet d'afficher 9 cagnottes par page
     *
     * @return AnonymousResourceCollection|JsonResponse
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
        $campaign = Campaign::with("participant")->where("id", $id)->where('slug', $slug)->first();
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

        Campaign::create([
            ...$validated,
            "slug" => $slug,
            "image" => $imagePath,
            "user_id" => Auth::id(),
        ]);

        return response()->json(["message" => "votre cagnotte a été créée avec succès !"]);
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

            if ($campaign->image === "default_cover_campaign.png") {
                $validated["image"] = $imagePath;
            } else {
                Storage::disk("public")->delete($campaign->image);
                $validated["image"] = $imagePath;
            }
        }

        $campaign->update($validated);


        return response()->json(["message" => "Cagnotte mis à jour avec succès"]);
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
