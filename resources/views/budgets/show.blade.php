<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $budget->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('budgets.edit', $budget) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Modifier') }}
                </a>
                <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce budget ?') }}')">
                        {{ __('Supprimer') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informations générales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Informations générales') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Catégorie') }}</p>
                            <p class="text-base font-medium">{{ $budget->category->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Montant') }}</p>
                            <p class="text-base font-medium">{{ $budget->currency->symbol }} {{ number_format($budget->amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Période') }}</p>
                            <p class="text-base font-medium">
                                @if($budget->period === 'monthly')
                                    {{ __('Mensuel') }}
                                @elseif($budget->period === 'yearly')
                                    {{ __('Annuel') }}
                                @else
                                    {{ __('Personnalisé') }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Statut') }}</p>
                            <p class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $budget->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $budget->active ? __('Actif') : __('Inactif') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Date de début') }}</p>
                            <p class="text-base font-medium">{{ $budget->start_date->format('d/m/Y') }}</p>
                        </div>
                        @if($budget->end_date)
                        <div>
                            <p class="text-sm text-gray-600">{{ __('Date de fin') }}</p>
                            <p class="text-base font-medium">{{ $budget->end_date->format('d/m/Y') }}</p>
                        </div>
                        @endif
                    </div>
                    @if($budget->notes)
                    <div class="mt-6">
                        <p class="text-sm text-gray-600">{{ __('Notes') }}</p>
                        <p class="text-base mt-1">{{ $budget->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Progression -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Progression') }}</h3>
                    <div class="space-y-4">
                        @php
                            $percentage = $budget->amount > 0 ? ($expenses / $budget->amount) * 100 : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-base font-medium text-gray-700">{{ __('Dépenses') }}</span>
                                <span class="text-sm font-medium text-gray-700">{{ number_format($percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full {{ $percentage > 100 ? 'bg-red-600' : ($percentage > 80 ? 'bg-yellow-400' : 'bg-green-600') }}"
                                     style="width: {{ min($percentage, 100) }}%"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">{{ __('Budget prévu') }}</p>
                                <p class="text-xl font-semibold text-gray-900">{{ $budget->currency->symbol }} {{ number_format($budget->amount, 2) }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">{{ __('Dépenses actuelles') }}</p>
                                <p class="text-xl font-semibold {{ $percentage > 100 ? 'text-red-600' : ($percentage > 80 ? 'text-yellow-600' : 'text-green-600') }}">
                                    {{ $budget->currency->symbol }} {{ number_format($expenses, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dernières transactions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Dernières transactions') }}</h3>
                    @php
                        $transactions = Auth::user()
                            ->transactions()
                            ->where('category_id', $budget->category_id)
                            ->where('type', 'expense')
                            ->whereBetween('date', [$budget->start_date, $budget->end_date ?? now()])
                            ->latest()
                            ->limit(5)
                            ->get();
                    @endphp
                    @if($transactions->isEmpty())
                        <p class="text-gray-500 text-center py-4">{{ __('Aucune transaction trouvée pour ce budget.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
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