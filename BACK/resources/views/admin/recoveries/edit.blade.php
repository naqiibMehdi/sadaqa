@extends('admin.layouts.app')

@section('title', 'Modifier le virement')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Modifier le virement</h1>
        <p class="text-gray-600">Modification des informations du virement concernant la
          cagnotte: {{$recovery->campaign->title}}</p>
      </div>
      <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/recoveries/$recovery->id") }}"
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-arrow-left mr-2"></i>Retour
      </a>
    </div>
  </div>

  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">
          <i class="fas fa-edit mr-2"></i>Informations du virement
        </h2>
      </div>
      <form method="POST" action="{{ \App\Helpers\UrlHelper::assetUrl("admin/recoveries/$recovery->id") }}"
            class="p-6">
        @csrf
        @method('PUT')


        <div class="grid grid-cols-1 gap-6">
          <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
              Statut
            </label>
            <select name="status" id="status"
                    class="mt-1 block w-full ps-2 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
              @foreach($statusLabel as $key => $status)
                <option value="{{$key}}"
                        {{ $key === $recovery->status ? 'selected' : '' }}
                        class="py-1 px-4 bg-white text-gray-700 hover:bg-indigo-500 hover:text-white">{{ $status }}
                </option>
              @endforeach
            </select>
            @error('status')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>


          <!-- Boutons -->
          <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/recoveries") }}"
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
