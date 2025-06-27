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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Analyse par catégorie')); ?>

            </h2>
            <form method="GET" action="<?php echo e(route('reports.by-category')); ?>" class="flex space-x-4">
                <div>
                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'start_date','value' => __('Date de début')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'start_date','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Date de début'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'start_date','name' => 'start_date','type' => 'date','class' => 'mt-1 block w-full','value' => $startDate->format('Y-m-d'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'start_date','name' => 'start_date','type' => 'date','class' => 'mt-1 block w-full','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($startDate->format('Y-m-d')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                </div>
                <div>
                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'end_date','value' => __('Date de fin')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'end_date','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Date de fin'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'end_date','name' => 'end_date','type' => 'date','class' => 'mt-1 block w-full','value' => $endDate->format('Y-m-d'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'end_date','name' => 'end_date','type' => 'date','class' => 'mt-1 block w-full','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($endDate->format('Y-m-d')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                </div>
                <div class="flex items-end">
                    <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(__('Filtrer')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                </div>
            </form>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Graphique de répartition globale -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Répartition globale par catégorie')); ?></h3>
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
                    <h3 class="text-lg font-medium text-gray-900 mb-6"><?php echo e(__('Statistiques par catégorie')); ?></h3>
                    
                    <?php if($categoryStats->isEmpty()): ?>
                        <p class="text-gray-500 text-sm"><?php echo e(__('Aucune transaction catégorisée sur la période.')); ?></p>
                    <?php else: ?>
                        <div class="space-y-8">
                            <?php $__currentLoopData = $categoryStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border-b pb-6 last:border-0 last:pb-0">
                                    <h4 class="text-base font-medium text-gray-900 mb-4"><?php echo e($categoryName); ?></h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Revenus -->
                                        <?php if($stats->where('type', 'income')->isNotEmpty()): ?>
                                            <div class="bg-green-50 rounded-lg p-4">
                                                <div class="text-sm font-medium text-green-800 mb-2"><?php echo e(__('Revenus')); ?></div>
                                                <?php
                                                    $incomeStats = $stats->where('type', 'income')->first();
                                                ?>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <div class="text-sm text-green-600"><?php echo e(__('Total')); ?></div>
                                                        <div class="text-lg font-medium text-green-900">
                                                            <?php echo e(number_format($incomeStats->total, 2)); ?> €
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-green-600"><?php echo e(__('Moyenne')); ?></div>
                                                        <div class="text-lg font-medium text-green-900">
                                                            <?php echo e(number_format($incomeStats->average, 2)); ?> €
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-sm text-green-600">
                                                    <?php echo e(trans_choice('transactions', $incomeStats->count, ['count' => $incomeStats->count])); ?>

                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Dépenses -->
                                        <?php if($stats->where('type', 'expense')->isNotEmpty()): ?>
                                            <div class="bg-red-50 rounded-lg p-4">
                                                <div class="text-sm font-medium text-red-800 mb-2"><?php echo e(__('Dépenses')); ?></div>
                                                <?php
                                                    $expenseStats = $stats->where('type', 'expense')->first();
                                                ?>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <div class="text-sm text-red-600"><?php echo e(__('Total')); ?></div>
                                                        <div class="text-lg font-medium text-red-900">
                                                            <?php echo e(number_format($expenseStats->total, 2)); ?> €
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-red-600"><?php echo e(__('Moyenne')); ?></div>
                                                        <div class="text-lg font-medium text-red-900">
                                                            <?php echo e(number_format($expenseStats->average, 2)); ?> €
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-sm text-red-600">
                                                    <?php echo e(trans_choice('transactions', $expenseStats->count, ['count' => $expenseStats->count])); ?>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tendances -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6"><?php echo e(__('Tendances par catégorie')); ?></h3>
                    
                    <?php if($categoryTrends->isEmpty()): ?>
                        <p class="text-gray-500 text-sm"><?php echo e(__('Aucune donnée disponible pour afficher les tendances.')); ?></p>
                    <?php else: ?>
                        <div class="space-y-8">
                            <?php $__currentLoopData = $categoryTrends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $trends): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border-b pb-6 last:border-0 last:pb-0">
                                    <h4 class="text-base font-medium text-gray-900 mb-4"><?php echo e($categoryName); ?></h4>
                                    <div class="h-64">
                                        <canvas id="trendChart<?php echo e(Str::slug($categoryName)); ?>"></canvas>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données pour les graphiques
        const categoryStats = <?php echo json_encode($categoryStats, 15, 512) ?>;
        const categoryTrends = <?php echo json_encode($categoryTrends, 15, 512) ?>;

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
                        text: '<?php echo e(__("Répartition des dépenses")); ?>'
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
                        text: '<?php echo e(__("Répartition des revenus")); ?>'
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
                            label: '<?php echo e(__("Revenus")); ?>',
                            data: data.income,
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: '<?php echo e(__("Dépenses")); ?>',
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/reports/by-category.blade.php ENDPATH**/ ?>