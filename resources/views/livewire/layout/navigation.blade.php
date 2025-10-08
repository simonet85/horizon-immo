<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    public $userAvatar;
    public $userName;
    
    public function mount()
    {
        $this->userAvatar = auth()->user()->avatar;
        $this->userName = auth()->user()->name;
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
    
    protected function getListeners()
    {
        return [
            'avatar-updated' => 'refreshAvatar',
            'avatar-deleted' => 'refreshAvatar',
            'profile-updated' => 'refreshProfile',
        ];
    }
    
    public function refreshAvatar()
    {
        $this->userAvatar = auth()->user()->fresh()->avatar;
    }
    
    public function refreshProfile()
    {
        $user = auth()->user()->fresh();
        $this->userAvatar = $user->avatar;
        $this->userName = $user->name;
    }
    
    /**
     * Get user initials from name
     */
    public function getUserInitials()
    {
        $name = trim($this->userName);
        if (empty($name)) {
            return 'U';
        }
        
        // Séparer par espaces et tirets
        $nameParts = preg_split('/[\s\-]+/', $name);
        $initials = '';
        
        foreach ($nameParts as $part) {
            $part = trim($part);
            if (!empty($part)) {
                $initials .= strtoupper(substr($part, 0, 1));
            }
        }
        
        return empty($initials) ? 'U' : $initials;
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->hasRole('admin'))
                        <!-- Navigation Admin -->
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" wire:navigate>
                            {{ __('Administration') }}
                        </x-nav-link>
                    @elseif(auth()->user()->hasRole('client'))
                        <!-- Navigation Client -->
                        <x-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('client.applications.index')" :active="request()->routeIs('client.applications.*')" wire:navigate>
                            {{ __('Mes Applications') }}
                        </x-nav-link>
                        <x-nav-link :href="route('client.messages.index')" :active="request()->routeIs('client.messages.*') || request()->routeIs('client.contact-messages.*')" wire:navigate>
                            {{ __('Mes Messages') }}
                        </x-nav-link>
                    @else
                        <!-- Navigation par défaut -->
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <!-- Avatar -->
                            <div class="flex items-center">
                                @if($userAvatar)
                                    <img src="{{ Storage::url($userAvatar) }}" 
                                         alt="Avatar de {{ $userName }}" 
                                         class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 mr-3">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm mr-3 border-2 border-gray-200">
                                        {{ $this->getUserInitials() }}
                                    </div>
                                @endif
                                
                                <div>{{ $userName }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center">
                                @if($userAvatar)
                                    <img src="{{ Storage::url($userAvatar) }}" 
                                         alt="Avatar de {{ $userName }}" 
                                         class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 mr-3">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold mr-3 border-2 border-gray-200">
                                        {{ $this->getUserInitials() }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-gray-900">{{ $userName }}</div>
                                    <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <x-dropdown-link :href="route('profile')" wire:navigate class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->hasRole('admin'))
                <!-- Navigation Admin Responsive -->
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" wire:navigate>
                    {{ __('Administration') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->hasRole('client'))
                <!-- Navigation Client Responsive -->
                <x-responsive-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.applications.index')" :active="request()->routeIs('client.applications.*')" wire:navigate>
                    {{ __('Mes Applications') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.messages.index')" :active="request()->routeIs('client.messages.*') || request()->routeIs('client.contact-messages.*')" wire:navigate>
                    {{ __('Mes Messages') }}
                </x-responsive-nav-link>
            @else
                <!-- Navigation par défaut Responsive -->
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="flex items-center mb-3">
                    @if($userAvatar)
                        <img src="{{ Storage::url($userAvatar) }}" 
                             alt="Avatar de {{ $userName }}" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 mr-3">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold mr-3 border-2 border-gray-200">
                            {{ $this->getUserInitials() }}
                        </div>
                    @endif
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ $userName }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
