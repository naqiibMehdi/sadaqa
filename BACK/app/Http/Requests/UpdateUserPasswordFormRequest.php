<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use function Laravel\Prompts\password;

class UpdateUserPasswordFormRequest extends FormRequest
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
    return [
      "password" => ["required", "confirmed", "regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/"]
    ];
  }

  public function messages(): array
  {
    return [
      "password" => [
        "required" => "Le mot de passe est obligatoire",
        "confirmed" => "Les 2 mot de passe ne correspondent pas",
        "regex" => "minimum: 8 caractères, 1 minuscule, 1 majuscule, 1 chiffre, 1 caractère spécial"
      ]
    ];
  }
}
