<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => "l'adresse email est invalide ou inexistante"], 422);
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

            $url = url("/reset-password?token={$token}&email={$request->input("email")}");

            Mail::to($user->email)->send(new ResetPassword($url));

            return response()->json(["message" => "Un lien de réinitialisation a été envoyé"], 200);
        }


        return response()->json(["message" => "échec de l'envoi du lien de réinitialisation"], 500);
    }

    /**
     * Permet de réinitialiser le mot de passe en vérifiant l'email et le token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse

    {
        $getDataResetPassword = DB::table('password_reset_tokens')->where("email", $request->input('email'))->first();

        if (!$getDataResetPassword) {
            return response()->json(["message" => "Cette adresse email n'existe pas"], 401);
        }

        $timestamp = Carbon::parse($getDataResetPassword->created_at);
        if ($timestamp->diffInMinutes(Carbon::now()) > 5) {
            return response()->json(["message" => "le token a expiré"], 401);
        }

        $checkToken = Hash::check($request->input("token"), $getDataResetPassword->token);
        if (!$checkToken) {
            return response()->json(["message" => "Vous n'êtes pas autorisé à changer de mot de passe"], 401);
        }

        User::where("email", $request->input("email"))->update(["password" => Hash::make($request->input("password"))]);

        DB::table("password_reset_tokens")->where("email", $request->input("email"))->delete();

        return response()->json(["message" => "Le mot de passe a bien été modifié"]);
    }
}
