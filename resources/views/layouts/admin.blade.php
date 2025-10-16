@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - Horizon Immo</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Fontawome links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">

    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-blue-600 text-white">
                <h1 class="text-xl font-bold">Horizon Immo</h1>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6 px-4">
                <!-- Dashboard principal pour Admin -->
                @can('dashboard.admin')
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Administration</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                Tableau de bord
                            </a>
                        </li>
                        
                        @can('properties.view')
                        <li>
                            <a href="{{ route('admin.properties.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.properties.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                Propriétés
                            </a>
                        </li>
                        @endcan
                        
                        @can('categories.view')
                        <li>
                            <a href="{{ route('admin.categories.index') }}"
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15.586 13H14a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                                Catégories
                            </a>
                        </li>
                        @endcan

                        @can('categories.view')
                        <li>
                            <a href="{{ route('admin.towns.index') }}"
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.towns.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                Villes
                            </a>
                        </li>
                        @endcan

                        @can('users.view')
                        <li>
                            <a href="{{ route('admin.users.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                Utilisateurs
                            </a>
                        </li>
                        @endcan
                        
                        @can('messages.view')
                        <li>
                            <a href="{{ route('admin.messages.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.messages.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>
                                Messages Propriétés
                                @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unreadMessagesCount }}</span>
                                @endif
                            </a>
                        </li>
                        @endcan

                        @can('messages.view')
                        <li>
                            <a href="{{ route('admin.contact-messages.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.contact-messages.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                Messages Contact
                                @if(isset($unreadContactMessagesCount) && $unreadContactMessagesCount > 0)
                                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unreadContactMessagesCount }}</span>
                                @endif
                            </a>
                        </li>
                        @endcan
                        
                        @can('applications.view')
                        <li>
                            <a href="{{ route('admin.applications.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.applications.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2H5v-2h10zM5 9h10v2H5V9z" clip-rule="evenodd"/>
                                </svg>
                                Applications
                                @if(isset($pendingApplicationsCount) && $pendingApplicationsCount > 0)
                                <span class="ml-auto bg-orange-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingApplicationsCount }}</span>
                                @endif
                            </a>
                        </li>
                        @endcan

                        @can('content.manage')
                        <li>
                            <a href="{{ route('admin.home-content.index') }}"
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.home-content.*', 'admin.services.*', 'admin.testimonials.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                                Paramètres
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
                @endcan

                <!-- Dashboard client pour les Clients -->
                @hasrole('client')
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Espace Client</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('client.dashboard') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('client.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                Tableau de bord
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('client.applications.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('client.applications.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2H5v-2h10zM5 9h10v2H5V9z" clip-rule="evenodd"/>
                                </svg>
                                Mes Applications
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('client.messages.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('client.messages.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>
                                Mes Messages
                            </a>
                        </li>
                    </ul>
                </div>
                @endhasrole
            </nav>
            
            <!-- User Menu -->
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-200">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center w-full px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-100">
                        @if(Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" 
                                 alt="Avatar de {{ Auth::user()->name }}" 
                                 class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 mr-3">
                        @else
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3">
                                @php
                                    $name = trim(Auth::user()->name);
                                    if (empty($name)) {
                                        $initials = 'U';
                                    } else {
                                        // Séparer par espaces et tirets
                                        $nameParts = preg_split('/[\s\-]+/', $name);
                                        $initials = '';
                                        foreach ($nameParts as $part) {
                                            $part = trim($part);
                                            if (!empty($part)) {
                                                $initials .= strtoupper(substr($part, 0, 1));
                                            }
                                        }
                                        if (empty($initials)) {
                                            $initials = 'U';
                                        }
                                    }
                                    echo $initials;
                                @endphp
                            </div>
                        @endif
                        <div class="flex-1 text-left">
                            <div class="font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->getRoleNames()->first() }}</div>
                        </div>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.outside="open = false" x-transition class="absolute bottom-full left-0 w-full mb-2 bg-white rounded-md shadow-lg border">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon Profil</a>
                        <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Voir le Site</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 py-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Administration')</h1>
                    <div></div>
                </div>
            </header>
            
            <!-- Page Header -->
            <header class="hidden lg:block bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    @hasSection('header')
                        @yield('header')
                    @else
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('title', 'Administration')</h1>
                    @endif
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="px-6 py-6">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black bg-opacity-25 lg:hidden">
    </div>

    @stack('scripts')
    
    <script>
    // Écouter les événements de mise à jour d'avatar pour recharger la page
    document.addEventListener('livewire:init', function () {
        Livewire.on('avatar-updated', (event) => {
            // Recharger la page pour mettre à jour l'avatar dans la sidebar
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
        
        Livewire.on('avatar-deleted', (event) => {
            // Recharger la page pour mettre à jour la sidebar
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        });
    });
    </script>
</body>
</html>
