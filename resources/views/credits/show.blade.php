<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $credit->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('credits.edit', $credit) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Modifier') }}
                </a>
                @if($credit->status === 'active')
                    <form action="{{ route('credits.mark-completed', $credit) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Marquer comme terminé') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informations générales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Informations du crédit') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-1">{{ __('Montant emprunté') }}</h4>
                            <p class="text-2xl font-bold text-blue-900">{{ $credit->currency->symbol }} {{ number_format($credit->amount, 2) }}</p>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-1">{{ __('Mensualité') }}</h4>
                            <p class="text-2xl font-bold text-green-900">{{ $credit->currency->symbol }} {{ number_format($credit->monthly_payment, 2) }}</p>
                        </div>
                        
                        <div class="bg-red-50 rounded-lg p-4">
                            <h4 class="font-medium text-red-800 mb-1">{{ __('Solde restant') }}</h4>
                            <p class="text-2xl font-bold text-red-900">{{ $credit->currency->symbol }} {{ number_format($credit->remaining_balance, 2) }}</p>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-1">{{ __('Taux d\'intérêt') }}</h4>
                            <p class="text-2xl font-bold text-purple-900">{{ $credit->interest_rate }}%</p>
                        </div>
                    </div>

                    @if($credit->description)
                        <div class="mt-4">
                            <h4 class="font-medium text-gray-900 mb-2">{{ __('Description') }}</h4>
                            <p class="text-gray-600">{{ $credit->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Progression et détails -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Progression -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Progression du remboursement') }}</h3>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>{{ __('Progression') }}</span>
                                <span>{{ number_format($credit->getProgressPercentage(), 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-blue-600 h-4 rounded-full transition-all duration-300" style="width: {{ $credit->getProgressPercentage() }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Montant remboursé') }}</span>
                                <span class="font-semibold">{{ $credit->currency->symbol }} {{ number_format($credit->total_amount - $credit->remaining_balance, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Montant total') }}</span>
                                <span class="font-semibold">{{ $credit->currency->symbol }} {{ number_format($credit->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Intérêts totaux') }}</span>
                                <span class="font-semibold text-red-600">{{ $credit->currency->symbol }} {{ number_format($credit->total_interest, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations temporelles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Informations temporelles') }}</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ __('Date de début') }}</span>
                                <span class="font-semibold">{{ $credit->start_date->format('d/m/Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ __('Date de fin') }}</span>
                                <span class="font-semibold">{{ $credit->end_date->format('d/m/Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ __('Durée totale') }}</span>
                                <span class="font-semibold">{{ $credit->duration_months }} {{ __('mois') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ __('Mois restants') }}</span>
                                <span class="font-semibold">{{ $credit->getRemainingMonths() }} {{ __('mois') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ __('Statut') }}</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($credit->status === 'active') bg-green-100 text-green-800
                                    @elseif($credit->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ __($credit->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compte associé -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Compte associé') }}</h3>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $credit->account->name }}</h4>
                            <p class="text-gray-600">{{ $credit->account->description }}</p>
                        </div>
                        <a href="{{ route('accounts.show', $credit->account) }}" class="text-blue-600 hover:text-blue-900">
                            {{ __('Voir le compte') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Actions') }}</h3>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('credits.edit', $credit) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Modifier le crédit') }}
                        </a>
                        
                        @if($credit->status === 'active')
                            <form action="{{ route('credits.mark-completed', $credit) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Marquer comme terminé') }}
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('credits.destroy', $credit) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce crédit ?') }}')">
                                {{ __('Supprimer') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 