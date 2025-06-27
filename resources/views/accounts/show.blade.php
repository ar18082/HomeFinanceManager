<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $account->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('accounts.edit', $account) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Modifier') }}
                </a>
                <a href="{{ route('accounts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Retour') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informations du compte -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations générales -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Informations du compte') }}</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Nom') }}</dt>
                                    <dd class="text-sm text-gray-900">{{ $account->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Type') }}</dt>
                                    <dd class="text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($account->type === 'checking') bg-blue-100 text-blue-800
                                            @elseif($account->type === 'savings') bg-green-100 text-green-800
                                            @elseif($account->type === 'cash') bg-purple-100 text-purple-800
                                            @elseif($account->type === 'credit_card') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ __(ucfirst($account->type)) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Devise') }}</dt>
                                    <dd class="text-sm text-gray-900">{{ $account->currency->name }} ({{ $account->currency->code }})</dd>
                                </div>
                                @if($account->description)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">{{ __('Description') }}</dt>
                                        <dd class="text-sm text-gray-900">{{ $account->description }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Statut') }}</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($account->active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ __('Actif') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ __('Inactif') }}
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Valeur nette') }}</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($account->include_in_net_worth)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ __('Inclus') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ __('Exclu') }}
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Soldes -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Soldes') }}</h3>
                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Solde initial') }}</dt>
                                    <dd class="text-2xl font-bold text-gray-900">
                                        {{ $account->currency->symbol }} {{ number_format($account->initial_balance, 2) }}
                                    </dd>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-blue-600">{{ __('Solde courant') }}</dt>
                                    <dd class="text-2xl font-bold text-blue-900">
                                        {{ $account->currency->symbol }} {{ number_format($account->current_balance, 2) }}
                                    </dd>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-green-600">{{ __('Différence') }}</dt>
                                    <dd class="text-lg font-semibold @if($account->current_balance >= $account->initial_balance) text-green-900 @else text-red-900 @endif">
                                        {{ $account->currency->symbol }} {{ number_format($account->current_balance - $account->initial_balance, 2) }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions récentes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Transactions récentes') }}</h3>
                        <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            {{ __('Nouvelle transaction') }}
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($account->transactions->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-gray-400 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Aucune transaction') }}</h3>
                            <p class="text-gray-500 mb-4">{{ __('Ce compte n\'a pas encore de transactions.') }}</p>
                            <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Ajouter une transaction') }}
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Montant') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Catégorie') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($account->transactions as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $transaction->date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($transaction->type === 'income') bg-green-100 text-green-800
                                                    @elseif($transaction->type === 'expense') bg-red-100 text-red-800
                                                    @else bg-blue-100 text-blue-800 @endif">
                                                    {{ __($transaction->type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm 
                                                @if($transaction->type === 'income') text-green-600
                                                @elseif($transaction->type === 'expense') text-red-600
                                                @else text-blue-600 @endif">
                                                {{ $transaction->currency->symbol }} {{ number_format($transaction->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $transaction->category?->name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($transaction->description, 50) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    {{ __('Voir') }}
                                                </a>
                                                <a href="{{ route('transactions.edit', $transaction) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ __('Modifier') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($account->transactions->count() >= 10)
                            <div class="mt-4 text-center">
                                <a href="{{ route('transactions.index', ['account_id' => $account->id]) }}" 
                                   class="text-blue-600 hover:text-blue-900 font-medium">
                                    {{ __('Voir toutes les transactions') }}
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 