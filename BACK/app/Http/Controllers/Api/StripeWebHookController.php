<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebHookController extends Controller
{
    public function webhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');
        $payload = $request->getcontent();
        $sigHeader = $request->header('STRIPE_SIGNATURE');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Echec de vérification de la signature Webhook'], 400);
        }

        if ($event->type === "checkout.session.completed") {
            $this->createParticipant($event);
        }
        return response()->json(['message' => 'WebHook received'], 200);
    }

    private function createParticipant(Event $event): void
    {
        $campaign = Campaign::where('id', $event->data->object->metadata->campaign_id)->first();

        if ($campaign) {
            $campaign->collected_amount += $event->data->object->amount_total;
            $campaign->save();

            Participant::create([
                "name" => $event->data->object->customer_details->name,
                "email" => $event->data->object->customer_email,
                "amount" => $event->data->object->amount_total,
                "campaign_id" => $campaign->id
            ]);
        }

    }
}
