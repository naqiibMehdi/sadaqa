<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampaignRecovery;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CampaignRecoveryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): View|Application|Factory
  {
    $recoveries = CampaignRecovery::with([
      "user" => fn($query) => $query->select("id", "name", "first_name"),
      "campaign" => fn($query) => $query->select("id", "title")
    ])->orderBy("created_at", "desc")->paginate(10);

    return view("admin.recoveries.index", compact("recoveries"));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(CampaignRecovery $recovery): View|Application|Factory
  {
    return view("admin.recoveries.show", compact("recovery"));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(CampaignRecovery $recovery): Factory|Application|View
  {
    $statusLabel = [
      "pending" => "En cours",
      "processed" => "Validé",
      "failed" => "Échec"
    ];

    return view("admin.recoveries.edit", compact("recovery", "statusLabel"));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, CampaignRecovery $recovery): RedirectResponse
  {
    $validated = $request->validate(["status" => "required|in:pending,processed,failed"]);

    $recovery->update($validated);

    return redirect()->route("admin.recoveries.index")->with("success", "Status du virement mis à jour");

  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
