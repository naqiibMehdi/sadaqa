<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreUpdateUserProfileFormRequest extends FormRequest
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
      "name" => "required|string|max:255",
      "first_name" => "required|string|max:255",
      "email" => [
        "required",
        "email",
        "max:255",
        Rule::unique('users', 'email')->ignore($userId)
      ],
      "image" => "nullable|image|mimes:jpeg,png,jpg,webp|max:1024"
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
      "name.*" => [
        "required" => "Le nom de famille est obligatoire.",
        "string" => "Le nom de famille doit être du texte.",
        "max" => "Le nom doit être inférieur à 255 caractères"
      ],
      "first_name.*" => [
        "required" => "Le prénom est obligatoire",
        "string" => "Le prénom doit être du texte",
        "max" => "Le prénom doit être inférieur à 255 caractères"
      ],
      "email.*" => [
        "required" => "L'email est obligatoire",
        "unique" => "L'email existe déjà",
        "email" => "L'email n'est pas au bon format",
      ],
      "image" => [
        "image" => "Le fichier à joindre doit être de type image",
        "mimes" => "Seul les formats suivants sont acceptés: jpg,jpeg,png,webp",
        "max" => "La taille maximale est de 1MB"
      ]
    ];
  }
}
