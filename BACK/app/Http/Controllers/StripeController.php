<?php

namespace App\Http\Controllers;

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
            "email" => "required|email",
            "amount" => "required|numeric|min:1",
        ]);

        $messages = [
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
            "metadata" => ["campaign_id" => $campaign->id],
            "success_url" => "http://localhost:8000/success",
            "cancel_url" => "http://localhost:8000/cancel",

        ]);
        return response()->json(["session_checkout_id" => $checkoutSession->id]);

    }
}
