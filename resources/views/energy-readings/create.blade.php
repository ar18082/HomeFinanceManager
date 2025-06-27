<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un relevé de compteur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('energy-readings.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="energy_meter_id" :value="__('Compteur')" />
                            <select id="energy_meter_id" name="energy_meter_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Sélectionner un compteur</option>
                                @foreach($meters as $meter)
                                    <option value="{{ $meter->id }}" 
                                            {{ (old('energy_meter_id') == $meter->id || request('meter') == $meter->id) ? 'selected' : '' }}
                                            data-unit="{{ $meter->unit }}"
                                            data-current-reading="{{ $meter->current_reading }}">
                                        {{ $meter->name }} ({{ $meter->type_label }}) - {{ $meter->location ?: 'Aucune localisation' }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('energy_meter_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="reading_date" :value="__('Date du relevé')" />
                            <x-text-input id="reading_date" class="block mt-1 w-full" type="date" name="reading_date" :value="old('reading_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('reading_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="reading_value" :value="__('Valeur lue')" />
                            <div class="flex items-center">
                                <x-text-input id="reading_value" class="block mt-1 w-full" type="number" step="0.001" name="reading_value" :value="old('reading_value')" required placeholder="0.000" />
                                <span id="unit_display" class="ml-2 text-gray-600 font-medium">-</span>
                            </div>
                            <x-input-error :messages="$errors->get('reading_value')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="consumption" :value="__('Consommation (optionnel - calculée automatiquement)')" />
                            <div class="flex items-center">
                                <x-text-input id="consumption" class="block mt-1 w-full" type="number" step="0.001" name="consumption" :value="old('consumption')" placeholder="Calculé automatiquement" />
                                <span id="consumption_unit" class="ml-2 text-gray-600 font-medium">-</span>
                            </div>
                            <x-input-error :messages="$errors->get('consumption')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="currency_id" :value="__('Devise')" />
                            <select id="currency_id" name="currency_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Sélectionner une devise</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ old('currency_id', $currency->is_default ? $currency->id : '') == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }} ({{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('currency_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="unit_price" :value="__('Prix unitaire (optionnel)')" />
                            <div class="flex items-center">
                                <x-text-input id="unit_price" class="block mt-1 w-full" type="number" step="0.0001" name="unit_price" :value="old('unit_price')" placeholder="0.0000" />
                                <span id="price_unit" class="ml-2 text-gray-600 font-medium">-</span>
                            </div>
                            <x-input-error :messages="$errors->get('unit_price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="cost" :value="__('Coût (optionnel - calculé automatiquement)')" />
                            <div class="flex items-center">
                                <x-text-input id="cost" class="block mt-1 w-full" type="number" step="0.01" name="cost" :value="old('cost')" placeholder="Calculé automatiquement" />
                                <span id="cost_currency" class="ml-2 text-gray-600 font-medium">-</span>
                            </div>
                            <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="reading_method" :value="__('Méthode de lecture (optionnel)')" />
                            <select id="reading_method" name="reading_method" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">Sélectionner une méthode</option>
                                <option value="manual" {{ old('reading_method') == 'manual' ? 'selected' : '' }}>Lecture manuelle</option>
                                <option value="photo" {{ old('reading_method') == 'photo' ? 'selected' : '' }}>Photo du compteur</option>
                                <option value="app" {{ old('reading_method') == 'app' ? 'selected' : '' }}>Application mobile</option>
                                <option value="online" {{ old('reading_method') == 'online' ? 'selected' : '' }}>Portail en ligne</option>
                                <option value="other" {{ old('reading_method') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            <x-input-error :messages="$errors->get('reading_method')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_estimated" value="1" {{ old('is_estimated') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Lecture estimée</span>
                            </label>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="notes" :value="__('Notes (optionnel)')" />
                            <x-textarea-input id="notes" class="block mt-1 w-full" name="notes" rows="3" placeholder="Informations supplémentaires...">{{ old('notes') }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('energy-meters.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Annuler
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Ajouter le relevé') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mettre à jour les unités et calculer automatiquement
        function updateUnits() {
            const meterSelect = document.getElementById('energy_meter_id');
            const selectedOption = meterSelect.options[meterSelect.selectedIndex];
            const unit = selectedOption.dataset.unit || '-';
            const currentReading = parseFloat(selectedOption.dataset.currentReading) || 0;
            
            document.getElementById('unit_display').textContent = unit;
            document.getElementById('consumption_unit').textContent = unit;
            
            const currencySelect = document.getElementById('currency_id');
            const selectedCurrency = currencySelect.options[currencySelect.selectedIndex];
            const currencySymbol = selectedCurrency.textContent.match(/\(([^)]+)\)/)?.[1] || '-';
            
            document.getElementById('price_unit').textContent = currencySymbol + '/' + unit;
            document.getElementById('cost_currency').textContent = currencySymbol;
            
            // Calculer automatiquement la consommation
            const readingValue = parseFloat(document.getElementById('reading_value').value) || 0;
            if (readingValue > 0 && currentReading > 0) {
                const consumption = readingValue - currentReading;
                if (consumption >= 0) {
                    document.getElementById('consumption').value = consumption.toFixed(3);
                }
            }
        }

        // Calculer automatiquement le coût
        function calculateCost() {
            const consumption = parseFloat(document.getElementById('consumption').value) || 0;
            const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
            
            if (consumption > 0 && unitPrice > 0) {
                const cost = consumption * unitPrice;
                document.getElementById('cost').value = cost.toFixed(2);
            }
        }

        // Événements
        document.getElementById('energy_meter_id').addEventListener('change', updateUnits);
        document.getElementById('currency_id').addEventListener('change', updateUnits);
        document.getElementById('reading_value').addEventListener('input', updateUnits);
        document.getElementById('consumption').addEventListener('input', calculateCost);
        document.getElementById('unit_price').addEventListener('input', calculateCost);

        // Initialisation
        updateUnits();
    </script>
</x-app-layout> 