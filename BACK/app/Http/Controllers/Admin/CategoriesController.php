<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UrlHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $categories = Category::query()->paginate(10)->withPath(UrlHelper::assetUrl('admin/categories'));

    return view('admin.categories.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.categories.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $rules = [
      'name' => 'required|string|min:5|max:255',
      'translate_name' => 'required|string|min:4|max:255',
    ];

    $messages = [
      "name.required" => "Le nom est obligatoire",
      "name.string" => "Le nom doit être au format texte",
      "name.max" => "255 caractères maximum",
      "name.min" => ":min caractères minimum",
      "translate_name.required" => "Le nom est obligatoire",
      "translate_name.string" => "Le nom doit être au format texte",
      "translate_name.max" => "255 caractères maximum",
      "translate_name.min" => ":min caractères minimum",
    ];

    $validated = $request->validate($rules, $messages);

    Category::create($validated);

    return redirect(UrlHelper::assetUrl('admin/categories'))->with("success", "Catégorie créée avec succès");
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Category $category)
  {
    return view('admin.categories.edit', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Category $category)
  {
    $rules = [
      'name' => 'required|string|min:5|max:255',
      'translate_name' => 'required|string|min:4|max:255',
    ];

    $messages = [
      "name.required" => "Le nom est obligatoire",
      "name.string" => "Le nom doit être au format texte",
      "name.max" => "255 caractères maximum",
      "name.min" => ":min caractères minimum",
      "translate_name.required" => "Le nom est obligatoire",
      "translate_name.string" => "Le nom doit être au format texte",
      "translate_name.max" => "255 caractères maximum",
      "translate_name.min" => ":min caractères minimum",
    ];

    $validated = $request->validate($rules, $messages);

    $category->update($validated);

    return redirect(UrlHelper::assetUrl('admin/categories'))->with("success", "Catégorie mise à jour avec succès");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Category $category)
  {
    $category->delete();

    return redirect(UrlHelper::assetUrl("admin/categories"))->with("success", "Catégorie supprimée avec succès");
  }
}
