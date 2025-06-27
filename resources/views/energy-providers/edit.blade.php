<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier {{ $energyProvider->name }}
            </h2>
            <a href="{{ route('energy-providers.show', $energyProvider) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour aux détails
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informations du fournisseur</h3>
                </div>
                
                <form method="POST" action="{{ route('energy-providers.update', $energyProvider) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <x-input-label for="name" value="Nom du fournisseur" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $energyProvider->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Code -->
                        <div>
                            <x-input-label for="code" value="Code" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $energyProvider->code)" required />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <!-- Site web -->
                        <div>
                            <x-input-label for="website" value="Site web (optionnel)" />
                            <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $energyProvider->website)" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>

                        <!-- Email de contact -->
                        <div>
                            <x-input-label for="contact_email" value="Email de contact (optionnel)" />
                            <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1 block w-full" :value="old('contact_email', $energyProvider->contact_email)" />
                            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <x-input-label for="description" value="Description (optionnel)" />
                            <x-textarea-input id="description" name="description" class="mt-1 block w-full" rows="3">{{ old('description', $energyProvider->description) }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Statut -->
                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="active" value="1" {{ old('active', $energyProvider->active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Fournisseur actif</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('energy-providers.show', $energyProvider) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Annuler
                        </a>
                        <x-primary-button>
                            Mettre à jour
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 