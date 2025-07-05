<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateCampaignRecoveryFormRequest extends FormRequest
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
      "iban" => [
        "required",
        "string",
        "size:27",
        Rule::unique('ibans')->where(function ($query) {
          return $query->where('user_id', Auth::id());
        }),
        "regex:/^FR[\dA-Z]{25}$/i"
      ]
    ];
  }

  public function messages(): array
  {
    return [
      'iban.required' => 'L\'IBAN est requis.',
      'iban.string' => 'L\'IBAN doit être une chaîne de caractères.',
      'iban.size' => 'L\'IBAN doit contenir 27 caractères.',
      'iban.unique' => 'Cet IBAN est déjà enregistré pour cet utilisateur.',
      'iban.regex' => 'Le format de l\'IBAN est invalide.',
    ];
  }
}
