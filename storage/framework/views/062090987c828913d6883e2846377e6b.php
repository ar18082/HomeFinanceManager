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
                <?php echo e(__('Gestion des crédits')); ?>

            </h2>
            <a href="<?php echo e(route('credits.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <?php echo e(__('Nouveau crédit')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e(__('Gestion des crédits')); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo e(__('Suivez tous vos crédits et emprunts en un seul endroit. Visualisez vos mensualités, le solde restant et la progression de vos remboursements.')); ?>

                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2"><?php echo e(__('Crédits actifs')); ?></h4>
                            <p class="text-sm text-blue-600"><?php echo e(__('Suivez vos crédits en cours avec les mensualités et échéances.')); ?></p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2"><?php echo e(__('Progression')); ?></h4>
                            <p class="text-sm text-green-600"><?php echo e(__('Visualisez votre progression de remboursement pour chaque crédit.')); ?></p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-2"><?php echo e(__('Calculs automatiques')); ?></h4>
                            <p class="text-sm text-purple-600"><?php echo e(__('Calculs automatiques des intérêts, mensualités et solde restant.')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des crédits -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php if($credits->isEmpty()): ?>
                        <p class="text-center text-gray-500"><?php echo e(__('Aucun crédit trouvé.')); ?></p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Nom')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Montant')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Mensualité')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Solde restant')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Progression')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Statut')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $credits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($credit->name); ?></div>
                                                <div class="text-sm text-gray-500"><?php echo e(Str::limit($credit->description, 50)); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->amount, 2)); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->monthly_payment, 2)); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->remaining_balance, 2)); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e($credit->getProgressPercentage()); ?>%"></div>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1"><?php echo e(number_format($credit->getProgressPercentage(), 1)); ?>%</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    <?php if($credit->status === 'active'): ?> bg-green-100 text-green-800
                                                    <?php elseif($credit->status === 'completed'): ?> bg-blue-100 text-blue-800
                                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                                    <?php echo e(__($credit->status)); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="<?php echo e(route('credits.show', $credit)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    <?php echo e(__('Voir')); ?>

                                                </a>
                                                <a href="<?php echo e(route('credits.edit', $credit)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    <?php echo e(__('Modifier')); ?>

                                                </a>
                                                <form action="<?php echo e(route('credits.destroy', $credit)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('<?php echo e(__('Êtes-vous sûr de vouloir supprimer ce crédit ?')); ?>')">
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
                            <?php echo e($credits->links()); ?>

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
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/credits/index.blade.php ENDPATH**/ ?>