<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCreateAddressRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, ValidationRule|array|string>
   */
  public function rules(): array
  {
    $userId = Auth::id();

    return [
      "address" => "required|string",
      "city" => "required|string",
      "postal_code" => ["required", "regex:/^[0-9]{5}$/"],
      "country" => "required|string",
      "user_id" => [
        "exists:users,id",
        "unique:addresses,user_id"
      ],
    ];

  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array<string, string>
   */
  public function messages(): array
  {
    return [
      "address.*" => [
        "required" => "L'adresse est obligatoire.",
        "string" => "L'adresse doit être de type texte.",
      ],
      "city.*" => [
        "required" => "La ville est obligatoire.",
        "string" => "La ville doit être de type texte.",
      ],
      "postal_code.*" => [
        "required" => "Le code postal est obligatoire.",
        "regex" => "le code postal doit être de 5 chiffres.",
      ],
      "country.*" => [
        "required" => "Le pays est obligatoire.",
        "string" => "Le pays doit être de type texte.",
      ],
      "user_id.*" => [
//        "required" => "l'utilisateur est obligatoire",
//        "exists" => "L'utilisateur n'existe pas",
        "unique" => "L'utilisateur possède déjà une adresse",
        "numeric" => "L'id doit être de type numérique"
      ],
    ];
  }
}
