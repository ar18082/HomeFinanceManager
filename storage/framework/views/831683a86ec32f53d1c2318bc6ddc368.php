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
                <?php echo e(__('Transactions')); ?>

            </h2>
            <a href="<?php echo e(route('transactions.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <?php echo e(__('Nouvelle transaction')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e(__('Gestion des transactions')); ?></h3>
                    <p class="text-gray-600 mb-4">
                        <?php echo e(__('Enregistrez et gérez toutes vos transactions financières au même endroit. Suivez vos revenus, dépenses et transferts entre comptes pour une meilleure gestion de vos finances personnelles.')); ?>

                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2"><?php echo e(__('Revenus')); ?></h4>
                            <p class="text-sm text-green-600"><?php echo e(__('Enregistrez vos salaires, revenus locatifs, dividendes et autres entrées d\'argent.')); ?></p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4">
                            <h4 class="font-medium text-red-800 mb-2"><?php echo e(__('Dépenses')); ?></h4>
                            <p class="text-sm text-red-600"><?php echo e(__('Suivez vos achats, factures et autres dépenses en les classant par catégories.')); ?></p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2"><?php echo e(__('Transferts')); ?></h4>
                            <p class="text-sm text-blue-600"><?php echo e(__('Gérez les mouvements d\'argent entre vos différents comptes bancaires.')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des transactions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php if($transactions->isEmpty()): ?>
                        <p class="text-center text-gray-500"><?php echo e(__('Aucune transaction trouvée.')); ?></p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compte</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($transaction->date->format('d/m/Y')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    <?php if($transaction->type === 'income'): ?> bg-green-100 text-green-800
                                                    <?php elseif($transaction->type === 'expense'): ?> bg-red-100 text-red-800
                                                    <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                                                    <?php echo e(__($transaction->type)); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm 
                                                <?php if($transaction->type === 'income'): ?> text-green-600
                                                <?php elseif($transaction->type === 'expense'): ?> text-red-600
                                                <?php else: ?> text-blue-600 <?php endif; ?>">
                                                <?php echo e($transaction->currency->symbol); ?> <?php echo e(number_format($transaction->amount, 2)); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($transaction->account->name); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($transaction->category?->name ?? '-'); ?>

                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <?php echo e(Str::limit($transaction->description, 50)); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="<?php echo e(route('transactions.show', $transaction)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    <?php echo e(__('Voir')); ?>

                                                </a>
                                                <a href="<?php echo e(route('transactions.edit', $transaction)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    <?php echo e(__('Modifier')); ?>

                                                </a>
                                                <form action="<?php echo e(route('transactions.destroy', $transaction)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('<?php echo e(__('Êtes-vous sûr de vouloir supprimer cette transaction ?')); ?>')">
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
                            <?php echo e($transactions->links()); ?>

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
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/transactions/index.blade.php ENDPATH**/ ?>