<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la transaction récurrente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('recurring-transactions.update', $recurringTransaction) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Type de transaction -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type de transaction') }}</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="income" {{ $recurringTransaction->type === 'income' ? 'selected' : '' }}>{{ __('Revenu') }}</option>
                                <option value="expense" {{ $recurringTransaction->type === 'expense' ? 'selected' : '' }}>{{ __('Dépense') }}</option>
                                <option value="transfer" {{ $recurringTransaction->type === 'transfer' ? 'selected' : '' }}>{{ __('Virement') }}</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                            <input type="text" name="description" id="description" value="{{ old('description', $recurringTransaction->description) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Montant -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">{{ __('Montant') }}</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="amount" id="amount" step="0.01" min="0" value="{{ old('amount', $recurringTransaction->amount) }}" class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Compte source -->
                        <div>
                            <label for="account_id" class="block text-sm font-medium text-gray-700">{{ __('Compte') }}</label>
                            <select name="account_id" id="account_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ $recurringTransaction->account_id === $account->id ? 'selected' : '' }}>
                                        {{ $account->name }} ({{ $account->currency->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Compte destination (pour les virements) -->
                        <div id="destination_account_div" style="display: none;">
                            <label for="destination_account_id" class="block text-sm font-medium text-gray-700">{{ __('Compte de destination') }}</label>
                            <select name="destination_account_id" id="destination_account_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ $recurringTransaction->destination_account_id === $account->id ? 'selected' : '' }}>
                                        {{ $account->name }} ({{ $account->currency->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('destination_account_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Catégorie') }}</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">{{ __('Aucune catégorie') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $recurringTransaction->category_id === $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Devise -->
                        <div>
                            <label for="currency_id" class="block text-sm font-medium text-gray-700">{{ __('Devise') }}</label>
                            <select name="currency_id" id="currency_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ $recurringTransaction->currency_id === $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }} ({{ $currency->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fréquence -->
                        <div>
                            <label for="frequency" class="block text-sm font-medium text-gray-700">{{ __('Fréquence') }}</label>
                            <select name="frequency" id="frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="daily" {{ $recurringTransaction->frequency === 'daily' ? 'selected' : '' }}>{{ __('Quotidienne') }}</option>
                                <option value="weekly" {{ $recurringTransaction->frequency === 'weekly' ? 'selected' : '' }}>{{ __('Hebdomadaire') }}</option>
                                <option value="monthly" {{ $recurringTransaction->frequency === 'monthly' ? 'selected' : '' }}>{{ __('Mensuelle') }}</option>
                                <option value="yearly" {{ $recurringTransaction->frequency === 'yearly' ? 'selected' : '' }}>{{ __('Annuelle') }}</option>
                            </select>
                            @error('frequency')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Intervalle -->
                        <div>
                            <label for="interval" class="block text-sm font-medium text-gray-700">{{ __('Intervalle') }}</label>
                            <input type="number" name="interval" id="interval" min="1" value="{{ old('interval', $recurringTransaction->interval) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Exemple : 2 pour "tous les 2 mois"') }}</p>
                            @error('interval')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date de début -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">{{ __('Date de début') }}</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $recurringTransaction->start_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date de fin -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">{{ __('Date de fin (optionnel)') }}</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $recurringTransaction->end_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nombre d'occurrences -->
                        <div>
                            <label for="times_to_run" class="block text-sm font-medium text-gray-700">{{ __('Nombre d\'occurrences (optionnel)') }}</label>
                            <input type="number" name="times_to_run" id="times_to_run" min="1" value="{{ old('times_to_run', $recurringTransaction->times_to_run) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">{{ __('Laissez vide pour une durée illimitée') }}</p>
                            @error('times_to_run')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('Notes (optionnel)') }}</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $recurringTransaction->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="active" id="active" value="1" {{ $recurringTransaction->active ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="active" class="font-medium text-gray-700">{{ __('Active') }}</label>
                                <p class="text-gray-500">{{ __('Décochez pour désactiver temporairement cette transaction récurrente') }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('recurring-transactions.show', $recurringTransaction) }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                {{ __('Annuler') }}
                            </a>
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                {{ __('Mettre à jour') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const destinationAccountDiv = document.getElementById('destination_account_div');

            function toggleDestinationAccount() {
                destinationAccountDiv.style.display = typeSelect.value === 'transfer' ? 'block' : 'none';
            }

            typeSelect.addEventListener('change', toggleDestinationAccount);
            toggleDestinationAccount();
        });
    </script>
    @endpush
</x-app-layout> 