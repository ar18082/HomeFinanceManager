<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de la transaction récurrente') }}
            </h2>
            <div class="flex space-x-3">
                <form action="{{ route('recurring-transactions.generate', $recurringTransaction) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Générer maintenant') }}
                    </button>
                </form>
                <a href="{{ route('recurring-transactions.edit', $recurringTransaction) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Modifier') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Informations principales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Informations principales') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Description') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $recurringTransaction->description }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Type') }}</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($recurringTransaction->type === 'income') bg-green-100 text-green-800
                                            @elseif($recurringTransaction->type === 'expense') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ __($recurringTransaction->type) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Montant') }}</dt>
                                    <dd class="mt-1 text-sm font-semibold 
                                        @if($recurringTransaction->type === 'income') text-green-600
                                        @elseif($recurringTransaction->type === 'expense') text-red-600
                                        @else text-blue-600 @endif">
                                        {{ $recurringTransaction->currency->symbol }} {{ number_format($recurringTransaction->amount, 2) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Compte') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $recurringTransaction->account->name }}</dd>
                                </div>
                                @if($recurringTransaction->type === 'transfer')
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">{{ __('Compte de destination') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $recurringTransaction->destinationAccount->name }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Catégorie') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $recurringTransaction->category?->name ?? __('Non catégorisé') }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Fréquence') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($recurringTransaction->interval > 1)
                                            {{ __('Tous les') }} {{ $recurringTransaction->interval }}
                                            @if($recurringTransaction->frequency === 'daily')
                                                {{ __('jours') }}
                                            @elseif($recurringTransaction->frequency === 'weekly')
                                                {{ __('semaines') }}
                                            @elseif($recurringTransaction->frequency === 'monthly')
                                                {{ __('mois') }}
                                            @else
                                                {{ __('ans') }}
                                            @endif
                                        @else
                                            @if($recurringTransaction->frequency === 'daily')
                                                {{ __('Quotidienne') }}
                                            @elseif($recurringTransaction->frequency === 'weekly')
                                                {{ __('Hebdomadaire') }}
                                            @elseif($recurringTransaction->frequency === 'monthly')
                                                {{ __('Mensuelle') }}
                                            @else
                                                {{ __('Annuelle') }}
                                            @endif
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Date de début') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $recurringTransaction->start_date->format('d/m/Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Date de fin') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $recurringTransaction->end_date?->format('d/m/Y') ?? __('Aucune') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Prochaine génération') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $recurringTransaction->getNextDueDate()?->format('d/m/Y') ?? __('Terminée') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Nombre d\'occurrences') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($recurringTransaction->times_to_run)
                                            {{ $recurringTransaction->times_run }} / {{ $recurringTransaction->times_to_run }}
                                        @else
                                            {{ $recurringTransaction->times_run }} ({{ __('illimité') }})
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Statut') }}</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $recurringTransaction->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $recurringTransaction->active ? __('Active') : __('Inactive') }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    @if($recurringTransaction->notes)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500">{{ __('Notes') }}</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $recurringTransaction->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Dernières transactions générées -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Dernières transactions générées') }}</h3>
                    @if($transactions->isEmpty())
                        <p class="text-sm text-gray-500">{{ __('Aucune transaction n\'a encore été générée.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Montant') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm 
                                                @if($transaction->type === 'income') text-green-600
                                                @elseif($transaction->type === 'expense') text-red-600
                                                @else text-blue-600 @endif">
                                                {{ $transaction->currency->symbol }} {{ number_format($transaction->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('transactions.show', $transaction) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ __('Voir') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Bouton de suppression -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-red-600 mb-4">{{ __('Zone de danger') }}</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        {{ __('La suppression de cette transaction récurrente est définitive et ne peut pas être annulée. Les transactions déjà générées ne seront pas supprimées.') }}
                    </p>
                    <form action="{{ route('recurring-transactions.destroy', $recurringTransaction) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette transaction récurrente ?') }}')">
                            {{ __('Supprimer cette transaction récurrente') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 