<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIbanFormRequest;
use App\Models\Iban;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class IbanController extends Controller
{
  /**
   * Permet d'enregistre l'Iban de l'utilisateur
   *
   * @param StoreIbanFormRequest $request
   * @return JsonResponse
   */
  public function store(StoreIbanFormRequest $request): JsonResponse
  {
    $iban = $request->get("iban");

    $ibanEncrypted = Crypt::encrypt($iban);

    Iban::create([
      "iban" => $ibanEncrypted,
      "user_id" => auth()->id(),
    ]);

    return response()->json(["message" => "IBAN enregistré avec succès", "data" => $iban]);
  }

  public function edit(StoreIbanFormRequest $request): JsonResponse
  {
    $iban = $request->get("iban");

    $ibanEncrypted = Crypt::encrypt($iban);

    Iban::where("user_id", auth()->id())->update(["iban" => $ibanEncrypted]);

    return response()->json(["message" => "IBAN modifié avec succès", "data" => $iban]);
  }

  /**
   * Permet de récupérer l'Iban
   *
   * @return JsonResponse
   */
  public function show(): JsonResponse
  {
    $iban = Iban::where("user_id", auth()->id())->first();

    if ($iban) {
      return response()->json(["data" => ["iban" => Crypt::decrypt($iban->iban)]]);
    }

    return response()->json(["data" => ["iban" => null]]);
  }

  public function destroy(): JsonResponse
  {
    Iban::where("user_id", auth()->id())->delete();

    return response()->json(["message" => "IBAN supprimé avec succès"]);
  }

}
