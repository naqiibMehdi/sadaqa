<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UrlHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): View|Application|Factory
  {
    $campaigns = Campaign::with("user")->orderBy("created_at", "desc")->paginate(10);

    return view("admin.campaigns.index", compact("campaigns"));
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
  public function show(Campaign $campaign): View|Application|Factory
  {
    return view("admin.campaigns.show", compact("campaign"));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Campaign $campaign): View|Application|Factory
  {
    $categories = Category::all();
    return view("admin.campaigns.edit", compact("campaign"))->with("categories", $categories);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StoreCampaignRequest $request, Campaign $campaign): RedirectResponse
  {
    $validated = $request->validated();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      // Supprimer l'ancienne image si elle existe et n'est pas une URL externe
      if ($campaign->image && !Str::startsWith($campaign->image, 'campaigns/default')) {
        Storage::disk('public')->delete($campaign->image);
      }

      // Stocker la nouvelle image
      $imagePath = $request->file('image')->store('campaigns', 'public');
      $validated["image"] = $imagePath;

    }

    $campaign->slug = Str::slug($request->title);

    $campaign->update($validated);
    return redirect(UrlHelper::assetUrl("admin/campaigns/{$campaign->id}"));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
