<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le crédit') }} : {{ $credit->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('credits.update', $credit) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informations de base -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Informations du crédit') }}</h3>
                                
                                <div>
                                    <x-input-label for="name" :value="__('Nom du crédit')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $credit->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-textarea-input id="description" name="description" class="mt-1 block w-full" :value="old('description', $credit->description)" />
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="amount" :value="__('Montant emprunté')" />
                                    <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('amount', $credit->amount)" required />
                                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="interest_rate" :value="__('Taux d\'intérêt annuel (%)')" />
                                    <x-text-input id="interest_rate" name="interest_rate" type="number" step="0.01" class="mt-1 block w-full" :value="old('interest_rate', $credit->interest_rate)" required />
                                    <x-input-error :messages="$errors->get('interest_rate')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="duration_months" :value="__('Durée (mois)')" />
                                    <x-text-input id="duration_months" name="duration_months" type="number" class="mt-1 block w-full" :value="old('duration_months', $credit->duration_months)" required />
                                    <x-input-error :messages="$errors->get('duration_months')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="start_date" :value="__('Date de début')" />
                                    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', $credit->start_date->format('Y-m-d'))" required />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="account_id" :value="__('Compte')" />
                                    <select id="account_id" name="account_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">{{ __('Sélectionner un compte') }}</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ old('account_id', $credit->account_id) == $account->id ? 'selected' : '' }}>
                                                {{ $account->name }} ({{ $account->currency->symbol }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="currency_id" :value="__('Devise')" />
                                    <select id="currency_id" name="currency_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">{{ __('Sélectionner une devise') }}</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ old('currency_id', $credit->currency_id) == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->name }} ({{ $currency->symbol }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('currency_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="status" :value="__('Statut')" />
                                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="active" {{ old('status', $credit->status) == 'active' ? 'selected' : '' }}>{{ __('Actif') }}</option>
                                        <option value="completed" {{ old('status', $credit->status) == 'completed' ? 'selected' : '' }}>{{ __('Terminé') }}</option>
                                        <option value="defaulted" {{ old('status', $credit->status) == 'defaulted' ? 'selected' : '' }}>{{ __('En défaut') }}</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Calculs en temps réel -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Calculs automatiques') }}</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('Date de fin') }}</label>
                                        <div id="end_date" class="mt-1 text-lg font-semibold text-gray-900">{{ $credit->end_date->format('d/m/Y') }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('Mensualité') }}</label>
                                        <div id="monthly_payment" class="mt-1 text-lg font-semibold text-blue-600">{{ $credit->currency->symbol }} {{ number_format($credit->monthly_payment, 2) }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('Intérêts totaux') }}</label>
                                        <div id="total_interest" class="mt-1 text-lg font-semibold text-red-600">{{ $credit->currency->symbol }} {{ number_format($credit->total_interest, 2) }}</div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('Montant total à rembourser') }}</label>
                                        <div id="total_amount" class="mt-1 text-lg font-semibold text-green-600">{{ $credit->currency->symbol }} {{ number_format($credit->total_amount, 2) }}</div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 rounded-lg p-4">
                                    <h4 class="font-medium text-blue-800 mb-2">{{ __('Informations importantes') }}</h4>
                                    <ul class="text-sm text-blue-700 space-y-1">
                                        <li>• {{ __('Les calculs sont basés sur un remboursement mensuel constant') }}</li>
                                        <li>• {{ __('Le taux d\'intérêt est annualisé') }}</li>
                                        <li>• {{ __('Les montants sont recalculés automatiquement') }}</li>
                                        <li>• {{ __('Modifier les paramètres recalculera tous les montants') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Annuler') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Mettre à jour le crédit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function calculateCredit() {
            const amount = document.getElementById('amount').value;
            const interestRate = document.getElementById('interest_rate').value;
            const durationMonths = document.getElementById('duration_months').value;
            const startDate = document.getElementById('start_date').value;

            if (amount && interestRate && durationMonths && startDate) {
                fetch('{{ route("credits.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        amount: amount,
                        interest_rate: interestRate,
                        duration_months: durationMonths,
                        start_date: startDate
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('end_date').textContent = data.end_date;
                    document.getElementById('monthly_payment').textContent = data.monthly_payment;
                    document.getElementById('total_interest').textContent = data.total_interest;
                    document.getElementById('total_amount').textContent = data.total_amount;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            }
        }

        // Écouter les changements sur les champs de calcul
        document.getElementById('amount').addEventListener('input', calculateCredit);
        document.getElementById('interest_rate').addEventListener('input', calculateCredit);
        document.getElementById('duration_months').addEventListener('input', calculateCredit);
        document.getElementById('start_date').addEventListener('change', calculateCredit);
    </script>
    @endpush
</x-app-layout> 