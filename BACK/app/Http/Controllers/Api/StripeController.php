<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
  public function createCheckoutSession(string $slug, string $id, Request $request): JsonResponse
  {
    $rules = ([
      "name" => "required|string|min:3",
      "email" => "required|email",
      "amount" => "required|numeric|min:1",
    ]);

    $messages = [
      "name.*" => [
        "required" => "Le nom et prénom sont obligatoires",
        "string" => "Le nom et prénom doivent être du texte",
        "min" => "Il faut au minimum 3 caractères pour le nom et prénom"
      ],
      "email.*" => [
        "required" => "L'email est obligatoire",
        "email" => "L'email doit être au bon format",
      ],
      "amount.*" => [
        "required" => "Le montant est obligatoire",
        "min" => "Le montant doit être au minimum de 1 euro",
      ]
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    Stripe::setApiKey(env('STRIPE_SECRET'));
    Stripe::setApiVersion(env('STRIPE_VERSION_API'));

    $campaign = Campaign::where("id", $id)->where("slug", $slug)->first();

    if (!$campaign) {
      return response()->json(["message" => "Cette Cagnotte est inexistante"], 404);
    }

    if ($campaign->closing_date) {
      return response()->json(["message" => "Impossible de faire un don pour une cagnotte clôturée."], 404);
    }

    $checkoutSession = Session::create([
      "line_items" => [
        [
          "price_data" => [
            "currency" => "eur",
            "product_data" => [
              "name" => $campaign->title,
            ],
            "unit_amount" => $request->amount * 100,
          ],
          "quantity" => 1,
        ]
      ],
      "payment_method_types" => ["card"],
      "customer_email" => Str::lower($request->email),
      "mode" => "payment",
      "metadata" => ["campaign_id" => $campaign->id, "names" => $request->name, "title_campaign" => $campaign->title],
      "success_url" => env("APP_FRONT") . "/campaigns/{$slug}-{$id}/?success=1",
      "cancel_url" => env("APP_FRONT") . "/campaigns/{$slug}-{$id}/?cancel=1",

    ]);

    Participant::create([
      "name" => $request->name,
      "email" => Str::lower($request->email),
      "amount" => $request->amount * 100,
      "campaign_id" => $campaign->id,
    ]);

    return response()->json(["session_checkout_id" => $checkoutSession->id]);

  }
}
