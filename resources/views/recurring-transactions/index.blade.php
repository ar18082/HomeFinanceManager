<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transactions récurrentes') }}
            </h2>
            <a href="{{ route('recurring-transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Nouvelle transaction récurrente') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Gestion des transactions récurrentes') }}</h3>
                    <p class="text-gray-600 mb-4">
                        {{ __('Automatisez vos transactions régulières comme les salaires, loyers, factures ou virements. Les transactions seront créées automatiquement selon la fréquence définie.') }}
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2">{{ __('Fréquences flexibles') }}</h4>
                            <p class="text-sm text-blue-600">{{ __('Définissez des transactions quotidiennes, hebdomadaires, mensuelles ou annuelles.') }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2">{{ __('Automatisation') }}</h4>
                            <p class="text-sm text-green-600">{{ __('Les transactions sont créées automatiquement à la date prévue sans intervention manuelle.') }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-2">{{ __('Contrôle total') }}</h4>
                            <p class="text-sm text-purple-600">{{ __('Définissez une date de fin ou un nombre limité d\'occurrences pour chaque transaction.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des transactions récurrentes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($recurringTransactions->isEmpty())
                        <p class="text-center text-gray-500">{{ __('Aucune transaction récurrente trouvée.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fréquence</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prochaine date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recurringTransactions as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $transaction->description }}
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
                                                @if($transaction->interval > 1)
                                                    {{ __('Tous les') }} {{ $transaction->interval }}
                                                    @if($transaction->frequency === 'daily')
                                                        {{ __('jours') }}
                                                    @elseif($transaction->frequency === 'weekly')
                                                        {{ __('semaines') }}
                                                    @elseif($transaction->frequency === 'monthly')
                                                        {{ __('mois') }}
                                                    @else
                                                        {{ __('ans') }}
                                                    @endif
                                                @else
                                                    @if($transaction->frequency === 'daily')
                                                        {{ __('Quotidienne') }}
                                                    @elseif($transaction->frequency === 'weekly')
                                                        {{ __('Hebdomadaire') }}
                                                    @elseif($transaction->frequency === 'monthly')
                                                        {{ __('Mensuelle') }}
                                                    @else
                                                        {{ __('Annuelle') }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $transaction->getNextDueDate()?->format('d/m/Y') ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $transaction->active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('recurring-transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    {{ __('Voir') }}
                                                </a>
                                                <a href="{{ route('recurring-transactions.edit', $transaction) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    {{ __('Modifier') }}
                                                </a>
                                                <form action="{{ route('recurring-transactions.destroy', $transaction) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette transaction récurrente ?') }}')">
                                                        {{ __('Supprimer') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $recurringTransactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 