<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendStripeEmailJob;
use App\Mail\StripeEmail;
use App\Models\Campaign;
use App\Models\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebHookController extends Controller
{
  /**
   * Permet de capturer les différents évenements lors du payement via Stripe
   *
   * @param Request $request
   * @return JsonResponse
   */
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
      SendStripeEmailJob::dispatch($event->data->object->customer_email, new StripeEmail($this->emailData($event)))->delay(now()->addSeconds(30));
    }

    return response()->json(['message' => 'WebHook received']);
  }

  /***env
   * Cette permet de mettre à jour le montant ed la cagnotte et de créer le participant qui sera lié
   *
   * @param Event $event
   * @return void
   */
  private function createParticipant(Event $event): void
  {
    $campaign = Campaign::where('id', $event->data->object->metadata->campaign_id)->first();

    if ($campaign) {
      $campaign->collected_amount += $event->data->object->amount_total;
      $campaign->save();

      Participant::create([
        "name" => $event->data->object->metadata->names,
        "email" => $event->data->object->customer_email,
        "amount" => $event->data->object->amount_total,
        "campaign_id" => $campaign->id
      ]);
    }
  }

  /**
   * C'est un tableau de donnée afin de trasnmettre les données dans l'email à envoyer
   *
   * @param Event $event
   * @return array
   */
  private function emailData(Event $event): array
  {
    return [
      "names" => $event->data->object->metadata->names,
      "title_campaign" => $event->data->object->metadata->title_campaign,
      "amount" => $event->data->object->amount_total,
    ];
  }
}
