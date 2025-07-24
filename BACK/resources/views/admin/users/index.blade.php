@extends('admin.layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Utilisateurs</h1>
      <p class="text-gray-600">Gérez les utilisateurs de votre plateforme</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
      <i class="fas fa-plus mr-2"></i>Nouvel utilisateur
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
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscrit le</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($users ?? [] as $user)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center">
                  {{--                  <i class="fas fa-user text-gray-600"></i>--}}
                  <img class="rounded-[50%]" src="{{$user->img_profile}}" alt="image de profile">
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span
                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </td>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->subscribe_date->format('d/m/Y') }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
              <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
              <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
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
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun utilisateur trouvé</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($users) && method_exists($users, 'links'))
      <div class="px-6 py-3 border-t">
        {{ $users->links() }}
      </div>
    @endif
  </div>
@endsection
