<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterUserRequest extends FormRequest
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
      "name" => "required|string|max:255",
      "first_name" => "required|string|max:255",
      "public_name" => "required|string|max:255",
      "birth_date" => "required|date",
      "email" => "required|email|max:255|unique:users,email",
      "password" => ["required", "confirmed", "regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/"],
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
      "name.required" => "Le nom de famille est obligatoire.",
      "name.string" => "Le nom de famille doit être du texte.",
      "first_name.required" => "Le prénom est obligatoire",
      "first_name.string" => "Le prénom doit être du texte",
      "public_name.required" => "Le nom publique est obligatoire",
      "public_name.max" => "Le nom publique ne doit pas dépassé 255 caractères",
      "birth_date.required" => "La date de naissance est obligatoire",
      "birth_date.date_format" => "La date de naissance doit être au format suivant: jj/mm/yyyy",
      "email.required" => "L'email est obligatoire",
      "email.unique" => "L'email existe déjà",
      "email.email" => "L'email n'est pas au bon format",
      "password.required" => "Le mot de passe est obligatoire",
      "password.confirmed" => "Le champ de confirmation de mot de passe n'est pas valide",
      "password.regex" => "Le mot de passe doit contenir au moins 8 caractères,  une majuscule, une minuscule, un chiffre et un caractère spécial",
    ];
  }
}
