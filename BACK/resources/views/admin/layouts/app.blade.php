<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Administration - Sadaqa')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  @yield('script_quill')
</head>
<body class="bg-gray-50">
<!-- Navigation -->
<nav class="bg-white shadow-lg">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between h-16">
      <div class="flex items-center">
        <h1 class="text-xl font-bold text-gray-800">Sadaqa Admin</h1>
      </div>
      <div class="flex items-center space-x-4">
        <span class="text-gray-600">Bonjour, {{ Auth::guard('admin')->user()->name }}</span>
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>

<div class="flex">
  <!-- Sidebar -->
  <aside class="w-64 bg-gray-800 min-h-screen">
    <div class="p-4">
      <ul class="space-y-2">
        <li>
          <a href="{{ route('admin.dashboard') }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Tableau de bord
          </a>
        </li>
        <li>
          <a href="{{ route('admin.users.index') }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-users mr-3"></i>
            Utilisateurs
          </a>
        </li>
        <li>
          <a href="{{ route('admin.campaigns.index') }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-bullhorn mr-3"></i>
            Cagnottes
          </a>
        </li>
        <li>
          <a href="{{ route('admin.participants.index') }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-bullhorn mr-3"></i>
            Participants
          </a>
        </li>
        {{--        <li>--}}
        {{--          <a href="{{ route('admin.campaigns.index') }}"--}}
        {{--             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">--}}
        {{--            <i class="fas fa-bullhorn mr-3"></i>--}}
        {{--            Campagnes--}}
        {{--          </a>--}}
        {{--        </li>--}}
        {{--        <li>--}}
        {{--          <a href="{{ route('admin.settings') }}" class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">--}}
        {{--            <i class="fas fa-cog mr-3"></i>--}}
        {{--            Paramètres--}}
        {{--          </a>--}}
        {{--        </li>--}}
      </ul>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </main>
</div>

@yield("scripts")

</body>
</html>
