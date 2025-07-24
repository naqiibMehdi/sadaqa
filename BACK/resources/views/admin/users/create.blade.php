@extends('admin.layouts.app')

@section('title', 'Créer un utilisateur')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Créer un nouvel utilisateur</h1>
        <p class="text-gray-600">Ajout d'un nouvel utilisateur à la plateforme Sadaqa</p>
      </div>
      <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
      </a>
    </div>
  </div>

  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">
          <i class="fas fa-user-plus mr-2"></i>Informations du nouvel utilisateur
        </h2>
      </div>

      <form method="POST" action="{{ route('admin.users.store') }}" class="p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Nom -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
              Nom complet <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                   placeholder="Entrez le nom complet"
                   required>
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
              Prénom complet <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   id="first_name"
                   name="first_name"
                   value="{{ old('first_name') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror"
                   placeholder="Entrez le nom complet"
                   required>
            @error('first_name')
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
                   value="{{ old('email') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                   placeholder="utilisateur@exemple.com"
                   required>
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Mot de passe -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              Mot de passe <span class="text-red-500">*</span>
            </label>
            <input type="password"
                   id="password"
                   name="password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                   placeholder="Minimum 8 caractères"
                   required>
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Confirmation mot de passe -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
              Confirmer le mot de passe <span class="text-red-500">*</span>
            </label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Retapez le mot de passe"
                   required>
          </div>
        </div>

        <!-- Options avancées -->
        {{--        <div class="mt-8">--}}
        {{--          <h3 class="text-lg font-medium text-gray-800 mb-4">Options</h3>--}}

        {{--          <div class="space-y-4">--}}
        {{--            <!-- Statut actif -->--}}
        {{--            <div>--}}
        {{--              <label class="flex items-center">--}}
        {{--                <input type="checkbox"--}}
        {{--                       name="is_active"--}}
        {{--                       value="1"--}}
        {{--                       {{ old('is_active', true) ? 'checked' : '' }}--}}
        {{--                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">--}}
        {{--                <span class="ml-2 text-sm font-medium text-gray-700">Compte actif</span>--}}
        {{--              </label>--}}
        {{--              <p class="text-sm text-gray-500 mt-1">L'utilisateur pourra se connecter immédiatement</p>--}}
        {{--            </div>--}}

        {{--            <!-- Email vérifié -->--}}
        {{--            <div>--}}
        {{--              <label class="flex items-center">--}}
        {{--                <input type="checkbox"--}}
        {{--                       name="email_verified"--}}
        {{--                       value="1"--}}
        {{--                       {{ old('email_verified', true) ? 'checked' : '' }}--}}
        {{--                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">--}}
        {{--                <span class="ml-2 text-sm font-medium text-gray-700">Email vérifié</span>--}}
        {{--              </label>--}}
        {{--              <p class="text-sm text-gray-500 mt-1">Marquer l'email comme déjà vérifié</p>--}}
        {{--            </div>--}}
        {{--          </div>--}}
        {{--        </div>--}}

        <!-- Aperçu -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
          <h3 class="text-sm font-medium text-blue-800 mb-2">
            <i class="fas fa-info-circle mr-1"></i>À propos de la création d'utilisateur
          </h3>
          <ul class="text-sm text-blue-700 space-y-1">
            <li>• Le mot de passe sera haché de façon sécurisée</li>
            <li>• L'utilisateur peut modifier ses informations depuis son profil</li>
          </ul>
        </div>

        <!-- Boutons -->
        <div class="mt-8 flex justify-end space-x-4">
          <a href="{{ route('admin.users.index') }}"
             class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
            Annuler
          </a>
          <button type="submit"
                  class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-user-plus mr-2"></i>Créer l'utilisateur
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Validation en temps réel pour la confirmation du mot de passe
    document.getElementById('password_confirmation').addEventListener('input', function () {
      const password = document.getElementById('password').value;
      const confirm = this.value;

      if (confirm && password !== confirm) {
        this.setCustomValidity('Les mots de passe ne correspondent pas');
        this.classList.add('border-red-500');
      } else {
        this.setCustomValidity('');
        this.classList.remove('border-red-500');
      }
    });
  </script>
@endsection
