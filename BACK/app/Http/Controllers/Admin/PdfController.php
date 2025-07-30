<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampaignRecovery;
use App\Models\PdfDownload;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View
    {
        $downloads = PdfDownload::with("user", "campaign")->orderBy("downloaded_at", "desc")->paginate(10);
        return view("admin.pdf.index", compact("downloads"));
    }

    public function show(PdfDownload $pdf): Factory|Application|View
    {
        return view("admin.pdf.show", compact("pdf"));
    }

    public function downloadInvoice(CampaignRecovery $campaignRecovery): Application|Response|ResponseFactory
    {

        // Générer le PDF avec DomPDF
        $pdfFile = Pdf::loadView('pdf.campaign-summary', compact('campaignRecovery'));

        // Retourner le PDF avec les en-têtes appropriés pour l'ouverture dans une nouvelle fenêtre
        return response($pdfFile->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="facture-' . $campaignRecovery->campaign->slug . '-' . $campaignRecovery->id . '.pdf"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);

    }
}
