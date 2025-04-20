<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResetPasswordRequest extends FormRequest
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
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'password' => ["required", "confirmed", "regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/"],
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
      "password.*" => [
        "required" => "Le mot de passe est obligatoire",
        "confirmed" => "Le second mot de passe ne correspond pas au premier mot de passe",
        "regex" => "Le mot de passe doit contenir au moins 8 caractères,  une majuscule, une minuscule, un chiffre et un caractère spécial"
      ]
    ];
  }
}
