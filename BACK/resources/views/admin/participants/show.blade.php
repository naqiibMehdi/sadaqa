@extends('admin.layouts.app')

@section('title', 'Détails de la participation')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Détails de la participation</h1>
        <p class="text-gray-600">Informations complètes de la participation</p>
      </div>
      <div class="flex space-x-3">
        <a href="{{ route('admin.participants.edit', $participant) }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
          <i class="fas fa-edit mr-2"></i>Modifier
        </a>
        <a href="{{ route('admin.participants.index') }}"
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
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2"> Nom - Prénom</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p
                  class="text-gray-800 font-medium">{{ Str::ucfirst(str($participant->name)->explode(" ")[0]) }} {{ Str::ucfirst(str($participant->name)->explode(" ")[1]) }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800 font-medium">{{ $participant->email }}</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Montant</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800">{{ $participant->amount / 100 }}€</p>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <x-payment-status :status="$participant->payment_status"/>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date de participation</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p
                  class="text-gray-800">{{ $participant->participation_date->timezone("Europe/Paris")->format('d/m/Y') }}</p>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Identifiant Stripe</label>
              <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-gray-800 hover:text-blue-500">
                  <a
                    href="https://dashboard.stripe.com/test/payments/{{$participant->payment_id}}"
                    target="_blank">{{ $participant->payment_id }}</a>
                </p>
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
          <a href="{{ route('admin.participants.edit', $participant) }}"
             class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
            <i class="fas fa-edit mr-2"></i>Modifier la participation
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

          <form method="POST" action="{{ route('admin.participants.destroy',$participant) }}"
                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette participation ? Cette action est irréversible.')"
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
