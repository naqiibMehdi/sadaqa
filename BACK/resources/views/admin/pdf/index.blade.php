@extends('admin.layouts.app')

@section('title', 'Gestion des Téléchargements')

@section('content')

  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Téléchargements</h1>
      <p class="text-gray-600">Gérez les téléchargements des factures</p>
    </div>
    {{--    <a href="{{ route('admin.campaigns.create') }}"--}}
    {{--       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">--}}
    {{--      <i class="fas fa-plus mr-2"></i>Nouvelle cagnotte--}}
    {{--    </a>--}}
  </div>

  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b">
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Liste des téléchargements</h2>
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
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cagnotte</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléchargé Le</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($downloads ?? [] as $download)
          <tr>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $download->user->name }} {{ $download->user->first_name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $download->campaign->title }}</td>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $download->downloaded_at->timezone("Europe/Paris")->format("d/m/Y à H:i") }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ route('admin.pdf.show', $download) }}"
                 class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
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

    @if(isset($downloads) && method_exists($downloads, 'links'))
      <div class="px-6 py-3 border-t">
        {{ $downloads->links() }}
      </div>
    @endif
  </div>
@endsection
