@extends('admin.layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Cagnottes</h1>
      <p class="text-gray-600">Gérez les cagnottes de votre plateforme</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
      <i class="fas fa-plus mr-2"></i>Nouvel cagnotte
    </a>
  </div>

  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b">
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Liste des utilisateurs</h2>
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
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant collecté
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de Création
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($campaigns ?? [] as $campaign)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center">
                  {{--                  <i class="fas fa-user text-gray-600"></i>--}}
                  <img class="rounded-[50%] w-full h-full object-cover"
                       src="{{Storage::url($campaign->image)}}"
                       alt="image de la cagnotte">
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ $campaign->title }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $campaign->collected_amount }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                            <span
                              class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ !$campaign->closing_date ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $campaign->closing_date ? 'Clôturée' : 'non clôturé' }}
                            </span>
            </td>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $campaign->created_at->format('d/m/Y') }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ route('admin.campaigns.show', $campaign) }}"
                 class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
              <a href="{{ route('admin.campaigns.edit', $campaign) }}"
                 class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
              <form method="POST" action="{{ route('admin.campaigns.destroy', $campaign) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900"
                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune cagnotte trouvée</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($campaigns) && method_exists($campaigns, 'links'))
      <div class="px-6 py-3 border-t">
        {{ $campaigns->links() }}
      </div>
    @endif
  </div>
@endsection
