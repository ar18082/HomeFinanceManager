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
                <?php echo e($credit->name); ?>

            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('credits.edit', $credit)); ?>" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    <?php echo e(__('Modifier')); ?>

                </a>
                <?php if($credit->status === 'active'): ?>
                    <form action="<?php echo e(route('credits.mark-completed', $credit)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <?php echo e(__('Marquer comme terminé')); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informations générales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Informations du crédit')); ?></h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-1"><?php echo e(__('Montant emprunté')); ?></h4>
                            <p class="text-2xl font-bold text-blue-900"><?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->amount, 2)); ?></p>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-1"><?php echo e(__('Mensualité')); ?></h4>
                            <p class="text-2xl font-bold text-green-900"><?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->monthly_payment, 2)); ?></p>
                        </div>
                        
                        <div class="bg-red-50 rounded-lg p-4">
                            <h4 class="font-medium text-red-800 mb-1"><?php echo e(__('Solde restant')); ?></h4>
                            <p class="text-2xl font-bold text-red-900"><?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->remaining_balance, 2)); ?></p>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-1"><?php echo e(__('Taux d\'intérêt')); ?></h4>
                            <p class="text-2xl font-bold text-purple-900"><?php echo e($credit->interest_rate); ?>%</p>
                        </div>
                    </div>

                    <?php if($credit->description): ?>
                        <div class="mt-4">
                            <h4 class="font-medium text-gray-900 mb-2"><?php echo e(__('Description')); ?></h4>
                            <p class="text-gray-600"><?php echo e($credit->description); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Progression et détails -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Progression -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Progression du remboursement')); ?></h3>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span><?php echo e(__('Progression')); ?></span>
                                <span><?php echo e(number_format($credit->getProgressPercentage(), 1)); ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-blue-600 h-4 rounded-full transition-all duration-300" style="width: <?php echo e($credit->getProgressPercentage()); ?>%"></div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600"><?php echo e(__('Montant remboursé')); ?></span>
                                <span class="font-semibold"><?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->total_amount - $credit->remaining_balance, 2)); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600"><?php echo e(__('Montant total')); ?></span>
                                <span class="font-semibold"><?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->total_amount, 2)); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600"><?php echo e(__('Intérêts totaux')); ?></span>
                                <span class="font-semibold text-red-600"><?php echo e($credit->currency->symbol); ?> <?php echo e(number_format($credit->total_interest, 2)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations temporelles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Informations temporelles')); ?></h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><?php echo e(__('Date de début')); ?></span>
                                <span class="font-semibold"><?php echo e($credit->start_date->format('d/m/Y')); ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><?php echo e(__('Date de fin')); ?></span>
                                <span class="font-semibold"><?php echo e($credit->end_date->format('d/m/Y')); ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><?php echo e(__('Durée totale')); ?></span>
                                <span class="font-semibold"><?php echo e($credit->duration_months); ?> <?php echo e(__('mois')); ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><?php echo e(__('Mois restants')); ?></span>
                                <span class="font-semibold"><?php echo e($credit->getRemainingMonths()); ?> <?php echo e(__('mois')); ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><?php echo e(__('Statut')); ?></span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php if($credit->status === 'active'): ?> bg-green-100 text-green-800
                                    <?php elseif($credit->status === 'completed'): ?> bg-blue-100 text-blue-800
                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(__($credit->status)); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compte associé -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Compte associé')); ?></h3>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900"><?php echo e($credit->account->name); ?></h4>
                            <p class="text-gray-600"><?php echo e($credit->account->description); ?></p>
                        </div>
                        <a href="<?php echo e(route('accounts.show', $credit->account)); ?>" class="text-blue-600 hover:text-blue-900">
                            <?php echo e(__('Voir le compte')); ?>

                        </a>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><?php echo e(__('Actions')); ?></h3>
                    
                    <div class="flex space-x-4">
                        <a href="<?php echo e(route('credits.edit', $credit)); ?>" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            <?php echo e(__('Modifier le crédit')); ?>

                        </a>
                        
                        <?php if($credit->status === 'active'): ?>
                            <form action="<?php echo e(route('credits.mark-completed', $credit)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    <?php echo e(__('Marquer comme terminé')); ?>

                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <form action="<?php echo e(route('credits.destroy', $credit)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('<?php echo e(__('Êtes-vous sûr de vouloir supprimer ce crédit ?')); ?>')">
                                <?php echo e(__('Supprimer')); ?>

                            </button>
                        </form>
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
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/credits/show.blade.php ENDPATH**/ ?>