<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Objectifs d\'épargne') }}
            </h2>
            <a href="{{ route('savings-goals.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Nouvel objectif') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Gestion des objectifs d\'épargne') }}</h3>
                    <p class="text-gray-600 mb-4">
                        {{ __('Les objectifs d\'épargne vous aident à planifier et suivre vos économies pour des projets spécifiques. Définissez un montant cible, une date limite et suivez votre progression vers vos objectifs financiers.') }}
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2">{{ __('Création d\'objectifs') }}</h4>
                            <p class="text-sm text-blue-600">{{ __('Définissez un montant à atteindre et une date limite pour vos projets d\'épargne.') }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2">{{ __('Suivi de progression') }}</h4>
                            <p class="text-sm text-green-600">{{ __('Visualisez votre progression et recevez des suggestions pour atteindre vos objectifs.') }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-2">{{ __('Célébration des succès') }}</h4>
                            <p class="text-sm text-purple-600">{{ __('Recevez des notifications lorsque vous atteignez vos objectifs d\'épargne.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Objectifs actifs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Objectifs en cours') }}</h3>
                    @if($activeGoals->isEmpty())
                        <p class="text-center text-gray-500 py-4">{{ __('Aucun objectif d\'épargne actif.') }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($activeGoals as $goal)
                                <div class="border rounded-lg p-4 {{ $goal->color ? 'border-l-4 border-l-['.$goal->color.']' : '' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $goal->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $goal->account->name }}</p>
                                        </div>
                                        @if($goal->icon)
                                            <span class="text-2xl">{{ $goal->icon }}</span>
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <div>
                                            <div class="flex justify-between text-sm mb-1">
                                                <span class="text-gray-600">{{ __('Progression') }}</span>
                                                <span class="font-medium">{{ number_format($goal->getProgressPercentage(), 1) }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="h-2 rounded-full bg-blue-600" style="width: {{ $goal->getProgressPercentage() }}%"></div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <span class="text-gray-600">{{ __('Actuel') }}</span>
                                                <div class="font-medium">{{ $goal->currency->symbol }} {{ number_format($goal->current_amount, 2) }}</div>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">{{ __('Objectif') }}</span>
                                                <div class="font-medium">{{ $goal->currency->symbol }} {{ number_format($goal->target_amount, 2) }}</div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <span class="text-gray-600">{{ __('Jours restants') }}</span>
                                                <div class="font-medium">{{ $goal->getDaysRemaining() }}</div>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">{{ __('Mensuel suggéré') }}</span>
                                                <div class="font-medium">{{ $goal->currency->symbol }} {{ number_format($goal->getMonthlyTargetAmount(), 2) }}</div>
                                            </div>
                                        </div>

                                        <div class="pt-4 flex justify-end space-x-2">
                                            <a href="{{ route('savings-goals.show', $goal) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ __('Détails') }}
                                            </a>
                                            <a href="{{ route('savings-goals.edit', $goal) }}" class="text-gray-600 hover:text-gray-800">
                                                {{ __('Modifier') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Objectifs complétés -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Objectifs atteints') }}</h3>
                    @if($completedGoals->isEmpty())
                        <p class="text-center text-gray-500 py-4">{{ __('Aucun objectif d\'épargne complété.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nom') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Montant') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Compte') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date de complétion') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($completedGoals as $goal)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($goal->icon)
                                                        <span class="text-xl mr-2">{{ $goal->icon }}</span>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ $goal->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $goal->currency->symbol }} {{ number_format($goal->target_amount, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $goal->account->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $goal->completed_at->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 