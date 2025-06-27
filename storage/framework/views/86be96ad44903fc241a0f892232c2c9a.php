<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Rapports financiers')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Menu des rapports -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Types de rapports disponibles')); ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="<?php echo e(route('reports.monthly')); ?>" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <h4 class="text-blue-800 font-medium mb-2"><?php echo e(__('Rapport mensuel')); ?></h4>
                            <p class="text-blue-600 text-sm"><?php echo e(__('Vue détaillée des transactions et statistiques du mois.')); ?></p>
                        </a>
                        <a href="<?php echo e(route('reports.by-category')); ?>" class="block p-6 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <h4 class="text-green-800 font-medium mb-2"><?php echo e(__('Analyse par catégorie')); ?></h4>
                            <p class="text-green-600 text-sm"><?php echo e(__('Répartition des dépenses et revenus par catégorie.')); ?></p>
                        </a>
                        <a href="<?php echo e(route('reports.balance-evolution')); ?>" class="block p-6 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <h4 class="text-purple-800 font-medium mb-2"><?php echo e(__('Évolution des soldes')); ?></h4>
                            <p class="text-purple-600 text-sm"><?php echo e(__('Suivi de l\'évolution de vos soldes dans le temps.')); ?></p>
                        </a>
                        <a href="<?php echo e(route('reports.predictions')); ?>" class="block p-6 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            <h4 class="text-yellow-800 font-medium mb-2"><?php echo e(__('Prévisions')); ?></h4>
                            <p class="text-yellow-600 text-sm"><?php echo e(__('Prévisions basées sur vos transactions récurrentes.')); ?></p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Résumé du mois en cours -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Aperçu du mois en cours')); ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-lg border p-4">
                            <div class="text-sm font-medium text-gray-500"><?php echo e(__('Revenus')); ?></div>
                            <div class="mt-1 text-2xl font-semibold text-green-600">
                                <?php echo e(number_format($monthlyStats['income'], 2)); ?> €
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border p-4">
                            <div class="text-sm font-medium text-gray-500"><?php echo e(__('Dépenses')); ?></div>
                            <div class="mt-1 text-2xl font-semibold text-red-600">
                                <?php echo e(number_format($monthlyStats['expenses'], 2)); ?> €
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border p-4">
                            <div class="text-sm font-medium text-gray-500"><?php echo e(__('Solde total')); ?></div>
                            <div class="mt-1 text-2xl font-semibold <?php echo e($monthlyStats['balance'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                <?php echo e(number_format($monthlyStats['balance'], 2)); ?> €
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border p-4">
                            <div class="text-sm font-medium text-gray-500"><?php echo e(__('Transactions')); ?></div>
                            <div class="mt-1 text-2xl font-semibold text-blue-600">
                                <?php echo e($monthlyStats['transaction_count']); ?>

                            </div>
                            <div class="mt-1 text-sm text-gray-500">
                                <?php echo e(__('dont')); ?> <?php echo e($monthlyStats['recurring_count']); ?> <?php echo e(__('récurrentes')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Évolution des revenus/dépenses sur 6 mois -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Évolution des revenus et dépenses (6 mois)')); ?></h3>
                        <div class="h-64">
                            <canvas id="balanceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Répartition des dépenses par catégorie -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Répartition des dépenses par catégorie')); ?></h3>
                        <div class="h-64">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top 5 des catégories de dépenses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Top 5 des catégories de dépenses')); ?></h3>
                        <?php if($topExpenseCategories->isEmpty()): ?>
                            <p class="text-gray-500 text-sm"><?php echo e(__('Aucune dépense catégorisée ce mois-ci.')); ?></p>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $topExpenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center">
                                        <div class="w-32 text-sm text-gray-600"><?php echo e($category->category->name); ?></div>
                                        <div class="flex-1">
                                            <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-100">
                                                <div style="width: <?php echo e(($category->total / $topExpenseCategories->max('total')) * 100); ?>%"
                                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-24 text-right text-sm font-medium text-gray-900">
                                            <?php echo e(number_format($category->total, 2)); ?> €
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Prévisions pour le mois prochain -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Prévisions pour le mois prochain')); ?></h3>
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-2"><?php echo e(__('Transactions récurrentes')); ?></h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="text-sm text-gray-500"><?php echo e(__('Revenus prévus')); ?></div>
                                        <div class="text-lg font-medium text-green-600">
                                            <?php echo e(number_format($nextMonthPredictions['recurring_income'], 2)); ?> €
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500"><?php echo e(__('Dépenses prévues')); ?></div>
                                        <div class="text-lg font-medium text-red-600">
                                            <?php echo e(number_format($nextMonthPredictions['recurring_expenses'], 2)); ?> €
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-2"><?php echo e(__('Moyennes (3 derniers mois)')); ?></h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="text-sm text-gray-500"><?php echo e(__('Revenus moyens')); ?></div>
                                        <div class="text-lg font-medium text-green-600">
                                            <?php echo e(number_format($nextMonthPredictions['average_income'], 2)); ?> €
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500"><?php echo e(__('Dépenses moyennes')); ?></div>
                                        <div class="text-lg font-medium text-red-600">
                                            <?php echo e(number_format($nextMonthPredictions['average_expenses'], 2)); ?> €
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 border-t">
                                <div class="text-sm font-medium text-gray-500"><?php echo e(__('Balance prévue')); ?></div>
                                <div class="text-xl font-semibold <?php echo e($nextMonthPredictions['predicted_balance'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php echo e(number_format($nextMonthPredictions['predicted_balance'], 2)); ?> €
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données pour les graphiques
        const balanceData = <?php echo json_encode($balanceHistory, 15, 512) ?>;
        const categoryData = <?php echo json_encode($topExpenseCategories, 15, 512) ?>;

        // Graphique d'évolution des revenus/dépenses
        const balanceCtx = document.getElementById('balanceChart').getContext('2d');
        new Chart(balanceCtx, {
            type: 'line',
            data: {
                labels: balanceData.map(item => {
                    const [year, month] = item.month.split('-');
                    return new Date(year, month - 1).toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' });
                }),
                datasets: [{
                    label: 'Revenus',
                    data: balanceData.map(item => item.income),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.1
                }, {
                    label: 'Dépenses',
                    data: balanceData.map(item => item.expenses),
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
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
                    }
                }
            }
        });

        // Graphique en camembert des catégories
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.category.name),
                datasets: [{
                    data: categoryData.map(item => item.total),
                    backgroundColor: [
                        '#ef4444',
                        '#f97316',
                        '#eab308',
                        '#84cc16',
                        '#22c55e',
                        '#06b6d4',
                        '#3b82f6',
                        '#8b5cf6',
                        '#ec4899',
                        '#f43f5e'
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
                        position: 'bottom',
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/reports/index.blade.php ENDPATH**/ ?>