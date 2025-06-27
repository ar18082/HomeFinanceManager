<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des crédits') }}
            </h2>
            <a href="{{ route('credits.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Nouveau crédit') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Résumé de la fonctionnalité -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Gestion des crédits') }}</h3>
                    <p class="text-gray-600 mb-4">
                        {{ __('Suivez tous vos crédits et emprunts en un seul endroit. Visualisez vos mensualités, le solde restant et la progression de vos remboursements.') }}
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2">{{ __('Crédits actifs') }}</h4>
                            <p class="text-sm text-blue-600">{{ __('Suivez vos crédits en cours avec les mensualités et échéances.') }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2">{{ __('Progression') }}</h4>
                            <p class="text-sm text-green-600">{{ __('Visualisez votre progression de remboursement pour chaque crédit.') }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <h4 class="font-medium text-purple-800 mb-2">{{ __('Calculs automatiques') }}</h4>
                            <p class="text-sm text-purple-600">{{ __('Calculs automatiques des intérêts, mensualités et solde restant.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des crédits -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($credits->isEmpty())
                        <p class="text-center text-gray-500">{{ __('Aucun crédit trouvé.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nom') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Montant') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Mensualité') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Solde restant') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Progression') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Statut') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($credits as $credit)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $credit->name }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($credit->description, 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $credit->currency->symbol }} {{ number_format($credit->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $credit->currency->symbol }} {{ number_format($credit->monthly_payment, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $credit->currency->symbol }} {{ number_format($credit->remaining_balance, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $credit->getProgressPercentage() }}%"></div>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">{{ number_format($credit->getProgressPercentage(), 1) }}%</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($credit->status === 'active') bg-green-100 text-green-800
                                                    @elseif($credit->status === 'completed') bg-blue-100 text-blue-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ __($credit->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('credits.show', $credit) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    {{ __('Voir') }}
                                                </a>
                                                <a href="{{ route('credits.edit', $credit) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    {{ __('Modifier') }}
                                                </a>
                                                <form action="{{ route('credits.destroy', $credit) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce crédit ?') }}')">
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
                            {{ $credits->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 