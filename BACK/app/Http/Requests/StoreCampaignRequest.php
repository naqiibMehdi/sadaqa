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
            "target_amount" => "required|numeric",
            "limit_date" => "nullable|date",
            "category_id" => "required|numeric",
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
            "image.*" => [
                "max" => "La taille de l'image doit être inférieur à 2MB",
                "mimes" => "format accepté: jpeg, png, jpg, webp.",
            ],
            "target_amount.*" => [
                "required" => "Le montant à atteindre est obligatoire",
                "numeric" => "Le montant comporte doit seulement des chiffres",
            ],
            "limit_date" => [
                "date" => "la date doit être au bon format"
            ],
            "category_id" => [
                "required" => "La catégorie  est obligatoire.",
            ],
        ];
    }
}
