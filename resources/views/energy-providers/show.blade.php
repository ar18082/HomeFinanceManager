<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $energyProvider->name }}
            </h2>
            <div class="flex space-x-2">
                <form action="{{ route('energy-providers.toggle-active', $energyProvider) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-{{ $energyProvider->active ? 'yellow' : 'green' }}-500 hover:bg-{{ $energyProvider->active ? 'yellow' : 'green' }}-700 text-white font-bold py-2 px-4 rounded">
                        {{ $energyProvider->active ? 'Désactiver' : 'Activer' }}
                    </button>
                </form>
                <a href="{{ route('energy-providers.edit', $energyProvider) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Modifier
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Informations du fournisseur -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informations du fournisseur</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nom</p>
                            <p class="font-medium">{{ $energyProvider->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Code</p>
                            <p class="font-medium">{{ $energyProvider->code }}</p>
                        </div>
                        @if($energyProvider->website)
                        <div>
                            <p class="text-sm text-gray-600">Site web</p>
                            <a href="{{ $energyProvider->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ $energyProvider->website }}</a>
                        </div>
                        @endif
                        @if($energyProvider->contact_email)
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $energyProvider->contact_email }}</p>
                        </div>
                        @endif
                        @if($energyProvider->description)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Description</p>
                            <p class="font-medium">{{ $energyProvider->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Statistiques</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $statistics['total_tarifs'] }}</p>
                            <p class="text-sm text-gray-600">Total tarifs</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $statistics['active_tariffs'] }}</p>
                            <p class="text-sm text-gray-600">Tarifs actifs</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-yellow-600">{{ $statistics['electricity_tariffs'] }}</p>
                            <p class="text-sm text-gray-600">Tarifs électricité</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-orange-600">{{ $statistics['gas_tariffs'] }}</p>
                            <p class="text-sm text-gray-600">Tarifs gaz</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarifs par type -->
            @foreach($tariffs as $type => $typeTariffs)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            @php
                                $typeLabels = [
                                    'energy' => 'Énergie',
                                    'distribution' => 'Distribution',
                                    'transport' => 'Transport',
                                    'tax' => 'Taxes',
                                    'fixed' => 'Frais fixes'
                                ];
                                $typeIcons = [
                                    'energy' => '⚡',
                                    'distribution' => '🔌',
                                    'transport' => '🚚',
                                    'tax' => '🏛️',
                                    'fixed' => '💰'
                                ];
                            @endphp
                            <span class="mr-2">{{ $typeIcons[$type] }}</span>
                            {{ $typeLabels[$type] }}
                            <span class="ml-2 text-sm text-gray-500">({{ $typeTariffs->count() }} tarif{{ $typeTariffs->count() > 1 ? 's' : '' }})</span>
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unité</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TVA</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($typeTariffs as $tariff)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $tariff->name }}</div>
                                                @if($tariff->period_type !== 'single')
                                                    <div class="text-sm text-gray-500">{{ $tariff->period_type_label }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $tariff->formatted_rate }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $tariff->unit }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $tariff->formatted_tva_rate }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if($tariff->start_date)
                                                        Du {{ $tariff->start_date->format('d/m/Y') }}
                                                    @endif
                                                    @if($tariff->end_date)
                                                        <br>Au {{ $tariff->end_date->format('d/m/Y') }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($tariff->active)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Actif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Inactif
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('energy-providers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Retour à la liste
                        </a>
                        <div class="flex space-x-2">
                            <a href="{{ route('energy-providers.tariffs', $energyProvider) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Voir tous les tarifs
                            </a>
                            <a href="{{ route('energy-meters.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Créer un compteur
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 