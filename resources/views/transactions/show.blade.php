<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de la transaction') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('transactions.edit', $transaction) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Modifier') }}
                </a>
                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                        onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette transaction ?') }}')">
                        {{ __('Supprimer') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations principales -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Informations principales') }}</h3>
                                <div class="mt-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('Type') }}</span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($transaction->type === 'income') bg-green-100 text-green-800
                                            @elseif($transaction->type === 'expense') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ __($transaction->type) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('Montant') }}</span>
                                        <span class="font-medium @if($transaction->type === 'income') text-green-600 @elseif($transaction->type === 'expense') text-red-600 @else text-blue-600 @endif">
                                            {{ $transaction->currency->symbol }} {{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('Date') }}</span>
                                        <span>{{ $transaction->date->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Compte') }}</h3>
                                <div class="mt-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('Nom du compte') }}</span>
                                        <span>{{ $transaction->account->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('Solde actuel') }}</span>
                                        <span>{{ $transaction->account->currency->symbol }} {{ number_format($transaction->account->current_balance, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($transaction->category)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Catégorie') }}</h3>
                                <div class="mt-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('Nom') }}</span>
                                        <span>{{ $transaction->category->name }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Détails supplémentaires -->
                        <div class="space-y-4">
                            @if($transaction->description)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Description') }}</h3>
                                <p class="mt-2 text-gray-600">{{ $transaction->description }}</p>
                            </div>
                            @endif

                            @if($transaction->tags->isNotEmpty())
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Tags') }}</h3>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($transaction->tags as $tag)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($transaction->type === 'transfer' && $transaction->transferTransaction)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Détails du transfert') }}</h3>
                                <div class="mt-4 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ __('Compte de destination') }}</span>
                                        <span>{{ $transaction->transferTransaction->account->name }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('transactions.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            {{ __('Retour à la liste') }} →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 