<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function createCheckoutSession(string $slug, string $id, Request $request): JsonResponse
    {
        $rules = ([
            "name" => "required|string|min:5",
            "email" => "required|email",
            "amount" => "required|numeric|min:1",
        ]);

        $messages = [
            "name.*" => [
                "required" => "Le nom et prénom sont obligatoires",
                "string" => "Le nom et prénom doivent être du texte",
                "min" => "Il faut au minimum 5 caractères pour le nom et prénom"
            ],
            "email.*" => [
                "required" => "L'email est obligatoire",
                "email" => "L'email doit être au bon format",
            ],
            "amount.*" => [
                "required" => "Le montant est obligatoire",
                "min" => "Le montant doit être au minimum de 1 euros",
            ]
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe::setApiVersion('2024-12-18.acacia');

        $campaign = Campaign::where("id", $id)->where("slug", $slug)->first();

        if (!$campaign) {
            return response()->json(["message" => "Cette Cagnotte est inexistante"], 404);
        }

        $checkoutSession = Session::create([
            "line_items" => [
                [
                    "price_data" => [
                        "currency" => "eur",
                        "product_data" => [
                            "name" => $campaign->title,
                        ],
                        "unit_amount" => $request->amount,
                    ],
                    "quantity" => 1,
                ]
            ],
            "payment_method_types" => ["card"],
            "customer_email" => $request->email,
            "mode" => "payment",
            "metadata" => ["campaign_id" => $campaign->id, "names" => $request->name, "title_campaign" => $campaign->title],
            "success_url" => "http://localhost:8000/{$slug}-{$id}/?success",
            "cancel_url" => "http://localhost:8000/{$slug}-{$id}/?cancel",

        ]);
        return response()->json(["session_checkout_id" => $checkoutSession->url]);

    }
}
