<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
{

  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'email' => ['required', 'email', 'max:254'],
      'description' => ['required', "string", "min:10", 'max:2000'],
    ];
  }

  public function messages(): array
  {
    return [
      "email.*" => [
        "email" => "L'email n'est pas au bon format",
        "required" => "L'email est obligatoire",
        "max" => "La taille maximale de l'email est de 254 caractères"
      ],
      "description.*" => [
        "required" => "La description est obligatoire",
        "min" => "La description doit contenir au minimum :min caractères",
        "max" => "La taille maximale est de :max caractères"
      ]
    ];
  }
}
