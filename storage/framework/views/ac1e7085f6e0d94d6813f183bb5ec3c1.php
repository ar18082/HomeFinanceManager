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
                <?php echo e(__('Détails de la transaction récurrente')); ?>

            </h2>
            <div class="flex space-x-3">
                <form action="<?php echo e(route('recurring-transactions.generate', $recurringTransaction)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <?php echo e(__('Générer maintenant')); ?>

                    </button>
                </form>
                <a href="<?php echo e(route('recurring-transactions.edit', $recurringTransaction)); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <?php echo e(__('Modifier')); ?>

                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Informations principales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Informations principales')); ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Description')); ?></dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($recurringTransaction->description); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Type')); ?></dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php if($recurringTransaction->type === 'income'): ?> bg-green-100 text-green-800
                                            <?php elseif($recurringTransaction->type === 'expense'): ?> bg-red-100 text-red-800
                                            <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                                            <?php echo e(__($recurringTransaction->type)); ?>

                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Montant')); ?></dt>
                                    <dd class="mt-1 text-sm font-semibold 
                                        <?php if($recurringTransaction->type === 'income'): ?> text-green-600
                                        <?php elseif($recurringTransaction->type === 'expense'): ?> text-red-600
                                        <?php else: ?> text-blue-600 <?php endif; ?>">
                                        <?php echo e($recurringTransaction->currency->symbol); ?> <?php echo e(number_format($recurringTransaction->amount, 2)); ?>

                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Compte')); ?></dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($recurringTransaction->account->name); ?></dd>
                                </div>
                                <?php if($recurringTransaction->type === 'transfer'): ?>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Compte de destination')); ?></dt>
                                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($recurringTransaction->destinationAccount->name); ?></dd>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Catégorie')); ?></dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($recurringTransaction->category?->name ?? __('Non catégorisé')); ?></dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Fréquence')); ?></dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php if($recurringTransaction->interval > 1): ?>
                                            <?php echo e(__('Tous les')); ?> <?php echo e($recurringTransaction->interval); ?>

                                            <?php if($recurringTransaction->frequency === 'daily'): ?>
                                                <?php echo e(__('jours')); ?>

                                            <?php elseif($recurringTransaction->frequency === 'weekly'): ?>
                                                <?php echo e(__('semaines')); ?>

                                            <?php elseif($recurringTransaction->frequency === 'monthly'): ?>
                                                <?php echo e(__('mois')); ?>

                                            <?php else: ?>
                                                <?php echo e(__('ans')); ?>

                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if($recurringTransaction->frequency === 'daily'): ?>
                                                <?php echo e(__('Quotidienne')); ?>

                                            <?php elseif($recurringTransaction->frequency === 'weekly'): ?>
                                                <?php echo e(__('Hebdomadaire')); ?>

                                            <?php elseif($recurringTransaction->frequency === 'monthly'): ?>
                                                <?php echo e(__('Mensuelle')); ?>

                                            <?php else: ?>
                                                <?php echo e(__('Annuelle')); ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Date de début')); ?></dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($recurringTransaction->start_date->format('d/m/Y')); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Date de fin')); ?></dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($recurringTransaction->end_date?->format('d/m/Y') ?? __('Aucune')); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Prochaine génération')); ?></dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($recurringTransaction->getNextDueDate()?->format('d/m/Y') ?? __('Terminée')); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Nombre d\'occurrences')); ?></dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?php if($recurringTransaction->times_to_run): ?>
                                            <?php echo e($recurringTransaction->times_run); ?> / <?php echo e($recurringTransaction->times_to_run); ?>

                                        <?php else: ?>
                                            <?php echo e($recurringTransaction->times_run); ?> (<?php echo e(__('illimité')); ?>)
                                        <?php endif; ?>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Statut')); ?></dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($recurringTransaction->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                            <?php echo e($recurringTransaction->active ? __('Active') : __('Inactive')); ?>

                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <?php if($recurringTransaction->notes): ?>
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500"><?php echo e(__('Notes')); ?></h4>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($recurringTransaction->notes); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Dernières transactions générées -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Dernières transactions générées')); ?></h3>
                    <?php if($transactions->isEmpty()): ?>
                        <p class="text-sm text-gray-500"><?php echo e(__('Aucune transaction n\'a encore été générée.')); ?></p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Date')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Description')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Montant')); ?></th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($transaction->date->format('d/m/Y')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($transaction->description); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm 
                                                <?php if($transaction->type === 'income'): ?> text-green-600
                                                <?php elseif($transaction->type === 'expense'): ?> text-red-600
                                                <?php else: ?> text-blue-600 <?php endif; ?>">
                                                <?php echo e($transaction->currency->symbol); ?> <?php echo e(number_format($transaction->amount, 2)); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="<?php echo e(route('transactions.show', $transaction)); ?>" class="text-indigo-600 hover:text-indigo-900">
                                                    <?php echo e(__('Voir')); ?>

                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bouton de suppression -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-red-600 mb-4"><?php echo e(__('Zone de danger')); ?></h3>
                    <p class="text-sm text-gray-500 mb-4">
                        <?php echo e(__('La suppression de cette transaction récurrente est définitive et ne peut pas être annulée. Les transactions déjà générées ne seront pas supprimées.')); ?>

                    </p>
                    <form action="<?php echo e(route('recurring-transactions.destroy', $recurringTransaction)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="return confirm('<?php echo e(__('Êtes-vous sûr de vouloir supprimer cette transaction récurrente ?')); ?>')">
                            <?php echo e(__('Supprimer cette transaction récurrente')); ?>

                        </button>
                    </form>
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
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/recurring-transactions/show.blade.php ENDPATH**/ ?>