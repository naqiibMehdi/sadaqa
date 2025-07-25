@extends('admin.layouts.app')

@section('title', 'Modifier la cagnotte')

@section("script_quill")
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
@endsection



@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Modifier la cagnotte</h1>
        <p class="text-gray-600">Modification des informations de la cagnotte: {{ $campaign->title }}</p>
      </div>
      <a href="{{ route('admin.campaigns.show', $campaign) }}"
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-arrow-left mr-2"></i>Retour
      </a>
    </div>
  </div>

  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">
          <i class="fas fa-user-edit mr-2"></i>Informations de la cagnotte
        </h2>
      </div>

      <form method="POST" action="{{ route('admin.campaigns.update', $campaign) }}" enctype="multipart/form-data"
            class="p-6">
        @csrf
        @method('PUT')


        <!-- Section Image de profil -->
        <div class="mb-8">
          <h3 class="text-lg font-medium text-gray-800 mb-4">
            <i class="fas fa-camera mr-2"></i>Image principale de la cagnotte
          </h3>

          <div class="flex items-start space-x-6">
            <!-- Aperçu actuel -->
            <div class="flex-shrink-0">
              <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200">
                <img id="profile-preview" src="{{ Storage::url($campaign->image) }}" alt="Photo de profil"
                     class="w-full h-full object-cover">

              </div>
            </div>

            <!-- Upload -->
            <div class="flex-1">
              <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                Nouvelle image principale
              </label>
              <input type="file"
                     id="image"
                     name="image"
                     accept="image/*"
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image') border-red-500 @enderror">
              @error('image')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
              <p class="text-sm text-gray-500 mt-1">Formats acceptés : JPG, PNG, WEBP. Taille max : 2MB</p>

              <!-- Option pour supprimer l'image -->
              @if($campaign->image)
                <label class="flex items-center mt-3">
                  <input type="checkbox" name="remove_image" value="1"
                         class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                  <span class="ml-2 text-sm text-red-600">Supprimer l'image actuelle</span>
                </label>
              @endif
            </div>
          </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Nom -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              Titre <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   id="title"
                   name="title"
                   value="{{ old('title', $campaign->title) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                   required>
            @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>


          <div>
            <label for="target_amount" class="block text-sm font-medium text-gray-700 mb-2">
              Montant à atteindre
            </label>
            <input type="text"
                   id="target_amount"
                   pattern="[0-9]*"
                   name="target_amount"
                   value="{{ old('target_amount', $campaign->target_amount) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('target_amount') border-red-500 @enderror"
            >
            @error('target_amount')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
              Montant à atteindre
            </label>
            <select name="category_id" id="category_id"
                    class="mt-1 block w-full ps-2 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
              @foreach($categories as $category)
                <option value="{{$category->id}}"
                        {{ $category->id === $campaign->category_id ? 'selected' : ''  }}
                        class="py-1 px-4 bg-white text-gray-700 hover:bg-indigo-500 hover:text-white">{{Str::ucfirst($category->translate_name)}}
                </option>
              @endforeach
            </select>
            @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{--          <!-- Confirmation mot de passe -->--}}
          {{--          <div>--}}
          {{--            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">--}}
          {{--              Confirmer le mot de passe--}}
          {{--            </label>--}}
          {{--            <input type="password"--}}
          {{--                   id="password_confirmation"--}}
          {{--                   name="password_confirmation"--}}
          {{--                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">--}}
          {{--            <p class="text-sm text-gray-500 mt-1">Seulement si vous changez le mot de passe</p>--}}
          {{--          </div>--}}
        </div>

        <!-- Statut -->
        <div class="mt-6">
          <label class="flex items-center">
            <input type="checkbox"
                   name="is_anonymous"
                   value="1"
                   {{ old('is_anonymous', $campaign->is_anonymous ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
            <span class="ml-2 text-sm font-medium text-gray-700">Cagnotte Anonyme</span>
          </label>
        </div>

        <div class="mb-4 mt-4">
          <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
            Description
          </label>
          <div id="quill-editor"></div>
          <input type="hidden" name="@description" id="hidden-description">
        </div>

        {{--        <!-- Informations de modification -->--}}
        {{--        <div class="mt-6 p-4 bg-gray-50 rounded-lg">--}}
        {{--          <h3 class="text-sm font-medium text-gray-800 mb-2">Informations</h3>--}}
        {{--          <div class="text-sm text-gray-600 space-y-1">--}}
        {{--            <p><strong>Compte créé le :</strong> {{ $user->subscribe_date->format('d/m/Y') }}</p>--}}
        {{--            --}}{{--            <p><strong>Dernière modification :</strong> {{ $user->updated_at->format('d/m/Y à H:i') }}</p>--}}
        {{--            --}}{{--            @if($user->email_verified_at)--}}
        {{--            --}}{{--              <p><strong>Email vérifié :</strong> {{ $user->email_verified_at->format('d/m/Y à H:i') }}</p>--}}
        {{--            --}}{{--            @else--}}
        {{--            --}}{{--              <p class="text-yellow-600"><strong>Email non vérifié</strong></p>--}}
        {{--            --}}{{--            @endif--}}
        {{--          </div>--}}
        {{--        </div>--}}

        <!-- Boutons -->
        <div class="mt-8 flex justify-end space-x-4">
          <a href="{{ route('admin.campaigns.show', $campaign) }}"
             class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
            Annuler
          </a>
          <button type="submit"
                  class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-save mr-2"></i>Enregistrer les modifications
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection


@section('scripts')
  <!-- Script pour l'aperçu de l'image -->
  <script>
    const quill = new Quill('#quill-editor', {
      modules: {
        toolbar: {
          container: [['bold', 'italic'], ['link', 'image']],
          handlers: {
            image: upload
          }
        },
      },
      theme: 'snow',
    });

    let campaignDescription = `{!! $campaign->description !!}`

    quill.root.innerHTML = campaignDescription;

    quill.on('text-change', function () {
      document.getElementById('hidden-description').value = quill.root.innerHTML;
    })

    function upload() {
      const range = this.quill.getSelection();
      const input = document.createElement('input');
      input.type = "file";
      input.accept = "image/png, image/jpeg, image/webp";
      input.click()
    }

    // // Gérer l'insertion d'images
    // var toolbar = quill.getModule('toolbar');
    // toolbar.addHandler('image', function() {
    //   var range = this.quill.getSelection();
    //   var input = document.createElement('input');
    //   input.setAttribute('type', 'file');
    //   input.setAttribute('accept', 'image/*');
    //   input.click();
    //
    //   input.onchange = function() {
    //     var file = input.files[0];
    //     if (/^image\//.test(file.type)) {
    //       uploadImage(file, range);
    //     } else {
    //       console.warn('You could only upload images.');
    //     }
    //   };
    // });
    //
    // function uploadImage(file, range) {
    //   var formData = new FormData();
    //   formData.append('image', file);
    //
    //   fetch('/upload-image', {
    //     method: 'POST',
    //     body: formData,
    //     headers: {
    //       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //     }
    //   })
    //     .then(response => response.json())
    //     .then(data => {
    //       if (data.success) {
    //         var url = data.url;
    //         quill.insertEmbed(range.index, 'image', url);
    //       } else {
    //         console.error('Error uploading image');
    //       }
    //     })
    //     .catch(error => {
    //       console.error('Error:', error);
    //     });
  </script>

@endsection
