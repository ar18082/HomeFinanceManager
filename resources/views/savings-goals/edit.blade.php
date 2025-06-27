<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier l\'objectif') }} : {{ $savingsGoal->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('savings-goals.update', $savingsGoal) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nom -->
                        <div>
                            <x-input-label for="name" :value="__('Nom de l\'objectif')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $savingsGoal->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Compte -->
                        <div>
                            <x-input-label for="account_id" :value="__('Compte')" />
                            <select id="account_id" name="account_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">{{ __('Sélectionner un compte') }}</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" @selected(old('account_id', $savingsGoal->account_id) == $account->id)>
                                        {{ $account->name }} ({{ $account->currency->code }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                        </div>

                        <!-- Montant cible -->
                        <div>
                            <x-input-label for="target_amount" :value="__('Montant cible')" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                                <x-text-input id="target_amount" name="target_amount" type="number" class="block w-full pl-7" step="0.01" min="0" :value="old('target_amount', $savingsGoal->target_amount)" required />
                            </div>
                            <x-input-error :messages="$errors->get('target_amount')" class="mt-2" />
                        </div>

                        <!-- Devise -->
                        <div>
                            <x-input-label for="currency_id" :value="__('Devise')" />
                            <select id="currency_id" name="currency_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected(old('currency_id', $savingsGoal->currency_id) == $currency->id)>
                                        {{ $currency->code }} ({{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('currency_id')" class="mt-2" />
                        </div>

                        <!-- Montant actuel -->
                        <div>
                            <x-input-label for="current_amount" :value="__('Montant actuel')" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                                <x-text-input id="current_amount" name="current_amount" type="number" class="block w-full pl-7" step="0.01" min="0" :value="old('current_amount', $savingsGoal->current_amount)" required />
                            </div>
                            <x-input-error :messages="$errors->get('current_amount')" class="mt-2" />
                        </div>

                        <!-- Date cible -->
                        <div>
                            <x-input-label for="target_date" :value="__('Date cible')" />
                            <x-text-input id="target_date" name="target_date" type="date" class="mt-1 block w-full" :value="old('target_date', $savingsGoal->target_date->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('target_date')" class="mt-2" />
                        </div>

                        <!-- Icône -->
                        <div>
                            <x-input-label for="icon" :value="__('Icône (emoji)')" />
                            <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full" :value="old('icon', $savingsGoal->icon)" placeholder="🎯" />
                            <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                        </div>

                        <!-- Couleur -->
                        <div>
                            <x-input-label for="color" :value="__('Couleur')" />
                            <x-text-input id="color" name="color" type="color" class="mt-1 block w-20" :value="old('color', $savingsGoal->color ?? '#3B82F6')" />
                            <x-input-error :messages="$errors->get('color')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $savingsGoal->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Actif -->
                        <div class="flex items-center">
                            <input id="active" name="active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('active', $savingsGoal->active))>
                            <x-input-label for="active" :value="__('Objectif actif')" class="ml-2" />
                            <x-input-error :messages="$errors->get('active')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Annuler') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Mettre à jour l\'objectif') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 