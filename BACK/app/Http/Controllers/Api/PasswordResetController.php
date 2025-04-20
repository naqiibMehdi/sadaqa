<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResetPasswordRequest;
use App\Jobs\SendEmailJob;
use App\Mail\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
  /**
   * Permet d'envoyer par mail un lien pour réinitialiser le mot de passe
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function sendResetLinkEmail(Request $request): JsonResponse
  {
    $rules = [
      'email' => 'required|email|exists:users,email'
    ];

    $messages = [
      "required" => "l'email est obligatoire",
      "email" => "L'email doit être au bon format",
      "exists" => "Cet email n'existe pas",
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $user = User::where("email", $request->input("email"))->first();

    if ($user) {
      $token = Str::random(60);

      DB::table("password_reset_tokens")->updateOrInsert(
        ["email" => $request->input("email")],
        [
          "token" => Hash::make($token),
          "created_at" => now()
        ]
      );

      $url = env("APP_FRONT") . "/reset-password?token=$token&email={$request->input("email")}";

      SendEmailJob::dispatch($user->email, new ResetPassword($url))->delay(now()->addSeconds(10));

      return response()->json(["message" => "Un lien de réinitialisation a été envoyé sur votre boite mail"]);
    }


    return response()->json(["message" => "échec de l'envoi du lien de réinitialisation"], 500);
  }

  /**
   * Permet de réinitialiser le mot de passe en vérifiant l'email et le token
   *
   * @param StoreResetPasswordRequest $request
   * @return JsonResponse
   */
  public function resetPassword(StoreResetPasswordRequest $request): JsonResponse

  {
    $getDataResetPassword = DB::table('password_reset_tokens')->where("email", $request->input('email'))->first();

    if (!$getDataResetPassword) {
      return response()->json(["message" => "Cette adresse email n'existe pas"], 401);
    }

    $timestamp = Carbon::parse($getDataResetPassword->created_at);
    if ($timestamp->diffInMinutes(Carbon::now()) > 5) {
      return response()->json(["message" => "Le lien a expiré, vous devez saisir votre email afin de recevoir un nouveau lien"], 401);
    }

    $checkToken = Hash::check($request->input("token"), $getDataResetPassword->token);
    if (!$checkToken) {
      return response()->json(["message" => "Vous n'êtes pas autorisé à changer de mot de passe"], 401);
    }

    User::where("email", $request->input("email"))->update(["password" => Hash::make($request->input("password"))]);

    DB::table("password_reset_tokens")->where("email", $request->input("email"))->delete();

    return response()->json(["message" => "Le mot de passe a bien été modifié avec succès"]);
  }
}
