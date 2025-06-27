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
                <?php echo e(__('Objectifs d\'épargne')); ?>

            </h2>
            <a href="<?php echo e(route('savings-goals.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <?php echo e(__('Nouvel objectif')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e(__('Gestion des objectifs d\'épargne')); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo e(__('Les objectifs d\'épargne vous aident à planifier et suivre vos économies pour des projets spécifiques. Définissez un montant cible, une date limite et suivez votre progression vers vos objectifs financiers.')); ?>

                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2"><?php echo e(__('Création d\'objectifs')); ?></h4>
                            <p class="text-sm text-blue-600"><?php echo e(__('Définissez un montant à atteindre et une date limite pour vos projets d\'épargne.')); ?></p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2"><?php echo e(__('Suivi de progression')); ?></h4>
                            <p class="text-sm text-green-600"><?php echo e(__('Visualisez votre progression et recevez des suggestions pour atteindre vos objectifs.')); ?></p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-2"><?php echo e(__('Célébration des succès')); ?></h4>
                            <p class="text-sm text-purple-600"><?php echo e(__('Recevez des notifications lorsque vous atteignez vos objectifs d\'épargne.')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Objectifs actifs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Objectifs en cours')); ?></h3>
                    <?php if($activeGoals->isEmpty()): ?>
                        <p class="text-center text-gray-500 py-4"><?php echo e(__('Aucun objectif d\'épargne actif.')); ?></p>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $activeGoals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border rounded-lg p-4 <?php echo e($goal->color ? 'border-l-4 border-l-['.$goal->color.']' : ''); ?>">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-medium text-gray-900"><?php echo e($goal->name); ?></h4>
                                            <p class="text-sm text-gray-500"><?php echo e($goal->account->name); ?></p>
                                        </div>
                                        <?php if($goal->icon): ?>
                                            <span class="text-2xl"><?php echo e($goal->icon); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="space-y-2">
                                        <div>
                                            <div class="flex justify-between text-sm mb-1">
                                                <span class="text-gray-600"><?php echo e(__('Progression')); ?></span>
                                                <span class="font-medium"><?php echo e(number_format($goal->getProgressPercentage(), 1)); ?>%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="h-2 rounded-full bg-blue-600" style="width: <?php echo e($goal->getProgressPercentage()); ?>%"></div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <span class="text-gray-600"><?php echo e(__('Actuel')); ?></span>
                                                <div class="font-medium"><?php echo e($goal->currency->symbol); ?> <?php echo e(number_format($goal->current_amount, 2)); ?></div>
                                            </div>
                                            <div>
                                                <span class="text-gray-600"><?php echo e(__('Objectif')); ?></span>
                                                <div class="font-medium"><?php echo e($goal->currency->symbol); ?> <?php echo e(number_format($goal->target_amount, 2)); ?></div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <span class="text-gray-600"><?php echo e(__('Jours restants')); ?></span>
                                                <div class="font-medium"><?php echo e($goal->getDaysRemaining()); ?></div>
                                            </div>
                                            <div>
                                                <span class="text-gray-600"><?php echo e(__('Mensuel suggéré')); ?></span>
                                                <div class="font-medium"><?php echo e($goal->currency->symbol); ?> <?php echo e(number_format($goal->getMonthlyTargetAmount(), 2)); ?></div>
                                            </div>
                                        </div>

                                        <div class="pt-4 flex justify-end space-x-2">
                                            <a href="<?php echo e(route('savings-goals.show', $goal)); ?>" class="text-blue-600 hover:text-blue-800">
                                                <?php echo e(__('Détails')); ?>

                                            </a>
                                            <a href="<?php echo e(route('savings-goals.edit', $goal)); ?>" class="text-gray-600 hover:text-gray-800">
                                                <?php echo e(__('Modifier')); ?>

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Objectifs complétés -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Objectifs atteints')); ?></h3>
                    <?php if($completedGoals->isEmpty()): ?>
                        <p class="text-center text-gray-500 py-4"><?php echo e(__('Aucun objectif d\'épargne complété.')); ?></p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Nom')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Montant')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Compte')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Date de complétion')); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $completedGoals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <?php if($goal->icon): ?>
                                                        <span class="text-xl mr-2"><?php echo e($goal->icon); ?></span>
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900"><?php echo e($goal->name); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo e($goal->currency->symbol); ?> <?php echo e(number_format($goal->target_amount, 2)); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo e($goal->account->name); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($goal->completed_at->format('d/m/Y')); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/savings-goals/index.blade.php ENDPATH**/ ?>