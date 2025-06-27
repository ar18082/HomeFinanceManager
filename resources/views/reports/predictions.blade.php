<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prévisions financières') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Impact des transactions récurrentes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('Impact mensuel des transactions récurrentes') }}</h3>
                    
                    @if($recurringImpact['by_frequency']->isEmpty())
                        <p class="text-gray-500 text-sm">{{ __('Aucune transaction récurrente active.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-green-800 mb-2">{{ __('Revenus mensuels récurrents') }}</div>
                                <div class="text-2xl font-semibold text-green-600">
                                    {{ number_format($recurringImpact['total_monthly_income'], 2) }} €
                                </div>
                            </div>
                            <div class="bg-red-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-red-800 mb-2">{{ __('Dépenses mensuelles récurrentes') }}</div>
                                <div class="text-2xl font-semibold text-red-600">
                                    {{ number_format($recurringImpact['total_monthly_expenses'], 2) }} €
                                </div>
                            </div>
                        </div>

                        <div class="space-y-8">
                            @foreach($recurringImpact['by_frequency'] as $frequency => $transactions)
                                <div class="border-b pb-6 last:border-0 last:pb-0">
                                    <h4 class="text-base font-medium text-gray-900 mb-4">
                                        {{ __('Fréquence') }} : {{ __($frequency) }}
                                    </h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Description') }}
                                                    </th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Catégorie') }}
                                                    </th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Compte') }}
                                                    </th>
                                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Montant initial') }}
                                                    </th>
                                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Impact mensuel') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($transactions as $transaction)
                                                    <tr>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $transaction['description'] }}
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $transaction['category'] ?? __('Sans catégorie') }}
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $transaction['account'] }}
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-right {{ $transaction['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                            {{ $transaction['type'] === 'income' ? '+' : '-' }}{{ number_format($transaction['original_amount'], 2) }} €
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-right {{ $transaction['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                            {{ $transaction['type'] === 'income' ? '+' : '-' }}{{ number_format($transaction['monthly_amount'], 2) }} €
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Prévisions sur 3 mois -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('Prévisions sur les 3 prochains mois') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($predictions as $prediction)
                            <div class="bg-white rounded-lg border p-6">
                                <div class="text-lg font-medium text-gray-900 mb-4">{{ \Carbon\Carbon::createFromFormat('Y-m', $prediction['month'])->format('F Y') }}</div>
                                
                                <!-- Transactions récurrentes -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Transactions récurrentes') }}</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500">{{ __('Revenus') }}</div>
                                            <div class="text-base font-medium text-green-600">
                                                {{ number_format($prediction['recurring']['income'], 2) }} €
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">{{ __('Dépenses') }}</div>
                                            <div class="text-base font-medium text-red-600">
                                                {{ number_format($prediction['recurring']['expenses'], 2) }} €
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estimations basées sur l'historique -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Estimations (moyenne)') }}</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500">{{ __('Revenus') }}</div>
                                            <div class="text-base font-medium text-green-600">
                                                {{ number_format($prediction['estimated']['income'], 2) }} €
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">{{ __('Dépenses') }}</div>
                                            <div class="text-base font-medium text-red-600">
                                                {{ number_format($prediction['estimated']['expenses'], 2) }} €
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transactions prévues -->
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Transactions prévues') }}</h4>
                                    <div class="space-y-2 max-h-48 overflow-y-auto">
                                        @foreach($prediction['transactions'] as $transaction)
                                            <div class="flex justify-between items-center text-sm">
                                                <div class="text-gray-600">{{ $transaction['description'] }}</div>
                                                <div class="{{ $transaction['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $transaction['type'] === 'income' ? '+' : '-' }}{{ number_format($transaction['amount'], 2) }} €
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 