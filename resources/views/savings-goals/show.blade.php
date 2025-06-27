<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $savingsGoal->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('savings-goals.edit', $savingsGoal) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Modifier') }}
                </a>
                <form action="{{ route('savings-goals.destroy', $savingsGoal) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cet objectif ?') }}')">
                        {{ __('Supprimer') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Informations générales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Informations générales') }}</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Compte') }}</p>
                                    <p class="text-base font-medium">{{ $savingsGoal->account->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Devise') }}</p>
                                    <p class="text-base font-medium">{{ $savingsGoal->currency->code }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Date cible') }}</p>
                                    <p class="text-base font-medium">{{ $savingsGoal->target_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">{{ __('Statut') }}</p>
                                    <p class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $savingsGoal->completed ? 'bg-green-100 text-green-800' : ($savingsGoal->active ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        @if($savingsGoal->completed)
                                            {{ __('Complété') }}
                                        @elseif($savingsGoal->active)
                                            {{ __('En cours') }}
                                        @else
                                            {{ __('Inactif') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if($savingsGoal->description)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">{{ __('Description') }}</p>
                                    <p class="text-base mt-1">{{ $savingsGoal->description }}</p>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Progression') }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-base font-medium text-gray-700">{{ number_format($savingsGoal->getProgressPercentage(), 1) }}%</span>
                                        <span class="text-sm font-medium text-gray-500">
                                            {{ $savingsGoal->currency->symbol }} {{ number_format($savingsGoal->current_amount, 2) }} / {{ number_format($savingsGoal->target_amount, 2) }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full bg-blue-600" style="width: {{ $savingsGoal->getProgressPercentage() }}%"></div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-600">{{ __('Montant restant') }}</p>
                                        <p class="text-xl font-semibold text-gray-900">
                                            {{ $savingsGoal->currency->symbol }} {{ number_format($savingsGoal->getRemainingAmount(), 2) }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm text-gray-600">{{ __('Jours restants') }}</p>
                                        <p class="text-xl font-semibold text-gray-900">{{ $savingsGoal->getDaysRemaining() }}</p>
                                    </div>
                                </div>

                                @if(!$savingsGoal->completed)
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <p class="text-sm text-blue-600">{{ __('Épargne mensuelle suggérée') }}</p>
                                        <p class="text-xl font-semibold text-blue-900">
                                            {{ $savingsGoal->currency->symbol }} {{ number_format($savingsGoal->getMonthlyTargetAmount(), 2) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ajouter une progression -->
            @if(!$savingsGoal->completed && $savingsGoal->active)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Ajouter une progression') }}</h3>
                        <form action="{{ route('savings-goals.add-progress', $savingsGoal) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="amount" :value="__('Montant')" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">{{ $savingsGoal->currency->symbol }}</span>
                                    </div>
                                    <x-text-input id="amount" name="amount" type="number" class="block w-full pl-7" step="0.01" min="0" required />
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>
                            <div class="flex justify-end">
                                <x-primary-button>
                                    {{ __('Ajouter') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Dernières transactions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Dernières transactions') }}</h3>
                    @if($transactions->isEmpty())
                        <p class="text-center text-gray-500 py-4">{{ __('Aucune transaction trouvée.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Montant') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $transaction->date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $transaction->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-green-600">
                                                {{ $transaction->currency->symbol }} {{ number_format($transaction->amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 