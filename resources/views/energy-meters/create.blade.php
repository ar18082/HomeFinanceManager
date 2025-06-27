<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un compteur d\'énergie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('energy-meters.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nom du compteur')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type d\'énergie')" />
                            <select id="type" name="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Sélectionner un type</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="meter_number" :value="__('Numéro de compteur (optionnel)')" />
                            <x-text-input id="meter_number" class="block mt-1 w-full" type="text" name="meter_number" :value="old('meter_number')" />
                            <x-input-error :messages="$errors->get('meter_number')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Localisation (optionnel)')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="ex: Cuisine, Garage, etc." />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="unit" :value="__('Unité de mesure')" />
                            <x-text-input id="unit" class="block mt-1 w-full" type="text" name="unit" :value="old('unit', 'kWh')" required placeholder="ex: kWh, m³, L" />
                            <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="current_reading" :value="__('Lecture actuelle (optionnel)')" />
                            <x-text-input id="current_reading" class="block mt-1 w-full" type="number" step="0.001" name="current_reading" :value="old('current_reading')" placeholder="0.000" />
                            <x-input-error :messages="$errors->get('current_reading')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="last_reading_date" :value="__('Date de la dernière lecture (optionnel)')" />
                            <x-text-input id="last_reading_date" class="block mt-1 w-full" type="date" name="last_reading_date" :value="old('last_reading_date')" />
                            <x-input-error :messages="$errors->get('last_reading_date')" class="mt-2" />
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
                                {{ __('Créer le compteur') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-remplir l'unité selon le type sélectionné
        document.getElementById('type').addEventListener('change', function() {
            const unitField = document.getElementById('unit');
            const type = this.value;
            
            const defaultUnits = {
                'electricity': 'kWh',
                'gas': 'm³',
                'water': 'm³'
            };
            
            if (defaultUnits[type] && !unitField.value) {
                unitField.value = defaultUnits[type];
            }
        });
    </script>
</x-app-layout> 