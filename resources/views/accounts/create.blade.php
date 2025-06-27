<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nouveau compte') }}
            </h2>
            <a href="{{ route('accounts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Retour') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Créer un nouveau compte') }}</h3>
                    
                    <form method="POST" action="{{ route('accounts.store') }}" class="space-y-6">
                        @csrf

                        <!-- Nom du compte -->
                        <div>
                            <x-input-label for="name" :value="__('Nom du compte')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                         :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Type de compte -->
                        <div>
                            <x-input-label for="type" :value="__('Type de compte')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Sélectionnez un type') }}</option>
                                <option value="checking" {{ old('type') == 'checking' ? 'selected' : '' }}>
                                    {{ __('Compte courant') }}
                                </option>
                                <option value="savings" {{ old('type') == 'savings' ? 'selected' : '' }}>
                                    {{ __('Compte d\'épargne') }}
                                </option>
                                <option value="cash" {{ old('type') == 'cash' ? 'selected' : '' }}>
                                    {{ __('Espèces') }}
                                </option>
                                <option value="credit_card" {{ old('type') == 'credit_card' ? 'selected' : '' }}>
                                    {{ __('Carte de crédit') }}
                                </option>
                                <option value="investment" {{ old('type') == 'investment' ? 'selected' : '' }}>
                                    {{ __('Compte d\'investissement') }}
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Devise -->
                        <div>
                            <x-input-label for="currency_id" :value="__('Devise')" />
                            <select id="currency_id" name="currency_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Sélectionnez une devise') }}</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }} ({{ $currency->code }} - {{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('currency_id')" class="mt-2" />
                        </div>

                        <!-- Solde initial -->
                        <div>
                            <x-input-label for="initial_balance" :value="__('Solde initial')" />
                            <x-text-input id="initial_balance" name="initial_balance" type="number" step="0.01" class="mt-1 block w-full" 
                                         :value="old('initial_balance', 0)" required />
                            <x-input-error :messages="$errors->get('initial_balance')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">{{ __('Le solde initial sera défini comme solde courant.') }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description (optionnel)')" />
                            <x-textarea-input id="description" name="description" class="mt-1 block w-full" rows="3">{{ old('description') }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Options -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="include_in_net_worth" name="include_in_net_worth" type="checkbox" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                       value="1" {{ old('include_in_net_worth') ? 'checked' : '' }}>
                                <label for="include_in_net_worth" class="ml-2 block text-sm text-gray-900">
                                    {{ __('Inclure dans la valeur nette') }}
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input id="active" name="active" type="checkbox" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                       value="1" {{ old('active', true) ? 'checked' : '' }}>
                                <label for="active" class="ml-2 block text-sm text-gray-900">
                                    {{ __('Compte actif') }}
                                </label>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('accounts.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button>
                                {{ __('Créer le compte') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 