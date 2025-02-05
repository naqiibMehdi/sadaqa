<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
  /**
   * Retourne l'url absolue de l'image uploadé
   *
   * @param Request $request
   * @return JsonResponse
   *
   */
  public function upload(Request $request): JsonResponse
  {
    $rules = [
      "image" => "required|image|mimes:jpeg,png,jpg,webp,svg|max:1024"
    ];

    $messages = [
      "image.*" => [
        "required" => "L'image est requise",
        "image" => "le fichier doit etre une image",
        "mimes" => "Seules les extensions png, jpeg, webp et svg sont acceptées",
        "max" => "La taille de votre image doit etre inférieur à 1MB"
      ]
    ];

    $validated = Validator::make($request->all(), $rules, $messages);

    if (!$request->hasFile('image')) {
      return response()->json(["erreur" => "aucune image envoyée"], 400);
    }

    if ($validated->fails()) {
      return response()->json($validated->errors()->first(), 422);
    }

    $path = $request->file("image")->store('images', 'public');
    $fullImageUrl = asset(Storage::url($path));

    return response()->json(["url" => $fullImageUrl]);
  }
}
