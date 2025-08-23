@extends('admin.layouts.app')

@section('title', 'Détails de la demande')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Détails de la demande</h1>
        <p class="text-gray-600">Informations complètes de la demande</p>
      </div>
      <div class="flex space-x-3">
        {{--        <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/participants/{$participant->id}/edit") }}"--}}
        {{--           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">--}}
        {{--          <i class="fas fa-edit mr-2"></i>Modifier--}}
        {{--        </a>--}}
        <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/contacts") }}"
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
            <i class="fas fa-user mr-2"></i>Informations de la demande
          </h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p
                  class="text-gray-800 font-medium">{{ $contact->email }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date de création</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p
                  class="text-gray-800 font-medium">{{ $contact->created_at->timezone("Europe/Paris")->format('d/m/Y') }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <x-contact-status :status="$contact->status"/>
              </div>
            </div>
            <div class="col-start-1 col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $contact->description }}</p>
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
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/contacts/{$contact->id}/edit") }}"
             class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
            <i class="fas fa-edit mr-2"></i>Modifier le status
          </a>

          <form method="POST" action="{{ \App\Helpers\UrlHelper::assetUrl("admin/contacts/{$contact->id}") }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ? Cette action est irréversible.')"
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
