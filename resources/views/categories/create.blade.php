<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nouvelle catégorie') }}
            </h2>
            <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Retour') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Créer une nouvelle catégorie') }}</h3>
                    <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
                        @csrf
                        <!-- Nom de la catégorie -->
                        <div>
                            <x-input-label for="name" :value="__('Nom de la catégorie')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Type de catégorie -->
                        <div>
                            <x-input-label for="type" :value="__('Type de catégorie')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Sélectionnez un type') }}</option>
                                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>
                                    {{ __('Dépense') }}
                                </option>
                                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>
                                    {{ __('Revenu') }}
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Catégorie parent -->
                        <div>
                            <x-input-label for="parent_id" :value="__('Catégorie parent (optionnel)')" />
                            <select id="parent_id" name="parent_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">{{ __('Aucune catégorie parent') }}</option>
                                @foreach($parentCategories ?? [] as $parentCategory)
                                    <option value="{{ $parentCategory->id }}" {{ old('parent_id') == $parentCategory->id ? 'selected' : '' }}>
                                        {{ $parentCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                        </div>

                        <!-- Couleur -->
                        <div>
                            <x-input-label for="color" :value="__('Couleur (optionnel)')" />
                            <input id="color" name="color" type="color" class="mt-1 block w-full h-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('color', '#3B82F6')" />
                            <x-input-error :messages="$errors->get('color')" class="mt-2" />
                        </div>

                        <!-- Icône -->
                        <div>
                            <x-input-label for="icon" :value="__('Icône (optionnel)')" />
                            <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full" :value="old('icon')" placeholder="fas fa-home" />
                            <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">{{ __('Utilisez les classes FontAwesome (ex: fas fa-home, fas fa-car, etc.)') }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description (optionnel)')" />
                            <x-textarea-input id="description" name="description" class="mt-1 block w-full" rows="3">{{ old('description') }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Statut -->
                        <div class="flex items-center">
                            <input id="active" name="active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ old('active', true) ? 'checked' : '' }}>
                            <label for="active" class="ml-2 block text-sm text-gray-900">
                                {{ __('Catégorie active') }}
                            </label>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button>
                                {{ __('Créer la catégorie') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 