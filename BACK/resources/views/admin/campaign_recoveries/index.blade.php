@extends('admin.layouts.app')

@section('title', 'Gestion des virements')

@section('content')

  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Virements</h1>
      <p class="text-gray-600">Gérez les demandes de virements</p>
    </div>
    {{--    <a href="{{ route('admin.campaigns.create') }}"--}}
    {{--       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">--}}
    {{--      <i class="fas fa-plus mr-2"></i>Nouvelle cagnotte--}}
    {{--    </a>--}}
  </div>

  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b">
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Liste des virements</h2>
        <div class="flex space-x-2">
          <input type="text" placeholder="Rechercher..." class="px-3 py-2 border border-gray-300 rounded-md">
          <select class="px-3 py-2 border border-gray-300 rounded-md">
            <option value="">Tous les statuts</option>
            <option value="active">Actif</option>
            <option value="inactive">Inactif</option>
          </select>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom - Prénom</th>
          {{--          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>--}}
          {{--          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>--}}
          {{--          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date--}}
          {{--            Participation--}}
          {{--          </th>--}}
          {{--          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status--}}
          {{--          </th>--}}
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($recoveries ?? [] as $recovery)
          <tr>
            {{--            <td class="px-6 py-4 whitespace-nowrap">--}}
            {{--              <div class="flex items-center">--}}
            {{--                <div class="ml-4">--}}
            {{--                  <div--}}
            {{--                    class="text-sm font-medium text-gray-900">{{ $recovery->amount }}</div>--}}
            {{--                </div>--}}
            {{--              </div>--}}
            {{--            </td>--}}
            {{--            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $participant->email }}</td>--}}
            {{--            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $participant->amount / 100 }}€</td>--}}
            {{--            <td--}}
            {{--              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $participant->participation_date->timezone("Europe/Paris")->format("d/m/Y à H:i") }}</td>--}}
            {{--            <td--}}
            {{--              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">--}}
            {{--              <x-payment-status :status="$participant->payment_status"/>--}}
            {{--            </td>--}}
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ route('admin.participants.show', $participant) }}"
                 class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
              {{--              <a href="{{ route('admin.campaigns.edit', $campaign) }}"--}}
              {{--                 class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>--}}
              {{--              <form method="POST" action="{{ route('admin.campaigns.destroy', $campaign) }}" class="inline">--}}
              {{--                @csrf--}}
              {{--                @method('DELETE')--}}
              {{--                <button type="submit" class="text-red-600 hover:text-red-900"--}}
              {{--                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer--}}
              {{--                </button>--}}
              {{--              </form>--}}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun virement trouvé</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($recoveries) && method_exists($recoveries, 'links'))
      <div class="px-6 py-3 border-t">
        {{ $recoveries->links() }}
      </div>
    @endif
  </div>
@endsection
