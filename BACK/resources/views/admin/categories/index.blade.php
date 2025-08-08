@extends('admin.layouts.app')

@section('title', 'Gestion des catégories')

@section('content')

  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Catégories</h1>
      <p class="text-gray-600">Gérez les catégories</p>
    </div>
    <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/categories/create") }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
      <i class="fas fa-plus mr-2"></i>Nouvelle catégorie
    </a>
  </div>

  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b">
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Liste des catégories</h2>
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
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label traduis</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($categories ?? [] as $category)
          <tr>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
            <td
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->translate_name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/categories/$category->id/edit") }}"
                 class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
              <form method="POST" action="{{ \App\Helpers\UrlHelper::assetUrl("admin/categories/$category->id") }}"
                    class="inline">
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
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune catégorie trouvée</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($categories) && method_exists($categories, 'links'))
      <div class="px-6 py-3 border-t">
        {{ $categories->links() }}
      </div>
    @endif
  </div>
@endsection
