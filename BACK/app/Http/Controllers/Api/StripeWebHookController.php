<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\StripeEmail;
use App\Models\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

/**
 * @group Stripe Webhook
 */
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


    if ($event->type === "charge.failed") {
      $this->createPaymentIntent($event);
    }

    if ($event->type === "charge.succeeded") {
      $this->createPaymentIntent($event, "completed");
    }

    if ($event->type === "checkout.session.completed") {
      $this->handleCheckoutCompleted($event);
      SendEmailJob::dispatch($event->data->object->customer_email, new StripeEmail($this->emailData($event)))->delay(now()->addSeconds(10));
    }

    return response()->json(['message' => 'WebHook received']);
  }

  /**
   * Cette fonction permet de mettre à jour le montant ed la cagnotte et de créer le participant qui sera lié
   *
   * @param Event $event
   * @return void
   */
  private function handleCheckoutCompleted(Event $event): void
  {
    $participant = Participant::where('payment_id', $event->data->object->payment_intent)->first();

    if ($participant) {
      $participant->campaign->collected_amount += $event->data->object->amount_total;
      $participant->campaign->save();
    }
  }

  private function createPaymentIntent(Event $event, string $status = "failed"): void
  {
    $participant = Participant::where('email', $event->data->object->billing_details->email)->latest('participation_date')->first();
    if ($participant) {
      $participant->payment_id = $event->data->object->payment_intent;
      $participant->payment_status = $status;
      $participant->save();
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
