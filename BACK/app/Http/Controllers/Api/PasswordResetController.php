<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
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

            $url = url("/reset-password/{$token}");

            Mail::to($user->email)->send(new ResetPassword($url));

            return response()->json(["message" => "Un lien de réinitialisation a été envoyé"], 200);
        }


        return response()->json(["message" => "échec de l'envoi du lien de réinitialisation"], 500);
    }

    public function resetPassword()
    {

    }
}
