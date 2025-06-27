<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouveau budget') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('budgets.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nom -->
                        <div>
                            <x-input-label for="name" :value="__('Nom du budget')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <x-input-label for="category_id" :value="__('Catégorie')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">{{ __('Sélectionner une catégorie') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Montant -->
                        <div>
                            <x-input-label for="amount" :value="__('Montant')" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                                <x-text-input id="amount" name="amount" type="number" class="block w-full pl-7" step="0.01" min="0" :value="old('amount')" required />
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Devise -->
                        <div>
                            <x-input-label for="currency_id" :value="__('Devise')" />
                            <select id="currency_id" name="currency_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" @selected(old('currency_id') == $currency->id)>
                                        {{ $currency->code }} ({{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('currency_id')" class="mt-2" />
                        </div>

                        <!-- Période -->
                        <div>
                            <x-input-label for="period" :value="__('Période')" />
                            <select id="period" name="period" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required x-model="period">
                                <option value="monthly" @selected(old('period') == 'monthly')>{{ __('Mensuel') }}</option>
                                <option value="yearly" @selected(old('period') == 'yearly')>{{ __('Annuel') }}</option>
                                <option value="custom" @selected(old('period') == 'custom')>{{ __('Personnalisé') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('period')" class="mt-2" />
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="start_date" :value="__('Date de début')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date')" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            <div x-show="period === 'custom'">
                                <x-input-label for="end_date" :value="__('Date de fin')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date')" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <x-input-label for="notes" :value="__('Notes')" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <!-- Actif -->
                        <div class="flex items-center">
                            <input id="active" name="active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('active', true))>
                            <x-input-label for="active" :value="__('Budget actif')" class="ml-2" />
                            <x-input-error :messages="$errors->get('active')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Annuler') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Créer le budget') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('budgetForm', () => ({
                period: 'monthly'
            }))
        })
    </script>
    @endpush
</x-app-layout> 