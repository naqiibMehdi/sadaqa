<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class UserController extends Controller
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
            "password" => $request->input('password'),
            "subscribe_date" => Carbon::now(),
            "img_profile" => "logo.png",
        ]);


        return response()->json(["message" => "votre compte a été créer avec succès"], 201);
    }

}
