<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Analyse par catégorie') }}
            </h2>
            <form method="GET" action="{{ route('reports.by-category') }}" class="flex space-x-4">
                <div>
                    <x-input-label for="start_date" :value="__('Date de début')" />
                    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                        :value="$startDate->format('Y-m-d')" required />
                </div>
                <div>
                    <x-input-label for="end_date" :value="__('Date de fin')" />
                    <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                        :value="$endDate->format('Y-m-d')" required />
                </div>
                <div class="flex items-end">
                    <x-primary-button>{{ __('Filtrer') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Graphique de répartition globale -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Répartition globale par catégorie') }}</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="h-64">
                            <canvas id="globalExpenseChart"></canvas>
                        </div>
                        <div class="h-64">
                            <canvas id="globalIncomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques par catégorie -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('Statistiques par catégorie') }}</h3>
                    
                    @if($categoryStats->isEmpty())
                        <p class="text-gray-500 text-sm">{{ __('Aucune transaction catégorisée sur la période.') }}</p>
                    @else
                        <div class="space-y-8">
                            @foreach($categoryStats as $categoryName => $stats)
                                <div class="border-b pb-6 last:border-0 last:pb-0">
                                    <h4 class="text-base font-medium text-gray-900 mb-4">{{ $categoryName }}</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Revenus -->
                                        @if($stats->where('type', 'income')->isNotEmpty())
                                            <div class="bg-green-50 rounded-lg p-4">
                                                <div class="text-sm font-medium text-green-800 mb-2">{{ __('Revenus') }}</div>
                                                @php
                                                    $incomeStats = $stats->where('type', 'income')->first();
                                                @endphp
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <div class="text-sm text-green-600">{{ __('Total') }}</div>
                                                        <div class="text-lg font-medium text-green-900">
                                                            {{ number_format($incomeStats->total, 2) }} €
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-green-600">{{ __('Moyenne') }}</div>
                                                        <div class="text-lg font-medium text-green-900">
                                                            {{ number_format($incomeStats->average, 2) }} €
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-sm text-green-600">
                                                    {{ trans_choice('transactions', $incomeStats->count, ['count' => $incomeStats->count]) }}
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Dépenses -->
                                        @if($stats->where('type', 'expense')->isNotEmpty())
                                            <div class="bg-red-50 rounded-lg p-4">
                                                <div class="text-sm font-medium text-red-800 mb-2">{{ __('Dépenses') }}</div>
                                                @php
                                                    $expenseStats = $stats->where('type', 'expense')->first();
                                                @endphp
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <div class="text-sm text-red-600">{{ __('Total') }}</div>
                                                        <div class="text-lg font-medium text-red-900">
                                                            {{ number_format($expenseStats->total, 2) }} €
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-red-600">{{ __('Moyenne') }}</div>
                                                        <div class="text-lg font-medium text-red-900">
                                                            {{ number_format($expenseStats->average, 2) }} €
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-sm text-red-600">
                                                    {{ trans_choice('transactions', $expenseStats->count, ['count' => $expenseStats->count]) }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tendances -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('Tendances par catégorie') }}</h3>
                    
                    @if($categoryTrends->isEmpty())
                        <p class="text-gray-500 text-sm">{{ __('Aucune donnée disponible pour afficher les tendances.') }}</p>
                    @else
                        <div class="space-y-8">
                            @foreach($categoryTrends as $categoryName => $trends)
                                <div class="border-b pb-6 last:border-0 last:pb-0">
                                    <h4 class="text-base font-medium text-gray-900 mb-4">{{ $categoryName }}</h4>
                                    <div class="h-64">
                                        <canvas id="trendChart{{ Str::slug($categoryName) }}"></canvas>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données pour les graphiques
        const categoryStats = @json($categoryStats);
        const categoryTrends = @json($categoryTrends);

        // Graphique global des dépenses
        const expenseCtx = document.getElementById('globalExpenseChart').getContext('2d');
        const expenseData = [];
        const expenseLabels = [];

        Object.entries(categoryStats).forEach(([categoryName, stats]) => {
            const expenseStat = stats.find(s => s.type === 'expense');
            if (expenseStat) {
                expenseLabels.push(categoryName);
                expenseData.push(parseFloat(expenseStat.total));
            }
        });

        new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: expenseLabels,
                datasets: [{
                    data: expenseData,
                    backgroundColor: [
                        '#ef4444', '#f97316', '#eab308', '#84cc16', '#22c55e',
                        '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899', '#f43f5e'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: '{{ __("Répartition des dépenses") }}'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed.toLocaleString('fr-FR') + ' € (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Graphique global des revenus
        const incomeCtx = document.getElementById('globalIncomeChart').getContext('2d');
        const incomeData = [];
        const incomeLabels = [];

        Object.entries(categoryStats).forEach(([categoryName, stats]) => {
            const incomeStat = stats.find(s => s.type === 'income');
            if (incomeStat) {
                incomeLabels.push(categoryName);
                incomeData.push(parseFloat(incomeStat.total));
            }
        });

        new Chart(incomeCtx, {
            type: 'doughnut',
            data: {
                labels: incomeLabels,
                datasets: [{
                    data: incomeData,
                    backgroundColor: [
                        '#22c55e', '#16a34a', '#15803d', '#166534', '#14532d',
                        '#0d9488', '#0f766e', '#115e59', '#134e4a', '#042f2e'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: '{{ __("Répartition des revenus") }}'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed.toLocaleString('fr-FR') + ' € (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Graphiques de tendances par catégorie
        Object.entries(categoryTrends).forEach(([categoryName, trends]) => {
            const months = [...new Set(trends.map(t => t.month))].sort();
            const data = {
                income: months.map(month => {
                    const trend = trends.find(t => t.month === month && t.type === 'income');
                    return trend ? parseFloat(trend.total) : 0;
                }),
                expense: months.map(month => {
                    const trend = trends.find(t => t.month === month && t.type === 'expense');
                    return trend ? parseFloat(trend.total) : 0;
                })
            };

            const ctx = document.getElementById(`trendChart${categoryName.toLowerCase().replace(/[^a-z0-9]/g, '-')}`).getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months.map(month => {
                        const [year, monthNum] = month.split('-');
                        return new Date(year, monthNum - 1).toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' });
                    }),
                    datasets: [
                        {
                            label: '{{ __("Revenus") }}',
                            data: data.income,
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: '{{ __("Dépenses") }}',
                            data: data.expense,
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('fr-FR') + ' €';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout> 