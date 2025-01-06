<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "address" => "required|string",
            "city" => "required|string",
            "postal_code" => ["required", "regex:/^[0-9]{5}$/", "min:5", "max:5"],
            "country" => "required|string",
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
            "address.required" => "L'adresse est obligatoire.",
            "city.required" => "La ville est obligatoire.",
            "postal_code.*" => [
                "required" => "Le code postal est obligatoire.",
                "regex" => "le code postal doit être au format suivant '00000'.",
            ],
            "country.required" => "Le pays est obligatoire.",
        ];
    }
}
