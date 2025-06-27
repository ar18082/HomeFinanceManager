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
            <?php echo e(__('Prévisions financières')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Impact des transactions récurrentes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6"><?php echo e(__('Impact mensuel des transactions récurrentes')); ?></h3>
                    
                    <?php if($recurringImpact['by_frequency']->isEmpty()): ?>
                        <p class="text-gray-500 text-sm"><?php echo e(__('Aucune transaction récurrente active.')); ?></p>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-green-800 mb-2"><?php echo e(__('Revenus mensuels récurrents')); ?></div>
                                <div class="text-2xl font-semibold text-green-600">
                                    <?php echo e(number_format($recurringImpact['total_monthly_income'], 2)); ?> €
                                </div>
                            </div>
                            <div class="bg-red-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-red-800 mb-2"><?php echo e(__('Dépenses mensuelles récurrentes')); ?></div>
                                <div class="text-2xl font-semibold text-red-600">
                                    <?php echo e(number_format($recurringImpact['total_monthly_expenses'], 2)); ?> €
                                </div>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <?php $__currentLoopData = $recurringImpact['by_frequency']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $frequency => $transactions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border-b pb-6 last:border-0 last:pb-0">
                                    <h4 class="text-base font-medium text-gray-900 mb-4">
                                        <?php echo e(__('Fréquence')); ?> : <?php echo e(__($frequency)); ?>

                                    </h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        <?php echo e(__('Description')); ?>

                                                    </th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        <?php echo e(__('Catégorie')); ?>

                                                    </th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        <?php echo e(__('Compte')); ?>

                                                    </th>
                                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        <?php echo e(__('Montant initial')); ?>

                                                    </th>
                                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        <?php echo e(__('Impact mensuel')); ?>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                            <?php echo e($transaction['description']); ?>

                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                            <?php echo e($transaction['category'] ?? __('Sans catégorie')); ?>

                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                            <?php echo e($transaction['account']); ?>

                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-right <?php echo e($transaction['type'] === 'income' ? 'text-green-600' : 'text-red-600'); ?>">
                                                            <?php echo e($transaction['type'] === 'income' ? '+' : '-'); ?><?php echo e(number_format($transaction['original_amount'], 2)); ?> €
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-right <?php echo e($transaction['type'] === 'income' ? 'text-green-600' : 'text-red-600'); ?>">
                                                            <?php echo e($transaction['type'] === 'income' ? '+' : '-'); ?><?php echo e(number_format($transaction['monthly_amount'], 2)); ?> €
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Prévisions sur 3 mois -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6"><?php echo e(__('Prévisions sur les 3 prochains mois')); ?></h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $predictions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prediction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white rounded-lg border p-6">
                                <div class="text-lg font-medium text-gray-900 mb-4"><?php echo e(\Carbon\Carbon::createFromFormat('Y-m', $prediction['month'])->format('F Y')); ?></div>
                                
                                <!-- Transactions récurrentes -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2"><?php echo e(__('Transactions récurrentes')); ?></h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500"><?php echo e(__('Revenus')); ?></div>
                                            <div class="text-base font-medium text-green-600">
                                                <?php echo e(number_format($prediction['recurring']['income'], 2)); ?> €
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500"><?php echo e(__('Dépenses')); ?></div>
                                            <div class="text-base font-medium text-red-600">
                                                <?php echo e(number_format($prediction['recurring']['expenses'], 2)); ?> €
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estimations basées sur l'historique -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2"><?php echo e(__('Estimations (moyenne)')); ?></h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500"><?php echo e(__('Revenus')); ?></div>
                                            <div class="text-base font-medium text-green-600">
                                                <?php echo e(number_format($prediction['estimated']['income'], 2)); ?> €
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500"><?php echo e(__('Dépenses')); ?></div>
                                            <div class="text-base font-medium text-red-600">
                                                <?php echo e(number_format($prediction['estimated']['expenses'], 2)); ?> €
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transactions prévues -->
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2"><?php echo e(__('Transactions prévues')); ?></h4>
                                    <div class="space-y-2 max-h-48 overflow-y-auto">
                                        <?php $__currentLoopData = $prediction['transactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex justify-between items-center text-sm">
                                                <div class="text-gray-600"><?php echo e($transaction['description']); ?></div>
                                                <div class="<?php echo e($transaction['type'] === 'income' ? 'text-green-600' : 'text-red-600'); ?>">
                                                    <?php echo e($transaction['type'] === 'income' ? '+' : '-'); ?><?php echo e(number_format($transaction['amount'], 2)); ?> €
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/reports/predictions.blade.php ENDPATH**/ ?>