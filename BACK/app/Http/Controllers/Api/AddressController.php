<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreateAddressRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
  /**
   * Permet d'enregistre l'adresse postale
   *
   * @param StoreCreateAddressRequest $request
   * @return JsonResponse
   */
  public function registerAddress(StoreCreateAddressRequest $request): JsonResponse
  {
    $validated = $request->validated();

    $address = Address::create([...$validated, "user_id" => Auth::id()]);

    return response()->json(["message" => "Informations enregistrées avec succès", "data" => $address]);
  }

  /**
   * Permet de modifier l'addresse postale
   *
   * @param StoreCreateAddressRequest $request
   * @return JsonResponse
   */
  public function editAddress(StoreCreateAddressRequest $request): JsonResponse
  {
    $validated = $request->validated();

    $address = Address::where("user_id", Auth::id())->first();

    $address->update($validated);

    return response()->json(["message" => "Mise à jour de l'adresse avec succès", "data" => $address]);
  }

  /**
   * Permet de récupérer l'adresse postale
   *
   * @return JsonResponse
   */
  public function getAddress(): JsonResponse
  {
    $address = Address::where("user_id", Auth::id())->first();

    return response()->json(["data" => $address]);
  }
}


