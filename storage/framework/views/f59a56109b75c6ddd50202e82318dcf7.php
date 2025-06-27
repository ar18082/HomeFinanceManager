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
                <?php echo e(__('Budgets')); ?>

            </h2>
            <a href="<?php echo e(route('budgets.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <?php echo e(__('Nouveau budget')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e(__('Gestion des budgets')); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo e(__('Les budgets vous permettent de suivre et contrôler vos dépenses par catégorie. Définissez des limites mensuelles, annuelles ou personnalisées pour chaque catégorie de dépenses et suivez votre progression en temps réel.')); ?>

                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2"><?php echo e(__('Création de budget')); ?></h4>
                            <p class="text-sm text-blue-600"><?php echo e(__('Définissez un montant maximum pour une catégorie spécifique sur une période donnée.')); ?></p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2"><?php echo e(__('Suivi des dépenses')); ?></h4>
                            <p class="text-sm text-green-600"><?php echo e(__('Visualisez la progression de vos dépenses par rapport aux limites fixées.')); ?></p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-2"><?php echo e(__('Alertes et notifications')); ?></h4>
                            <p class="text-sm text-purple-600"><?php echo e(__('Recevez des alertes visuelles lorsque vous approchez ou dépassez vos limites budgétaires.')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des budgets -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php if($budgets->isEmpty()): ?>
                        <p class="text-center text-gray-500"><?php echo e(__('Aucun budget trouvé.')); ?></p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <?php echo e($budget->name); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($budget->category->name); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($budget->currency->symbol); ?> <?php echo e(number_format($budget->amount, 2)); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php if($budget->period === 'monthly'): ?>
                                                    <?php echo e(__('Mensuel')); ?>

                                                <?php elseif($budget->period === 'yearly'): ?>
                                                    <?php echo e(__('Annuel')); ?>

                                                <?php else: ?>
                                                    <?php echo e(__('Personnalisé')); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php
                                                    $expenses = Auth::user()
                                                        ->transactions()
                                                        ->where('category_id', $budget->category_id)
                                                        ->where('type', 'expense')
                                                        ->whereBetween('date', [$budget->start_date, $budget->end_date ?? now()])
                                                        ->sum('amount');
                                                    $percentage = $budget->amount > 0 ? ($expenses / $budget->amount) * 100 : 0;
                                                ?>
                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                    <div class="h-2.5 rounded-full <?php echo e($percentage > 100 ? 'bg-red-600' : ($percentage > 80 ? 'bg-yellow-400' : 'bg-green-600')); ?>"
                                                         style="width: <?php echo e(min($percentage, 100)); ?>%"></div>
                                                </div>
                                                <span class="text-xs <?php echo e($percentage > 100 ? 'text-red-600' : ($percentage > 80 ? 'text-yellow-600' : 'text-green-600')); ?>">
                                                    <?php echo e(number_format($percentage, 1)); ?>%
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($budget->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                    <?php echo e($budget->active ? __('Actif') : __('Inactif')); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="<?php echo e(route('budgets.show', $budget)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    <?php echo e(__('Voir')); ?>

                                                </a>
                                                <a href="<?php echo e(route('budgets.edit', $budget)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    <?php echo e(__('Modifier')); ?>

                                                </a>
                                                <form action="<?php echo e(route('budgets.destroy', $budget)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('<?php echo e(__('Êtes-vous sûr de vouloir supprimer ce budget ?')); ?>')">
                                                        <?php echo e(__('Supprimer')); ?>

                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <?php echo e($budgets->links()); ?>

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
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/budgets/index.blade.php ENDPATH**/ ?>