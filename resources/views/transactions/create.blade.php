<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle transaction') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ type: 'expense' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Type de transaction -->
                        <div>
                            <x-input-label for="type" :value="__('Type de transaction')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required x-model="type">
                                <option value="expense">{{ __('Dépense') }}</option>
                                <option value="income">{{ __('Revenu') }}</option>
                                <option value="transfer">{{ __('Transfert') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Date -->
                        <div>
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" type="date" name="date" :value="old('date', date('Y-m-d'))" required class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Montant -->
                        <div>
                            <x-input-label for="amount" :value="__('Montant')" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                                <x-text-input id="amount" type="number" name="amount" :value="old('amount')" required class="block w-full pl-7" step="0.01" min="0" />
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Compte source -->
                        <div>
                            <x-input-label for="account_id" :value="__('Compte')" />
                            <select id="account_id" name="account_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->name }} ({{ $account->currency->symbol }} {{ number_format($account->current_balance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                        </div>

                        <!-- Compte destination (pour les transferts) -->
                        <div x-show="type === 'transfer'" x-cloak>
                            <x-input-label for="destination_account_id" :value="__('Compte de destination')" />
                            <select id="destination_account_id" name="destination_account_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->name }} ({{ $account->currency->symbol }} {{ number_format($account->current_balance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('destination_account_id')" class="mt-2" />
                        </div>

                        <!-- Catégorie -->
                        <div x-show="type !== 'transfer'" x-cloak>
                            <x-input-label for="category_id" :value="__('Catégorie')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">{{ __('Sélectionner une catégorie') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Devise -->
                        <div>
                            <x-input-label for="currency_id" :value="__('Devise')" />
                            <select id="currency_id" name="currency_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}">
                                        {{ $currency->code }} ({{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('currency_id')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Tags -->
                        <div>
                            <x-input-label :value="__('Tags')" />
                            <div class="mt-2 space-y-2">
                                @foreach($tags as $tag)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2">{{ $tag->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Annuler') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Créer la transaction') }}
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
            Alpine.data('transactionForm', () => ({
                type: 'expense',
                init() {
                    // Logique d'initialisation si nécessaire
                }
            }))
        })
    </script>
    @endpush
</x-app-layout> 