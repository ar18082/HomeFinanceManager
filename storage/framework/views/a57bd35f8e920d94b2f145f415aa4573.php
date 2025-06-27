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
                <?php echo e(__('Détails de la transaction')); ?>

            </h2>
            <div class="flex space-x-4">
                <a href="<?php echo e(route('transactions.edit', $transaction)); ?>" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    <?php echo e(__('Modifier')); ?>

                </a>
                <form action="<?php echo e(route('transactions.destroy', $transaction)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                        onclick="return confirm('<?php echo e(__('Êtes-vous sûr de vouloir supprimer cette transaction ?')); ?>')">
                        <?php echo e(__('Supprimer')); ?>

                    </button>
                </form>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations principales -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900"><?php echo e(__('Informations principales')); ?></h3>
                                <div class="mt-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600"><?php echo e(__('Type')); ?></span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php if($transaction->type === 'income'): ?> bg-green-100 text-green-800
                                            <?php elseif($transaction->type === 'expense'): ?> bg-red-100 text-red-800
                                            <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                                            <?php echo e(__($transaction->type)); ?>

                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600"><?php echo e(__('Montant')); ?></span>
                                        <span class="font-medium <?php if($transaction->type === 'income'): ?> text-green-600 <?php elseif($transaction->type === 'expense'): ?> text-red-600 <?php else: ?> text-blue-600 <?php endif; ?>">
                                            <?php echo e($transaction->currency->symbol); ?> <?php echo e(number_format($transaction->amount, 2)); ?>

                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600"><?php echo e(__('Date')); ?></span>
                                        <span><?php echo e($transaction->date->format('d/m/Y')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900"><?php echo e(__('Compte')); ?></h3>
                                <div class="mt-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600"><?php echo e(__('Nom du compte')); ?></span>
                                        <span><?php echo e($transaction->account->name); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600"><?php echo e(__('Solde actuel')); ?></span>
                                        <span><?php echo e($transaction->account->currency->symbol); ?> <?php echo e(number_format($transaction->account->current_balance, 2)); ?></span>
                                    </div>
                                </div>
                            </div>

                            <?php if($transaction->category): ?>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900"><?php echo e(__('Catégorie')); ?></h3>
                                <div class="mt-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600"><?php echo e(__('Nom')); ?></span>
                                        <span><?php echo e($transaction->category->name); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Détails supplémentaires -->
                        <div class="space-y-4">
                            <?php if($transaction->description): ?>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900"><?php echo e(__('Description')); ?></h3>
                                <p class="mt-2 text-gray-600"><?php echo e($transaction->description); ?></p>
                            </div>
                            <?php endif; ?>

                            <?php if($transaction->tags->isNotEmpty()): ?>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900"><?php echo e(__('Tags')); ?></h3>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $transaction->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <?php echo e($tag->name); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($transaction->type === 'transfer' && $transaction->transferTransaction): ?>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900"><?php echo e(__('Détails du transfert')); ?></h3>
                                <div class="mt-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600"><?php echo e(__('Compte de destination')); ?></span>
                                        <span><?php echo e($transaction->transferTransaction->account->name); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <a href="<?php echo e(route('transactions.index')); ?>" class="text-indigo-600 hover:text-indigo-900">
                            <?php echo e(__('Retour à la liste')); ?> →
                        </a>
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
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/transactions/show.blade.php ENDPATH**/ ?>