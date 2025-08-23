@php
  $manifestPath = public_path('build' . DIRECTORY_SEPARATOR . 'manifest.json');
  $cssFile = null;
  $jsFile = null;

  if(file_exists($manifestPath)){
    $manifest = json_decode(file_get_contents($manifestPath), true);
    $cssFile = $manifest["resources/css/app.css"]["file"] ?? null;
    $jsFile = $manifest["resources/js/app.js"]["file"] ?? null;
    }
@endphp
  <!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Administration - Sadaqa')</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
  @if(env('USE_FRONTEND_URL') && $cssFile && $jsFile)
    <link rel="preload" as="style" href="{{ env("FRONTEND_URL") }}/build/{{$cssFile}}">
    <link rel="stylesheet" href="{{ env("FRONTEND_URL") }}/build/{{$cssFile}}">
    <link rel="modulepreload" href="{{ env("FRONTEND_URL") }}/build/{{$jsFile}}">
    <script src="{{ env("FRONTEND_URL") }}/build/{{$jsFile}}" defer type="module"></script>
  @else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
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
        <form method="POST" action="{{ \App\Helpers\UrlHelper::assetUrl("admin/logout") }}">
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
  <aside class="w-64 bg-gray-800 min-h-[calc(100vh-64px)]">
    <div class="p-4">
      <ul class="space-y-2">
        <li>
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/dashboard") }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Tableau de bord
          </a>
        </li>
        <li>
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/users") }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-users mr-3"></i>
            Utilisateurs
          </a>
        </li>
        <li>
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/campaigns") }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-bullhorn mr-3"></i>
            Cagnottes
          </a>
        </li>
        <li>
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/participants") }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-light fa-hand-holding-heart mr-3"></i>
            Participants
          </a>
        </li>
        <li>
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/recoveries") }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-light fa-money-bill-transfer mr-3"></i>
            Virements
          </a>
        </li>
        <li>
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/pdf") }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-light fa-file-invoice mr-3"></i>
            Factures Téléchargées
          </a>
        </li>
        <li>
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/categories") }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-light fa-list mr-3"></i>
            Catégories
          </a>
        </li>
        <li>
          <a href="{{ \App\Helpers\UrlHelper::assetUrl("admin/contacts") }}"
             class="flex items-center p-2 text-gray-300 hover:bg-gray-700 rounded">
            <i class="fas fa-light fa-envelope mr-3"></i>
            Support
          </a>
        </li>
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
