<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCampaignRecoveryFormRequest;
use App\Http\Resources\CampaignRecoveryRessource;
use App\Models\Campaign;
use App\Models\CampaignRecovery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class CampaignRecoveryController extends Controller
{
  /**
   * @param string $id
   * @param CreateCampaignRecoveryFormRequest $request
   * @return JsonResponse
   */
  public function requestTransfer(string $id, CreateCampaignRecoveryFormRequest $request): JsonResponse
  {
    $validated = $request->validated();
    $recovery = CampaignRecovery::where("campaign_id", $id)->where("user_id", auth()->id())->first();
    $campaign = Campaign::where("id", $id)->first();

    if (!$campaign) {
      return response()->json(["message" => "Cette cagnotte n'existe pas"], 404);
    }

    if (!$campaign->closing_date) {
      return response()->json(["message" => "Vous ne pouvez pas demander un virement pour une cagnotte non clôturée"], 403);
    }

    if ($recovery) {
      return response()->json(["message" => "Une demande de virement a déjà été effectuée"], 403);
    }


    $newRecovery = CampaignRecovery::create([
      "campaign_id" => $campaign->id,
      "user_id" => auth()->id(),
      "amount" => $campaign->collected_amount,
      "iban" => Crypt::encrypt($validated["iban"]),
    ]);

    return response()->json(["message" => "Votre demande de virement a été enregistrée avec succès", "data" => new CampaignRecoveryRessource($newRecovery)]);
  }

  /**
   * @return JsonResponse
   */
  public function getRecoveriesFromUser(): JsonResponse
  {
    $recoveries = CampaignRecovery::with('campaign')->where("user_id", auth()->id())->get();
    if ($recoveries->isEmpty()) {
      return response()->json(["success" => false, "message" => "Vous n'avez aucune demande de virement en cours"], 401);
    }
    return response()->json(["data" => CampaignRecoveryRessource::collection($recoveries)]);
  }
}
