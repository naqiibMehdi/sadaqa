<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @group Images
 * @authenticated
 */
class ImageController extends Controller
{
  /**
   * Retourne l'url absolue de l'image uploadé
   *
   * @param StoreImageRequest $request
   * @return JsonResponse
   *
   */
  public function upload(StoreImageRequest $request): JsonResponse
  {


    $path = $request->file("image")->store('images', 'public');
    $fullImageUrl = asset(Storage::url($path));

    return response()->json(["url" => $fullImageUrl]);
  }

  /**
   * Permet de supprimer l'image dans l'éditeur de la cagnotte
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function delete(Request $request): JsonResponse
  {
    $fileName = basename($request->input("url"));

    if (Storage::disk("public")->exists("images/$fileName")) {
      Storage::disk("public")->delete("images/$fileName");
      return response()->json(["success" => true]);
    }

    return response()->json(["erreur" => "Image introuvable"]);

  }
}
