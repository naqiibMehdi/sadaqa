<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param StoreRegisterUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreRegisterUserRequest $request): JsonResponse
    {
        $replaceCharacterDate = Str::replace("/", "-", $request->input('birth_date'));

        User::create([
            "name" => $request->input('name'),
            "first_name" => $request->input('first_name'),
            "public_name" => $request->input('public_name'),
            "birth_date" => (new Carbon($replaceCharacterDate))->format('Y-m-d'),
            "email" => $request->input('email'),
            "password" => Hash::make($request->input('password')),
            "subscribe_date" => now(),
            "img_profile" => "https://ui-avatars.com/api/?name={$request->input("first_name")}+{$request->input("name")}&background=3078c0",
        ]);


        return response()->json(["message" => "votre compte a été créer avec succès"], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $rules = [
            "email" => "required|email",
            "password" => 'required'
        ];


        $messages = [
            "email.*" => [
                "required" => "L'email est obligatoire",
                "email" => "L'email n'est pas au bon format"
            ],
            "password.required" => "Le mot de passe est obligatoire"
        ];

        Validator::validate($request->all(), $rules, $messages);

        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "email ou mot de passe incorrect"]);
        }

        return response()->json(["token" => $user->createToken("MyToken")->plainTextToken]);

    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->each(function ($token) {
            $token->delete();
        });

        return response()->json(["message" => "token supprimé avec succès"]);

    }

}
