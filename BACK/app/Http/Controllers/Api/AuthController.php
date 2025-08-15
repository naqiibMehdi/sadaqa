<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterUserRequest;
use App\Jobs\SendEmailJob;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @group Authentification
 */
class AuthController extends Controller
{
  /**
   * Créer un compte
   *
   * Permet à un utilisateur de créer un compte
   *
   * @param StoreRegisterUserRequest $request
   *
   * @bodyParam name string required Le nom de l'utilisateur. Example: Doe
   * @bodyParam first_name string required Le prénom de l'utilisateur. Example: John
   * @bodyParam public_name string required Le nom publique de l'utilisateur. Example: Pikachu
   * @bodyParam email string required Le mot de passe de l'utilisateur. Example: john@doe.fr
   * @bodyParam password string required Le mot de passe de l'utilisateur. Example: John1doe*
   * @bodyParam birth_date date required La date de naissance. Example: 26/03/2009
   *
   *
   * @return JsonResponse
   * @response  201 {
   *   "message": "votre compte a été crée avec succès"
   * }
   *
   * @response 422 {
   *  "message": "Le nom de famille est obligatoire. (and 5 more errors)",
   *  "errors": {
   *    "name": [
   *      "Le nom de famille est obligatoire."
   *    ],
   *    "first_name": [
   *      "Le prénom est obligatoire"
   *    ],
   *    "public_name": [
   *      "Le nom publique est obligatoire"
   *    ],
   *    "birth_date": [
   *      "La date de naissance est obligatoire"
   *    ],
   *    "email": [
   *      "L'email est obligatoire"
   *    ],
   *    "password": [
   *      "Le mot de passe est obligatoire"
   *    ]
   *  }
   * }
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

    SendEmailJob::dispatch($request->email, new WelcomeEmail())->delay(now()->addSeconds(10));


    return response()->json(["message" => "votre compte a été crée avec succès"], 201);
  }

  /**
   * Se connecter
   *
   * Permet à un utilisateur de se connecter avec ses identifiants
   *
   * @param Request $request
   *
   * @bodyParam email string required L'email de l'utilisateur. No-example
   * @bodyParam password string required Le mot de passe de l'utilisateur. No-example
   *
   * @return JsonResponse
   *
   * @response 200{
   *   "token": "!256fdgdfg8123gfdgdfgr"
   * }
   *
   * @response 422 {
   *  "message": "L'email est obligatoire (and 1 more error)",
   *  "errors": {
   *    "email": [
   *      "L'email est obligatoire"
   *    ],
   *   "password": [
   *      "Le mot de passe est obligatoire"
   *    ]
   *  }
   * }
   */
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
      return response()->json(["message" => "Email ou mot de passe incorrect"], 404);
    }

    return response()->json(["token" => $user->createToken("MyToken")->plainTextToken]);

  }

  /**
   * Se déconnecter
   *
   * Permet à un utilisateur de se déconnecter de sa session
   *
   * @authenticated
   *
   * @param Request $request
   * @return JsonResponse
   *
   * @response 200 {
   *   "message" => "token supprimé avec succès"
   * }
   */
  public function logout(Request $request): JsonResponse
  {
    $request->user()->tokens()->each(function ($token) {
      $token->delete();
    });

    return response()->json(["message" => "token supprimé avec succès"]);

  }

}
