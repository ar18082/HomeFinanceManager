<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Budgets') }}
            </h2>
            <a href="{{ route('budgets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Nouveau budget') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Gestion des budgets') }}</h3>
                    <p class="text-gray-600 mb-4">
                        {{ __('Les budgets vous permettent de suivre et contrôler vos dépenses par catégorie. Définissez des limites mensuelles, annuelles ou personnalisées pour chaque catégorie de dépenses et suivez votre progression en temps réel.') }}
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2">{{ __('Création de budget') }}</h4>
                            <p class="text-sm text-blue-600">{{ __('Définissez un montant maximum pour une catégorie spécifique sur une période donnée.') }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2">{{ __('Suivi des dépenses') }}</h4>
                            <p class="text-sm text-green-600">{{ __('Visualisez la progression de vos dépenses par rapport aux limites fixées.') }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-2">{{ __('Alertes et notifications') }}</h4>
                            <p class="text-sm text-purple-600">{{ __('Recevez des alertes visuelles lorsque vous approchez ou dépassez vos limites budgétaires.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des budgets -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($budgets->isEmpty())
                        <p class="text-center text-gray-500">{{ __('Aucun budget trouvé.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($budgets as $budget)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $budget->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $budget->category->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $budget->currency->symbol }} {{ number_format($budget->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($budget->period === 'monthly')
                                                    {{ __('Mensuel') }}
                                                @elseif($budget->period === 'yearly')
                                                    {{ __('Annuel') }}
                                                @else
                                                    {{ __('Personnalisé') }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $expenses = Auth::user()
                                                        ->transactions()
                                                        ->where('category_id', $budget->category_id)
                                                        ->where('type', 'expense')
                                                        ->whereBetween('date', [$budget->start_date, $budget->end_date ?? now()])
                                                        ->sum('amount');
                                                    $percentage = $budget->amount > 0 ? ($expenses / $budget->amount) * 100 : 0;
                                                @endphp
                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                    <div class="h-2.5 rounded-full {{ $percentage > 100 ? 'bg-red-600' : ($percentage > 80 ? 'bg-yellow-400' : 'bg-green-600') }}"
                                                         style="width: {{ min($percentage, 100) }}%"></div>
                                                </div>
                                                <span class="text-xs {{ $percentage > 100 ? 'text-red-600' : ($percentage > 80 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ number_format($percentage, 1) }}%
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $budget->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $budget->active ? __('Actif') : __('Inactif') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('budgets.show', $budget) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    {{ __('Voir') }}
                                                </a>
                                                <a href="{{ route('budgets.edit', $budget) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    {{ __('Modifier') }}
                                                </a>
                                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce budget ?') }}')">
                                                        {{ __('Supprimer') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $budgets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 