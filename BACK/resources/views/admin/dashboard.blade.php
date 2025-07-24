@extends('admin.layouts.app')

@section('title', 'Tableau de bord')

@section('content')
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
    <p class="text-gray-600">Vue d'ensemble de votre plateforme Sadaqa</p>
  </div>

  <!-- Statistics Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-blue-100">
          <i class="fas fa-users text-blue-600 text-xl"></i>
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-semibold text-gray-800">Utilisateurs</h3>
          <p class="text-2xl font-bold text-blue-600">{{ $stats['users'] ?? 0 }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-green-100">
          <i class="fas fa-heart text-green-600 text-xl"></i>
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-semibold text-gray-800">Dons totaux</h3>
          <p class="text-2xl font-bold text-green-600">{{ number_format($stats['total_donations'] ?? 0, 0, ',', ' ') }}
            €</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-yellow-100">
          <i class="fas fa-bullhorn text-yellow-600 text-xl"></i>
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-semibold text-gray-800">Campagnes actives</h3>
          <p class="text-2xl font-bold text-yellow-600">{{ $stats['active_campaigns'] ?? 0 }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center">
        <div class="p-3 rounded-full bg-purple-100">
          <i class="fas fa-chart-line text-purple-600 text-xl"></i>
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-semibold text-gray-800">Ce mois</h3>
          <p
            class="text-2xl font-bold text-purple-600">{{ number_format($stats['monthly_donations'] ?? 0, 0, ',', ' ') }}
            €</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Activities -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Derniers dons</h2>
      </div>
      <div class="p-6">
        @if(isset($recent_donations) && count($recent_donations) > 0)
          <div class="space-y-4">
            @foreach($recent_donations as $donation)
              <div class="flex items-center justify-between">
                <div>
                  <p class="font-medium text-gray-800">{{ $donation->user->name ?? 'Anonyme' }}</p>
                  <p class="text-sm text-gray-600">{{ $donation->campaign->title ?? 'Don général' }}</p>
                </div>
                <div class="text-right">
                  <p class="font-bold text-green-600">{{ number_format($donation->amount, 2) }} €</p>
                  <p class="text-xs text-gray-500">{{ $donation->created_at->diffForHumans() }}</p>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-gray-500">Aucun don récent</p>
        @endif
      </div>
    </div>

    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Campagnes récentes</h2>
      </div>
      <div class="p-6">
        @if(isset($recent_campaigns) && count($recent_campaigns) > 0)
          <div class="space-y-4">
            @foreach($recent_campaigns as $campaign)
              <div class="flex items-center justify-between">
                <div>
                  <p class="font-medium text-gray-800">{{ $campaign->title }}</p>
                  <p class="text-sm text-gray-600">Objectif: {{ number_format($campaign->goal, 2) }} €</p>
                </div>
                <div class="text-right">
                  <div class="w-16 bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full"
                         style="width: {{ min(($campaign->raised / $campaign->goal) * 100, 100) }}%"></div>
                  </div>
                  <p
                    class="text-xs text-gray-500 mt-1">{{ number_format(($campaign->raised / $campaign->goal) * 100, 1) }}
                    %</p>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-gray-500">Aucune campagne récente</p>
        @endif
      </div>
    </div>
  </div>
@endsection
