<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(["campaigns" => Campaign::paginate(9)]);
    }


    public function show(string $slug, string $id): JsonResponse
    {
        $campaign = Campaign::where("id", $id)->where('slug', $slug)->first();
        return response()->json(["campaign" => !$campaign ? [] : $campaign]);
    }

    public function store(StoreCampaignRequest $request): JsonResponse
    {
        Campaign::create([
            "title" => $request->input("title"),
            "description" => $request->input("description"),
            "image" => "default.png",
            "slug" => Str::slug($request->input("title")),
            "target_amount" => $request->input("target_amount"),
            "collected_amount" => 0,
            "limit_date" => $request->input("limit_date"),
            "category_id" => $request->input("category_id"),
            "user_id" => auth()->id()
        ]);

        return response()->json(["message" => "votre cagnotte a été créée avec succès !"]);
    }

    public function update(string $slug, string $id, StoreCampaignRequest $request): JsonResponse
    {
        $campaign = Campaign::where("id", $id)->where('slug', $slug)->firstOrFail();


        if ($campaign->user_id !== Auth::id()) {
            return response()->json(["message" => "vous n'êtes pas autorisé à modifier cet cagnotte"], 403);
        }

        if ($request->validated("title") !== $campaign->title) {
            $campaign->slug = Str::slug($request->validated("title"));
        }

        $campaign->update($request->validated());

        return response()->json(["message" => "Cagnotte mis à jour avec succès", "campaign" => $campaign]);
    }

    public function destroy(string $slug, string $id): JsonResponse
    {
        $campaign = Campaign::where("id", $id)->where('slug', $slug)->firstOrFail();


        if ($campaign->user_id !== Auth::id()) {
            return response()->json(["message" => "vous n'êtes pas autorisé à supprimer cet cagnotte"], 403);
        }

        $campaign->delete();

        return response()->json(["message" => "Cagnotte surrpimée avec succès"]);
    }
}
