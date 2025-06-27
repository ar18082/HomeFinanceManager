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
                <?php echo e(__('Compteurs d\'énergie')); ?>

            </h2>
            <a href="<?php echo e(route('energy-meters.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ajouter un compteur
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($meters->isEmpty()): ?>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <p class="text-lg mb-4">Aucun compteur d'énergie configuré</p>
                        <a href="<?php echo e(route('energy-meters.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Créer votre premier compteur
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <?php $__currentLoopData = $meters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $typeMeters): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <?php
                                    $typeLabels = [
                                        'electricity' => 'Électricité',
                                        'gas' => 'Gaz',
                                        'water' => 'Eau'
                                    ];
                                    $typeIcons = [
                                        'electricity' => '⚡',
                                        'gas' => '🔥',
                                        'water' => '💧'
                                    ];
                                ?>
                                <span class="mr-2"><?php echo e($typeIcons[$type]); ?></span>
                                <?php echo e($typeLabels[$type]); ?>

                                <span class="ml-2 text-sm text-gray-500">(<?php echo e($typeMeters->count()); ?> compteur<?php echo e($typeMeters->count() > 1 ? 's' : ''); ?>)</span>
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <?php $__currentLoopData = $typeMeters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo e($meter->name); ?></h4>
                                                <?php if($meter->location): ?>
                                                    <p class="text-sm text-gray-600"><?php echo e($meter->location); ?></p>
                                                <?php endif; ?>
                                                <?php if($meter->meter_number): ?>
                                                    <p class="text-xs text-gray-500">N° <?php echo e($meter->meter_number); ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <?php if($meter->active): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Actif
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Inactif
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="space-y-2 mb-4">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Dernière lecture:</span>
                                                <span class="font-medium">
                                                    <?php if($meter->last_reading_date): ?>
                                                        <?php echo e(number_format($meter->current_reading, 3)); ?> <?php echo e($meter->unit); ?>

                                                        <span class="text-gray-500">(<?php echo e($meter->last_reading_date->format('d/m/Y')); ?>)</span>
                                                    <?php else: ?>
                                                        <span class="text-gray-500">Aucune lecture</span>
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                            
                                            <?php if($meter->latestReading): ?>
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-gray-600">Dernier mois:</span>
                                                    <span class="font-medium">
                                                        <?php echo e(number_format($meter->last_month_consumption, 3)); ?> <?php echo e($meter->unit); ?>

                                                        <span class="text-gray-500">(<?php echo e(number_format($meter->last_month_cost, 2)); ?> €)</span>
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <div class="flex space-x-2">
                                                <a href="<?php echo e(route('energy-meters.show', $meter)); ?>" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Voir détails
                                                </a>
                                                <a href="<?php echo e(route('energy-readings.create')); ?>?meter=<?php echo e($meter->id); ?>" 
                                                   class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                    Ajouter relevé
                                                </a>
                                            </div>
                                            <div class="flex space-x-1">
                                                <a href="<?php echo e(route('energy-meters.edit', $meter)); ?>" 
                                                   class="text-gray-600 hover:text-gray-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="<?php echo e(route('energy-meters.destroy', $meter)); ?>" method="POST" class="inline" 
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce compteur ?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
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
<?php endif; ?> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/energy-meters/index.blade.php ENDPATH**/ ?>