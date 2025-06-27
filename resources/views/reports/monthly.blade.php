<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rapport mensuel') }} - {{ $date->format('F Y') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('reports.monthly', ['date' => $date->copy()->subMonth()->format('Y-m')]) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{ __('Mois précédent') }}
                </a>
                <a href="{{ route('reports.monthly', ['date' => $date->copy()->addMonth()->format('Y-m')]) }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Mois suivant') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Résumé du mois -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Résumé du mois') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-lg border p-4">
                            <div class="text-sm font-medium text-gray-500">{{ __('Revenus') }}</div>
                            <div class="mt-1 text-2xl font-semibold text-green-600">
                                {{ number_format($stats['income'], 2) }} €
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border p-4">
                            <div class="text-sm font-medium text-gray-500">{{ __('Dépenses') }}</div>
                            <div class="mt-1 text-2xl font-semibold text-red-600">
                                {{ number_format($stats['expenses'], 2) }} €
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border p-4">
                            <div class="text-sm font-medium text-gray-500">{{ __('Solde') }}</div>
                            <div class="mt-1 text-2xl font-semibold {{ $stats['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($stats['balance'], 2) }} €
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border p-4">
                            <div class="text-sm font-medium text-gray-500">{{ __('Transactions') }}</div>
                            <div class="mt-1 text-2xl font-semibold text-blue-600">
                                {{ $stats['transaction_count'] }}
                            </div>
                            <div class="mt-1 text-sm text-gray-500">
                                {{ __('dont') }} {{ $stats['recurring_count'] }} {{ __('récurrentes') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Évolution quotidienne -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Évolution quotidienne') }}</h3>
                        <div class="h-64">
                            <canvas id="dailyBalanceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Répartition par catégorie (graphique) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Répartition par catégorie') }}</h3>
                        <div class="h-64">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Répartition par catégorie (détail) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Détail par catégorie') }}</h3>
                        @if($categoryBreakdown->isEmpty())
                            <p class="text-gray-500 text-sm">{{ __('Aucune transaction catégorisée ce mois-ci.') }}</p>
                        @else
                            <div class="space-y-8">
                                <!-- Dépenses par catégorie -->
                                @if($categoryBreakdown->has('expense'))
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-3">{{ __('Dépenses') }}</h4>
                                        <div class="space-y-3">
                                            @foreach($categoryBreakdown['expense'] as $category)
                                                <div class="flex items-center">
                                                    <div class="w-32 text-sm text-gray-600">{{ $category->category->name }}</div>
                                                    <div class="flex-1">
                                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-100">
                                                            <div style="width: {{ ($category->total / $categoryBreakdown['expense']->max('total')) * 100 }}%"
                                                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-32 text-right">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ number_format($category->total, 2) }} €
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $category->count }} {{ __('transactions') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Revenus par catégorie -->
                                @if($categoryBreakdown->has('income'))
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-3">{{ __('Revenus') }}</h4>
                                        <div class="space-y-3">
                                            @foreach($categoryBreakdown['income'] as $category)
                                                <div class="flex items-center">
                                                    <div class="w-32 text-sm text-gray-600">{{ $category->category->name }}</div>
                                                    <div class="flex-1">
                                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-100">
                                                            <div style="width: {{ ($category->total / $categoryBreakdown['income']->max('total')) * 100 }}%"
                                                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-32 text-right">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ number_format($category->total, 2) }} €
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $category->count }} {{ __('transactions') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Plus grandes transactions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Plus grandes transactions') }}</h3>
                        @if($largestTransactions->isEmpty())
                            <p class="text-gray-500 text-sm">{{ __('Aucune transaction ce mois-ci.') }}</p>
                        @else
                            <div class="space-y-4">
                                @foreach($largestTransactions as $transaction)
                                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">{{ $transaction->description }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $transaction->date->format('d/m/Y') }} - 
                                                {{ $transaction->category?->name ?? __('Sans catégorie') }} - 
                                                {{ $transaction->account->name }}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-medium {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} €
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données pour les graphiques
        const dailyData = @json($dailyBalance);
        const categoryData = @json($categoryBreakdown);

        // Graphique d'évolution quotidienne
        const dailyCtx = document.getElementById('dailyBalanceChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyData.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
                }),
                datasets: [{
                    label: '{{ __("Solde quotidien") }}',
                    data: dailyData.map(item => item.daily_balance),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
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
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Graphique des catégories
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        
        // Préparer les données pour le graphique
        const expenseCategories = categoryData.expense || [];
        const incomeCategories = categoryData.income || [];
        
        const chartData = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        };

        // Couleurs pour les catégories
        const colors = [
            '#ef4444', '#f97316', '#eab308', '#84cc16', '#22c55e',
            '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899', '#f43f5e',
            '#a855f7', '#8b5cf6', '#6366f1', '#3b82f6', '#0ea5e9'
        ];

        let colorIndex = 0;

        // Ajouter les dépenses
        expenseCategories.forEach(category => {
            chartData.labels.push(category.category.name + ' (Dépense)');
            chartData.datasets[0].data.push(parseFloat(category.total));
            chartData.datasets[0].backgroundColor.push(colors[colorIndex % colors.length]);
            colorIndex++;
        });

        // Ajouter les revenus
        incomeCategories.forEach(category => {
            chartData.labels.push(category.category.name + ' (Revenu)');
            chartData.datasets[0].data.push(parseFloat(category.total));
            chartData.datasets[0].backgroundColor.push(colors[colorIndex % colors.length]);
            colorIndex++;
        });

        new Chart(categoryCtx, {
            type: 'doughnut',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
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
    </script>
</x-app-layout> 