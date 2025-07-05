<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCampaignRecoveryFormRequest;
use App\Models\Campaign;
use App\Models\CampaignRecovery;
use Illuminate\Support\Facades\Crypt;

class CampaignRecoveryController extends Controller
{
  public function requestTransfer(string $id, CreateCampaignRecoveryFormRequest $request)
  {
    $validated = $request->validated();
    $recovery = CampaignRecovery::where("campaign_id", $id)->where("user_id", auth()->id())->first();
    $campaign = Campaign::where("id", $id)->first();

    if (!$campaign) {
      return response()->json(["message" => "Cette cagnotte n'existe pas"]);
    }

    if (!$campaign->closing_date) {
      return response()->json(["message" => "Vous ne pouvez pas demander un virement pour une cagnotte non clôturée"]);
    }

    if ($recovery) {
      return response()->json(["message" => "Une demande de virement a déjà été effectuée"]);
    }


    $newRecovery = CampaignRecovery::create([
      "campaign_id" => $campaign->id,
      "user_id" => auth()->id(),
      "amount" => $campaign->collected_amount,
      "iban" => Crypt::encrypt($validated["iban"]),
    ]);

    return response()->json(["message" => "Votre demande de virement a été enregistrée avec succès", "data" => $newRecovery]);
  }
}
