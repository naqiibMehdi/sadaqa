<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactRequest;
use App\Models\ContactRequest;

class ContactRequestController extends Controller
{
  public function store(CreateContactRequest $request)
  {
    $validated = $request->validated();

    $contactRequest = ContactRequest::create($validated);

    return response()->json($contactRequest, 201);
  }
}
