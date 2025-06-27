<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['user']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['user']); ?>
<?php foreach (array_filter((['user']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
        <span class="sr-only">Voir les notifications</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M9 11h.01M9 8h.01"/>
        </svg>
        
        <?php if($user->unreadNotifications->count() > 0): ?>
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
        <?php endif; ?>
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="py-1">
            <div class="px-4 py-2 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                    <?php if($user->unreadNotifications->count() > 0): ?>
                        <a href="<?php echo e(route('notifications.index')); ?>" class="text-sm text-blue-600 hover:text-blue-800">
                            Voir tout (<?php echo e($user->unreadNotifications->count()); ?>)
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="max-h-64 overflow-y-auto">
                <?php $__empty_1 = true; $__currentLoopData = $user->unreadNotifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900"><?php echo e($notification->data['title']); ?></p>
                                <p class="text-sm text-gray-600 mt-1"><?php echo e(Str::limit($notification->data['message'], 60)); ?></p>
                                <p class="text-xs text-gray-400 mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                            </div>
                            <button onclick="markAsRead('<?php echo e($notification->id); ?>')" class="text-xs text-blue-600 hover:text-blue-800 ml-2">
                                ✓
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-4 py-3 text-center">
                        <p class="text-sm text-gray-500">Aucune nouvelle notification</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if($user->unreadNotifications->count() > 0): ?>
                <div class="px-4 py-2 border-t border-gray-200">
                    <a href="<?php echo e(route('notifications.index')); ?>" class="block text-center text-sm text-blue-600 hover:text-blue-800">
                        Voir toutes les notifications
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script> <?php /**PATH C:\laragon\www\HomeFinanceManager-new\resources\views/components/notification-dropdown.blade.php ENDPATH**/ ?>