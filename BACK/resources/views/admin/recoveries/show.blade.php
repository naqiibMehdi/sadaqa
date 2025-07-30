@extends('admin.layouts.app')

@section('title', 'Détails du virement')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Détails du virement</h1>
        <p class="text-gray-600">Informations complètes du virement</p>
      </div>
      <div class="flex space-x-3">
        <a href="{{ route('admin.recoveries.edit', $recovery) }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-edit mr-2"></i>Modifier
        </a>
        <a href="{{ route('admin.recoveries.index') }}"
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
            <i class="fas fa-money-bill mr-2"></i>Informations virement
          </h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"> Nom - Prénom</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p
                  class="text-gray-800 font-medium">{{ Str::ucfirst($recovery->user->name) }} {{ Str::ucfirst($recovery->user->first_name) }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Cagnotte</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800 font-medium">{{ $recovery->campaign->title }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Montant total</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $recovery->amount / 100 }}€</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <x-recovery-status :status="$recovery->status"/>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date de demande</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p
                  class="text-gray-800">{{ $recovery->created_at->timezone("Europe/Paris")->format('d/m/Y') }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">IBAN</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p
                  class="text-gray-800">{{ decrypt($recovery->iban) }}</p>
              </div>
            </div>

            <div>
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
          <a href="{{ route('admin.recoveries.edit', $recovery) }}"
             class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
            <i class="fas fa-edit mr-2"></i>Modifier la demande de virement
          </a>


          <form method="POST" action="{{ route('admin.recoveries.destroy',$recovery) }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande de virement ? Cette action est irréversible.')"
                class="w-full">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
              <i class="fas fa-trash mr-2"></i>Supprimer
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
@endsection
