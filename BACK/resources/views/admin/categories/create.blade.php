@extends('admin.layouts.app')

@section('title', 'Modifier la catégorie')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Créer une nouvelle catégorie</h1>
        <p class="text-gray-600">Ajout d'une catégorie sur la plate-forme</p>
      </div>
      <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/categories") }}"
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-arrow-left mr-2"></i>Retour
      </a>
    </div>
  </div>

  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">
          <i class="fas fa-edit mr-2"></i>Informations de la nouvelle catégorie
        </h2>
      </div>
      <form method="POST" action="{{ \App\Helpers\UrlHelper::assetUrl("admin/categories")  }}"
            class="p-6">
        @csrf

        <div class="grid grid-cols-1 gap-6">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
              Label <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                   required>
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="translate_name" class="block text-sm font-medium text-gray-700 mb-2">
              Label traduis <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   id="translate_name"
                   name="translate_name"
                   value="{{ old('translate_name') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('translate_name') border-red-500 @enderror"
                   required>
            @error('translate_name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>


          <!-- Boutons -->
          <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/categories")  }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
              Annuler
            </a>
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
              <i class="fas fa-save mr-2"></i>Enregistrer les modifications
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
