<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle devise') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('currencies.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="code" :value="__('Code (ISO)')" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code')" required maxlength="3" />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Code ISO de la devise (ex: EUR, USD, GBP)</p>
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nom')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="symbol" :value="__('Symbole')" />
                            <x-text-input id="symbol" name="symbol" type="text" class="mt-1 block w-full" :value="old('symbol')" required />
                            <x-input-error :messages="$errors->get('symbol')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Symbole de la devise (ex: €, $, £)</p>
                        </div>

                        <div>
                            <x-input-label for="exchange_rate" :value="__('Taux de change')" />
                            <x-text-input id="exchange_rate" name="exchange_rate" type="number" step="0.000001" class="mt-1 block w-full" :value="old('exchange_rate')" required />
                            <x-input-error :messages="$errors->get('exchange_rate')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Taux de change par rapport à la devise par défaut</p>
                        </div>

                        <div class="block mt-4">
                            <label for="is_default" class="inline-flex items-center">
                                <input id="is_default" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Définir comme devise par défaut') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
                            <a href="{{ route('currencies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Annuler') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 