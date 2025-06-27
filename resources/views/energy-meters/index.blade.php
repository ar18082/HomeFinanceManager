<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Compteurs d\'énergie') }}
            </h2>
            <a href="{{ route('energy-meters.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ajouter un compteur
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($meters->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <p class="text-lg mb-4">Aucun compteur d'énergie configuré</p>
                        <a href="{{ route('energy-meters.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Créer votre premier compteur
                        </a>
                    </div>
                </div>
            @else
                @foreach($meters as $type => $typeMeters)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                @php
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
                                @endphp
                                <span class="mr-2">{{ $typeIcons[$type] }}</span>
                                {{ $typeLabels[$type] }}
                                <span class="ml-2 text-sm text-gray-500">({{ $typeMeters->count() }} compteur{{ $typeMeters->count() > 1 ? 's' : '' }})</span>
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($typeMeters as $meter)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $meter->name }}</h4>
                                                @if($meter->location)
                                                    <p class="text-sm text-gray-600">{{ $meter->location }}</p>
                                                @endif
                                                @if($meter->meter_number)
                                                    <p class="text-xs text-gray-500">N° {{ $meter->meter_number }}</p>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if($meter->active)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Actif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Inactif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="space-y-2 mb-4">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Dernière lecture:</span>
                                                <span class="font-medium">
                                                    @if($meter->last_reading_date)
                                                        {{ number_format($meter->current_reading, 3) }} {{ $meter->unit }}
                                                        <span class="text-gray-500">({{ $meter->last_reading_date->format('d/m/Y') }})</span>
                                                    @else
                                                        <span class="text-gray-500">Aucune lecture</span>
                                                    @endif
                                                </span>
                                            </div>
                                            
                                            @if($meter->latestReading)
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-gray-600">Dernier mois:</span>
                                                    <span class="font-medium">
                                                        {{ number_format($meter->last_month_consumption, 3) }} {{ $meter->unit }}
                                                        <span class="text-gray-500">({{ number_format($meter->last_month_cost, 2) }} €)</span>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('energy-meters.show', $meter) }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Voir détails
                                                </a>
                                                <a href="{{ route('energy-readings.create') }}?meter={{ $meter->id }}" 
                                                   class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                    Ajouter relevé
                                                </a>
                                            </div>
                                            <div class="flex space-x-1">
                                                <a href="{{ route('energy-meters.edit', $meter) }}" 
                                                   class="text-gray-600 hover:text-gray-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('energy-meters.destroy', $meter) }}" method="POST" class="inline" 
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce compteur ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout> 