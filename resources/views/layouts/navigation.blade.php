<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 mt-4">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="block h-16 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                   
                    
                    <!-- Transactions Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('Transactions') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('transactions.index')">
                                {{ __('Liste transactions') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('transactions.create')">
                                {{ __('Créer transaction') }}
                            </x-dropdown-link>
                            {{--add liste transaction récurente--}}
                            <x-dropdown-link :href="route('recurring-transactions.index')">
                                {{ __('Liste transactions récurrentes') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('recurring-transactions.create')">
                                {{ __('Créer une transaction récurrente') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Budgets Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('Budgets') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('budgets.index')">
                                {{ __('Liste') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('budgets.create')">
                                {{ __('Créer') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Credits Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('Crédits') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('credits.index')">
                                {{ __('Liste') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('credits.create')">
                                {{ __('Créer') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Rapports Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('Rapports') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('reports.index')">
                                {{ __('Vue d\'ensemble') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.monthly')">
                                {{ __('Mensuel') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.by-category')">
                                {{ __('Par catégorie') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.balance-evolution')">
                                {{ __('Évolution du solde') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.predictions')">
                                {{ __('Prédictions') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Épargne Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('Épargne') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('savings-goals.index')">
                                {{ __('Liste') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('savings-goals.create')">
                                {{ __('Créer') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Comptes Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('Comptes') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('accounts.index')">
                                {{ __('Liste') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('accounts.create')">
                                {{ __('Créer') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Compteurs d'énergie Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ __('Énergie') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('energy-meters.index')">
                                {{ __('Compteurs') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('energy-meters.create')">
                                {{ __('Ajouter compteur') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('energy-readings.create')">
                                {{ __('Ajouter relevé') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('energy-providers.index')">
                                {{ __('Fournisseurs') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Notifications -->
                <x-notification-dropdown :user="Auth::user()" />
                
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <!-- Responsive Transactions -->
            <div class="px-4 py-2">
                <div class="font-medium text-sm text-gray-600 mb-2">{{ __('Transactions') }}</div>
                <div class="ml-4 space-y-1">
                    <x-responsive-nav-link :href="route('transactions.index')">
                        {{ __('Liste') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('transactions.create')">
                        {{ __('Créer') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Responsive Budgets -->
            <div class="px-4 py-2">
                <div class="font-medium text-sm text-gray-600 mb-2">{{ __('Budgets') }}</div>
                <div class="ml-4 space-y-1">
                    <x-responsive-nav-link :href="route('budgets.index')">
                        {{ __('Liste') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('budgets.create')">
                        {{ __('Créer') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Responsive Credits -->
            <div class="px-4 py-2">
                <div class="font-medium text-sm text-gray-600 mb-2">{{ __('Crédits') }}</div>
                <div class="ml-4 space-y-1">
                    <x-responsive-nav-link :href="route('credits.index')">
                        {{ __('Liste') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('credits.create')">
                        {{ __('Créer') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Responsive Rapports -->
            <div class="px-4 py-2">
                <div class="font-medium text-sm text-gray-600 mb-2">{{ __('Rapports') }}</div>
                <div class="ml-4 space-y-1">
                    <x-responsive-nav-link :href="route('reports.index')">
                        {{ __('Vue d\'ensemble') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reports.monthly')">
                        {{ __('Mensuel') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reports.by-category')">
                        {{ __('Par catégorie') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reports.balance-evolution')">
                        {{ __('Évolution du solde') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reports.predictions')">
                        {{ __('Prédictions') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Responsive Épargne -->
            <div class="px-4 py-2">
                <div class="font-medium text-sm text-gray-600 mb-2">{{ __('Épargne') }}</div>
                <div class="ml-4 space-y-1">
                    <x-responsive-nav-link :href="route('savings-goals.index')">
                        {{ __('Liste') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('savings-goals.create')">
                        {{ __('Créer') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Responsive Comptes -->
            <div class="px-4 py-2">
                <div class="font-medium text-sm text-gray-600 mb-2">{{ __('Comptes') }}</div>
                <div class="ml-4 space-y-1">
                    <x-responsive-nav-link :href="route('accounts.index')">
                        {{ __('Liste') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('accounts.create')">
                        {{ __('Créer') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Responsive Compteurs d'énergie -->
            <div class="px-4 py-2">
                <div class="font-medium text-sm text-gray-600 mb-2">{{ __('Énergie') }}</div>
                <div class="ml-4 space-y-1">
                    <x-responsive-nav-link :href="route('energy-meters.index')">
                        {{ __('Compteurs') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('energy-meters.create')">
                        {{ __('Ajouter compteur') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('energy-readings.create')">
                        {{ __('Ajouter relevé') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('energy-providers.index')">
                        {{ __('Fournisseurs') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                {{ __('Notifications') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
