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
      <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/campaigns/$campaign") }}"
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
      <form method="POST" action="{{ \App\Helpers\UrlHelper::assetUrl("admin/campaigns/$campaign") }}"
            enctype="multipart/form-data"
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
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
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
                <option value="{{old("category_id", $category->id)}}"
                        {{ $category->id === $campaign->category_id ? 'selected' : ''  }}
                        class="py-1 px-4 bg-white text-gray-700 hover:bg-indigo-500 hover:text-white">{{Str::ucfirst($category->translate_name)}}
                </option>
              @endforeach
            </select>
            @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

        </div>

        <!-- Statut -->
        <div class="mt-6">
          <label class="flex items-center">
            <input type="checkbox"
                   name="is_anonymous"
                   value="1"
                   {{ old('is_anonymous', $campaign->is_anonymous) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
            <span class="ml-2 text-sm font-medium text-gray-700">Cagnotte Anonyme</span>
          </label>
        </div>

        <div class="mb-4 mt-4">
          <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
            Description
          </label>
          <div id="quill-editor"></div>
          @error('description')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
          <input type="hidden" name="description" id="hidden-description"
                 value="{{old('description', $campaign->description)}}">
        </div>

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
    document.getElementById('image').addEventListener('change', function (e) {
      const file = e.target.files[0];
      const preview = document.getElementById('profile-preview');

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          if (preview.tagName === 'IMG') {
            preview.src = e.target.result;
          } else {
            preview.innerHTML = `<img src="${e.target.result}" alt="Aperçu" class="w-full h-full object-cover">`;
          }
        };
        reader.readAsDataURL(file);
      }
    });

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
    let url = ""

    quill.root.innerHTML = campaignDescription;
    quill.root.addEventListener('click', handleImageSelection)
    quill.root.addEventListener('keydown', handleImageDeleted)

    quill.on('text-change', function () {
      document.getElementById('hidden-description').value = quill.root.innerHTML;
    })

    function handleImageDeleted(event) {
      if (url && (event.key === 'Backspace' || event.key === 'Delete')) {
        deleteImage(url)
        url = ""
      }
    }

    function handleImageSelection(event) {
      if (event.target.tagName === "IMG") {
        url = event.target.src
      } else {
        url = ""
      }
    }

    function upload() {
      const range = this.quill.getSelection();
      const input = document.createElement('input');
      input.type = "file";
      input.accept = "image/png, image/jpeg, image/webp";
      input.click()

      input.onchange = function () {
        let file = input.files[0];
        if (/^image\//.test(file.type)) {
          uploadImage(file, range);
        } else {
          console.warn('You could only upload images.');
        }
      }
    }

    function uploadImage(file, range) {
      let formData = new FormData();
      formData.append('image', file);

      fetch('/api/upload-image', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': `{{ csrf_token() }}`
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data) {
            let url = data.url;
            quill.insertEmbed(range.index, 'image', url);
            quill.setSelection(range.index + 1, 0);
          } else {
            console.error('Error uploading image');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        })
    }

    function deleteImage(url) {
      let formData = new FormData();
      formData.append('url', url);

      fetch('/api/delete-image', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': `{{ csrf_token() }}`
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data) {
            console.log(data)
          } else {
            console.error('Error delete  image');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        })
    }

  </script>

@endsection
