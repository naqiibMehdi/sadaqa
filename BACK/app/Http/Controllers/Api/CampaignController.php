<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index(): JsonResponse
    {
        $campaigns = Campaign::paginate(9);

        $campaigns->getCollection()->transform(function ($campaign) {
            $campaign->url_image = asset("storage/" . $campaign->image);
            return $campaign;
        });

        return response()->json(["campaigns" => $campaigns]);
    }


    public function show(string $slug, string $id): JsonResponse
    {
        $campaign = Campaign::where("id", $id)->where('slug', $slug)->first();
        if ($campaign) {
            $campaign->url_image = asset("storage/" . $campaign->image);
        }
        return response()->json(["campaign" => !$campaign ? [] : $campaign]);
    }

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
