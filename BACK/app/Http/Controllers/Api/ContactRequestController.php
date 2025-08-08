<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactRequest;
use App\Jobs\SendEmailJob;
use App\Mail\ContactEmail;
use App\Models\ContactRequest;
use Illuminate\Http\JsonResponse;

/**
 * @group Contacts
 *
 */
class ContactRequestController extends Controller
{
  /**
   * @param CreateContactRequest $request
   * @return JsonResponse
   */
  public function store(CreateContactRequest $request): JsonResponse
  {
    $validated = $request->validated();

    SendEmailJob::dispatch(str($validated['email'])->lower(), new ContactEmail())->delay(now()->addSeconds(10));

    $contactRequest = ContactRequest::create($validated);

    return response()->json($contactRequest, 201);
  }
}
