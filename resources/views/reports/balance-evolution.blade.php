<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Évolution des soldes') }}
            </h2>
            <form method="GET" action="{{ route('reports.balance-evolution') }}" class="flex space-x-4">
                <div>
                    <x-input-label for="period" :value="__('Période')" />
                    <select id="period" name="period" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="3" {{ $period == 3 ? 'selected' : '' }}>{{ __('3 mois') }}</option>
                        <option value="6" {{ $period == 6 ? 'selected' : '' }}>{{ __('6 mois') }}</option>
                        <option value="12" {{ $period == 12 ? 'selected' : '' }}>{{ __('1 an') }}</option>
                        <option value="24" {{ $period == 24 ? 'selected' : '' }}>{{ __('2 ans') }}</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <x-primary-button>{{ __('Filtrer') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Vue d'ensemble -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('Vue d\'ensemble des comptes') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($accounts as $account)
                            <div class="bg-white rounded-lg border p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $account->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $account->currency->code }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-semibold {{ $account->balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($account->balance, 2) }} €
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Graphiques d'évolution -->
            @foreach($balanceHistory as $accountData)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            {{ $accountData['account']->name }}
                            <span class="text-sm text-gray-500 ml-2">{{ $accountData['account']->currency->code }}</span>
                        </h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="balanceChart{{ $accountData['account']->id }}"></canvas>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const balanceHistory = @json($balanceHistory);
            
            balanceHistory.forEach(accountData => {
                const ctx = document.getElementById(`balanceChart${accountData.account.id}`).getContext('2d');
                const history = accountData.history;

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: history.map(item => item.date),
                        datasets: [{
                            label: '{{ __("Solde") }}',
                            data: history.map(item => item.balance),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' €';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value + ' €';
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 10
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 