<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryRessource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Catégories
 *
 */
class CategoryController extends Controller
{
  public function index(): AnonymousResourceCollection
  {
    return CategoryRessource::collection(Category::all());
  }
}
