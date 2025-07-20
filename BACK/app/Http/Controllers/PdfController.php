<?php

namespace App\Http\Controllers;

use App\Models\CampaignRecovery;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
  /**
   * @param string $id
   * @return ResponseFactory|Application|JsonResponse|Response
   */
  public function generatePdf(string $id): ResponseFactory|Application|JsonResponse|Response
  {
    $campaignRecovery = CampaignRecovery::with('campaign', 'user')
      ->where('id', $id)
      ->first();

    if (!$campaignRecovery) {
      return response()->json(["message" => "Cette cagnotte n'existe pas"], 404);
    }

    if ($campaignRecovery->user_id !== Auth::id()) {
      return response()->json(["message" => "Vous n'êtes pas autorisé à accéder à ce récapitulatif"], 403);
    }

    // Générer le PDF avec DomPDF
    $pdf = Pdf::loadView('pdf.campaign-summary', compact('campaignRecovery'));

    return response($pdf->output(), 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'inline; filename="cagnotte-' . $campaignRecovery->campaign->slug . '-resume.pdf"',
    ]);
  }
}
