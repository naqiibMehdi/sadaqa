@extends('admin.layouts.app')

@section('title', 'Détails de la cagnotte')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Détails de la cagnotte</h1>
        <p class="text-gray-600">Informations complètes sur la cagnotte: {{ $campaign->title }}</p>
      </div>
      <div class="flex space-x-3">
        <a href="{{ route('admin.campaigns.edit', $campaign) }}"
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
            <i class="fas fa-user mr-2"></i>Informations de la cagnotte
          </h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-start-1 col-span-2 flex flex-col items-center">
              <label class="block text-sm font-medium text-gray-700 mb-2">Image principale</label>
              <img class="rounded-[10px] w-1/3 h-1/3"
                   src="{{Storage::url($campaign->image)}}"
                   alt="photo de profile">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800 font-medium">{{ $campaign->title }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800 font-medium">{{ $campaign->slug }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Montant objectif</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $campaign->target_amount }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Montant collecté</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $campaign->collected_amount }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Clôturée</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                @if(!$campaign->closing_date)
                  <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium"><i
                      class="fas fa-check-circle mr-1"></i>Non clôturée</span>
                @else
                  <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium"><i
                      class="fas fa-times-circle mr-1"></i>Clôturée</span>
                @endif
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Anonyme</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                @if(!$campaign->is_anonymous)
                  <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium"><i
                      class="fas fa-check-circle mr-1"></i>Non anonyme</span>
                @else
                  <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                                                      <i class="fas fa-exclamation-triangle mr-1"></i>Anonyme
                                                  </span>
                @endif
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date de création</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $campaign->created_at->format('d/m/Y') }}</p>
                <p class="text-xs text-gray-500">{{ $campaign->created_at->diffForHumans() }}</p>
              </div>
            </div>

            <div class="col-start-1 col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{!! $campaign->description !!}</p>
              </div>
            </div>

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
          <a href="{{ route('admin.campaigns.edit', $campaign) }}"
             class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
            <i class="fas fa-edit mr-2"></i>Modifier la cagnotte
          </a>

          <form method="POST" action="{{ route('admin.campaigns.destroy', $campaign) }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette cagnotte ? Cette action est irréversible.')"
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
            <span class="text-gray-600">Nombre de participants</span>
            <span class="font-bold text-purple-600">{{ $campaign->participant()->count() ?? 0 }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
