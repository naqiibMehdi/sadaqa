@extends('admin.layouts.app')

@section('title', 'Modifier l\'utilisateur')

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
  </script>

@endsection

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Modifier l'utilisateur</h1>
        <p class="text-gray-600">Modification des informations de {{ $user->name }}</p>
      </div>
      <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/users/$user") }}"
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-arrow-left mr-2"></i>Retour
      </a>
    </div>
  </div>

  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">
          <i class="fas fa-user-edit mr-2"></i>Informations de l'utilisateur
        </h2>
      </div>

      <form method="POST" action="{{ \App\Helpers\UrlHelper::assetUrl("admin/users/$user") }}"
            enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')


        <!-- Section Image de profil -->
        <div class="mb-8">
          <h3 class="text-lg font-medium text-gray-800 mb-4">
            <i class="fas fa-camera mr-2"></i>Image de profil
          </h3>

          <div class="flex items-start space-x-6">
            <!-- Aperçu actuel -->
            <div class="flex-shrink-0">
              <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200">
                @if($user->img_profile)
                  @if(Str::startsWith($user->img_profile, 'http'))
                    <img id="profile-preview" src="{{ $user->img_profile }}" alt="Photo de profil"
                         class="w-full h-full object-cover">
                  @else
                    <img id="profile-preview" src="{{ Storage::url($user->img_profile) }}" alt="Photo de profil"
                         class="w-full h-full object-cover">
                  @endif
                @else
                  <div id="profile-preview" class="w-full h-full bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-user text-gray-500 text-2xl"></i>
                  </div>
                @endif
              </div>
            </div>

            <!-- Upload -->
            <div class="flex-1">
              <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                Nouvelle image de profil
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
              @if($user->img_profile)
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
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
              Nom complet <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                   required>
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
              Adresse email <span class="text-red-500">*</span>
            </label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                   required>
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Nouveau mot de passe -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              Nouveau mot de passe
            </label>
            <input type="password"
                   id="password"
                   name="password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                   placeholder="Laissez vide pour conserver l'actuel">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Minimum 8 caractères</p>
          </div>

          <!-- Confirmation mot de passe -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
              Confirmer le mot de passe
            </label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <p class="text-sm text-gray-500 mt-1">Seulement si vous changez le mot de passe</p>
          </div>
        </div>

        <!-- Informations de modification -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
          <h3 class="text-sm font-medium text-gray-800 mb-2">Informations</h3>
          <div class="text-sm text-gray-600 space-y-1">
            <p><strong>Compte créé le :</strong> {{ $user->subscribe_date->format('d/m/Y') }}</p>
          </div>
        </div>

        <!-- Boutons -->
        <div class="mt-8 flex justify-end space-x-4">
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/users/$user") }}"
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
