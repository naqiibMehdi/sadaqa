<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactRequest;
use App\Jobs\SendEmailJob;
use App\Mail\ContactEmail;
use App\Models\ContactRequest;

class ContactRequestController extends Controller
{
  public function store(CreateContactRequest $request)
  {
    $validated = $request->validated();

    SendEmailJob::dispatch(str($validated['email'])->lower(), new ContactEmail())->delay(now()->addSeconds(10));

    $contactRequest = ContactRequest::create($validated);

    return response()->json($contactRequest, 201);
  }
}
