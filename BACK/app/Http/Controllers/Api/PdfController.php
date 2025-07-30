<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CampaignRecovery;
use App\Models\PdfDownload;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
  /**
   * @param string $id
   * @param Request $request
   * @return ResponseFactory|Application|JsonResponse|Response
   */
  public function generatePdf(string $id, Request $request): ResponseFactory|Application|JsonResponse|Response
  {
    $campaignRecovery = CampaignRecovery::with('campaign', 'user')
      ->where('id', $id)
      ->first();

    if (!$campaignRecovery) {
      return response()->json(["message" => "Ce virement n'existe pas"], 404);
    }

    if ($campaignRecovery->user_id !== Auth::id()) {
      return response()->json(["message" => "Vous n'êtes pas autorisé à accéder à ce récapitulatif"], 403);
    }

    if (!$this->hasUserDownloaded($campaignRecovery->user_id, $campaignRecovery->campaign_id, 'invoice')) {
      $this->logPdfDownload(
        $campaignRecovery->user_id,
        $campaignRecovery->campaign_id,
        'cagnotte-' . $campaignRecovery->campaign->slug . '-resume.pdf',
        $request
      );
    }

    // Générer le PDF avec DomPDF
    $pdf = Pdf::loadView('pdf.campaign-summary', compact('campaignRecovery'));

    return response($pdf->output(), 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'inline; filename="cagnotte-' . $campaignRecovery->campaign->slug . '-resume.pdf"',
    ]);
  }

  /**
   * Enregistrer le téléchargement de PDF pour la traçabilité
   *
   * @param int $userId
   * @param int $campaignId
   * @param string $filename
   * @param Request $request
   * @return void
   */
  private function logPdfDownload(int $userId, int $campaignId, string $filename, Request $request): void
  {
    PdfDownload::create([
      'user_id' => $userId,
      'campaign_id' => $campaignId,
      'filename' => $filename,
      'ip_address' => $request->ip(),
      'user_agent' => $request->userAgent(),
      'downloaded_at' => now(),
    ]);
  }

  /**
   * @param int $user_id
   * @param int $campaign_id
   * @param string $document_type
   * @return bool
   */
  private function hasUserDownloaded(int $user_id, int $campaign_id, string $document_type): bool
  {
    return PdfDownload::where('user_id', $user_id)
      ->where('campaign_id', $campaign_id)
      ->where('document_type', $document_type)
      ->exists();
  }

}
