<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Comptes') }}
            </h2>
            <a href="{{ route('accounts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Nouveau compte') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Gestion des comptes') }}</h3>
                    <p class="text-gray-600 mb-4">
                        {{ __('Gérez tous vos comptes bancaires, cartes de crédit et comptes d\'épargne au même endroit. Suivez vos soldes et organisez vos finances de manière centralisée.') }}
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2">{{ __('Comptes courants') }}</h4>
                            <p class="text-sm text-blue-600">{{ __('Vos comptes bancaires principaux') }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2">{{ __('Épargne') }}</h4>
                            <p class="text-sm text-green-600">{{ __('Comptes d\'épargne et placements') }}</p>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <h4 class="font-medium text-yellow-800 mb-2">{{ __('Cartes de crédit') }}</h4>
                            <p class="text-sm text-yellow-600">{{ __('Cartes de crédit et comptes de crédit') }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-2">{{ __('Espèces') }}</h4>
                            <p class="text-sm text-purple-600">{{ __('Comptes espèces et liquide') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des comptes par type -->
            @foreach($accounts as $type => $typeAccounts)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __(ucfirst($type)) }} 
                                <span class="text-sm font-normal text-gray-500">({{ $typeAccounts->count() }} compte(s))</span>
                            </h3>
                            <div class="text-right">
                                <span class="text-sm text-gray-500">Total :</span>
                                <span class="text-lg font-semibold text-gray-900">
                                    {{ $typeAccounts->first()->currency->symbol ?? '€' }} {{ number_format($totalsByType[$type] ?? 0, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($typeAccounts->isEmpty())
                            <p class="text-center text-gray-500 py-4">{{ __('Aucun compte de ce type.') }}</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($typeAccounts as $account)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $account->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $account->description ?: 'Aucune description' }}</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if($account->active)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ __('Actif') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ __('Inactif') }}
                                                    </span>
                                                @endif
                                                @if($account->include_in_net_worth)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ __('Valeur nette') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="text-2xl font-bold text-gray-900">
                                                {{ $account->currency->symbol }} {{ number_format($account->current_balance, 2) }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $account->transactions_count }} transaction(s)
                                            </div>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('accounts.show', $account) }}" 
                                                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                    {{ __('Voir') }}
                                                </a>
                                                <a href="{{ route('accounts.edit', $account) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                    {{ __('Modifier') }}
                                                </a>
                                            </div>
                                            <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 text-sm font-medium"
                                                        onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce compte ?') }}')">
                                                    {{ __('Supprimer') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            @if($accounts->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Aucun compte trouvé') }}</h3>
                        <p class="text-gray-500 mb-4">{{ __('Commencez par créer votre premier compte pour gérer vos finances.') }}</p>
                        <a href="{{ route('accounts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Créer un compte') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 