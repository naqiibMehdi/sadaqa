<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CampaignController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(["campaigns" => Campaign::paginate(9)]);
    }


    public function show(string $id): JsonResponse
    {
        $campaign = Campaign::find($id);
        return response()->json(["campaign" => !$campaign ? [] : $campaign]);
    }

    public function store(StoreCampaignRequest $request): JsonResponse
    {
        Campaign::create([
            "title" => $request->input("title"),
            "description" => $request->input("description"),
            "image" => "default.png",
            "target_amount" => $request->input("target_amount"),
            "collected_amount" => 0,
            "limit_date" => $request->input("limit_date"),
            "category_id" => $request->input("category_id"),
            "user_id" => auth()->id()
        ]);

        return response()->json(["message" => "votre cagnotte a été créée avec succès !"]);
    }
}
