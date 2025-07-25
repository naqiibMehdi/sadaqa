@extends('admin.layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Détails de l'utilisateur</h1>
        <p class="text-gray-600">Informations complètes sur {{ $user->name }}</p>
      </div>
      <div class="flex space-x-3">
        <a href="{{ route('admin.users.edit', $user) }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-edit mr-2"></i>Modifier
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations principales -->
    <div class="lg:col-span-2">
      <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
          <h2 class="text-xl font-semibold text-gray-800">
            <i class="fas fa-user mr-2"></i>Informations personnelles
          </h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-start-1 col-span-2 flex flex-col items-center">
              <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profile</label>
              <img class="rounded-[50%] w-24 h-24 object-cover"
                   src="{{Str::startsWith($user->img_profile, 'http') ? $user->img_profile : Storage::url($user->img_profile)}}"
                   alt="photo de profile">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800 font-medium">{{ $user->name }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800 font-medium">{{ $user->first_name }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $user->email }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                @if($user->is_active ?? true)
                  <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>Actif
                                    </span>
                @else
                  <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-times-circle mr-1"></i>Inactif
                                    </span>
                @endif
              </div>
            </div>
            {{--            <div>--}}
            {{--              <label class="block text-sm font-medium text-gray-700 mb-2">Email vérifié</label>--}}
            {{--              <div class="p-3 bg-gray-50 rounded-lg">--}}
            {{--                @if($user->email_verified_at)--}}
            {{--                  <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">--}}
            {{--                                        <i class="fas fa-check-circle mr-1"></i>Vérifié--}}
            {{--                                    </span>--}}
            {{--                  <p class="text-xs text-gray-500 mt-1">{{ $user->email_verified_at->format('d/m/Y à H:i') }}</p>--}}
            {{--                @else--}}
            {{--                  <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">--}}
            {{--                                        <i class="fas fa-exclamation-triangle mr-1"></i>Non vérifié--}}
            {{--                                    </span>--}}
            {{--                @endif--}}
            {{--              </div>--}}
            {{--            </div>--}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date d'inscription</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $user->subscribe_date->format('d/m/Y') }}</p>
                <p class="text-xs text-gray-500">{{ $user->subscribe_date->diffForHumans() }}</p>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date d'anniversaire</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $user->birth_date->format('d/m/Y') }}</p>
              </div>
            </div>
            {{--            <div>--}}
            {{--              <label class="block text-sm font-medium text-gray-700 mb-2">Dernière modification</label>--}}
            {{--              <div class="p-3 bg-gray-50 rounded-lg">--}}
            {{--                <p class="text-gray-800">{{ $user->updated_at->format('d/m/Y à H:i') }}</p>--}}
            {{--                <p class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>--}}
            {{--              </div>--}}
            {{--            </div>--}}
          </div>
        </div>
      </div>
    </div>

    <!-- Actions et statistiques -->
    <div class="lg:col-span-1">
      <!-- Actions rapides -->
      <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="p-6 border-b">
          <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-tools mr-2"></i>Actions rapides
          </h3>
        </div>
        <div class="p-6 space-y-3">
          <a href="{{ route('admin.users.edit', $user) }}"
             class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
            <i class="fas fa-edit mr-2"></i>Modifier l'utilisateur
          </a>

          {{--          <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="w-full">--}}
          {{--            @csrf--}}
          {{--            @method('PATCH')--}}
          {{--            @if($user->is_active ?? true)--}}
          {{--              <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">--}}
          {{--                <i class="fas fa-pause mr-2"></i>Désactiver--}}
          {{--              </button>--}}
          {{--            @else--}}
          {{--              <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">--}}
          {{--                <i class="fas fa-play mr-2"></i>Activer--}}
          {{--              </button>--}}
          {{--            @endif--}}
          {{--          </form>--}}

          <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')"
                class="w-full">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
              <i class="fas fa-trash mr-2"></i>Supprimer
            </button>
          </form>
        </div>
      </div>

      <!-- Statistiques -->
      <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
          <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-chart-bar mr-2"></i>Statistiques
          </h3>
        </div>
        <div class="p-6 space-y-4">
          {{--          <div class="flex justify-between items-center">--}}
          {{--            <span class="text-gray-600">Nombre de dons</span>--}}
          {{--            <span class="font-bold text-blue-600">{{ $user->donations()->count() ?? 0 }}</span>--}}
          {{--          </div>--}}
          {{--          <div class="flex justify-between items-center">--}}
          {{--            <span class="text-gray-600">Total des dons</span>--}}
          {{--            <span--}}
          {{--              class="font-bold text-green-600">{{ number_format($user->donations()->sum('amount') ?? 0, 2) }} €</span>--}}
          {{--          </div>--}}
          <div class="flex justify-between items-center">
            <span class="text-gray-600">Campagnes créées</span>
            <span class="font-bold text-purple-600">{{ $user->campaign()->count() ?? 0 }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
