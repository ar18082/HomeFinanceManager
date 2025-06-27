@props(['user'])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
        <span class="sr-only">Voir les notifications</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M9 11h.01M9 8h.01"/>
        </svg>
        
        @if($user->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="py-1">
            <div class="px-4 py-2 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                    @if($user->unreadNotifications->count() > 0)
                        <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                            Voir tout ({{ $user->unreadNotifications->count() }})
                        </a>
                    @endif
                </div>
            </div>
            
            <div class="max-h-64 overflow-y-auto">
                @forelse($user->unreadNotifications->take(5) as $notification)
                    <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($notification->data['message'], 60) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <button onclick="markAsRead('{{ $notification->id }}')" class="text-xs text-blue-600 hover:text-blue-800 ml-2">
                                ✓
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-3 text-center">
                        <p class="text-sm text-gray-500">Aucune nouvelle notification</p>
                    </div>
                @endforelse
            </div>
            
            @if($user->unreadNotifications->count() > 0)
                <div class="px-4 py-2 border-t border-gray-200">
                    <a href="{{ route('notifications.index') }}" class="block text-center text-sm text-blue-600 hover:text-blue-800">
                        Voir toutes les notifications
                    </a>
                </div>
            @endif
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
</script> 