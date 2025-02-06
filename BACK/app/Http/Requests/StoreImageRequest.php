<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
      "image" => ["image", "mimes:jpeg,png,webp,svg", "max:1024"],
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
      "image.*" => [
        "image" => "Le fichier doit être une image",
        "mimes" => "Seules les extensions png, jpeg, webp et svg sont acceptées",
        "max" => "La taille de votre image doit être inférieur à 1MB"
      ]
    ];
  }
}
