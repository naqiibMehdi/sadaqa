<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
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
      "title" => "required|string",
      "description" => "required|string",
      "image" => "nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
      "target_amount" => "required|numeric|min:1",
      "limit_date" => "nullable|date",
      "category_id" => "required|numeric|exists:categories,id",
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
      "title.required" => "Le titre est obligatoire.",
      "description.required" => "La description est obligatoire.",
      "description.max" => "65535 caractères maximum",
      "image.*" => [
        "max" => "La taille de l'image doit être inférieur à 2MB",
        "mimes" => "format accepté: jpeg, png, jpg, webp.",
      ],
      "target_amount.*" => [
        "required" => "Le montant à atteindre est obligatoire",
        "numeric" => "Le montant  doit seulement comporter des chiffres",
        "min" => "Le montant minimal doit être de 1 euros"
      ],
      "limit_date" => [
        "date" => "la date doit être au bon format"
      ],
      "category_id" => [
        "required" => "La catégorie  est obligatoire.",
        "exists" => "Cette catégorie n'éxiste pas"
      ],
    ];
  }
}
