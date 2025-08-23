<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UrlHelper;
use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): View|Application|Factory
  {
    $contacts = ContactRequest::query()->orderBy("created_at", "desc")->paginate(10);
    $contacts->withPath(UrlHelper::assetUrl("admin/contacts"));
    return view("admin.contacts.index", compact("contacts"));
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
  public function show(ContactRequest $contact): View|Application|Factory
  {
    return view("admin.contacts.show", compact("contact"));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(ContactRequest $contact)
  {
    $statusLabel = ["pending" => "En cours", "processed" => "Traité"];
    return view("admin.contacts.edit", compact("contact", "statusLabel"));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, ContactRequest $contact)
  {
    $validated = $request->validate(["status" => "required|in:pending,processed"]);

    $contact->update($validated);

    return redirect(UrlHelper::assetUrl('admin/contacts'))->with("success", "Status de la demande mis à jour");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ContactRequest $contact)
  {
    $contact->delete();

    return redirect(UrlHelper::assetUrl('admin/contacts'))
      ->with('success', 'Demande du support supprimée avec succès.');
  }
}
