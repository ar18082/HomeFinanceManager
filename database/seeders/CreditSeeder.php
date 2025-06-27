<?php

namespace Database\Seeders;

use App\Models\Credit;
use App\Models\User;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CreditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $account = Account::where('user_id', $user->id)->first();
        $currency = Currency::first();

        if (!$user || !$account || !$currency) {
            return;
        }

        $credits = [
            [
                'name' => 'Crédit immobilier',
                'description' => 'Prêt pour l\'achat de notre maison principale',
                'amount' => 250000,
                'interest_rate' => 2.5,
                'duration_months' => 240, // 20 ans
                'start_date' => Carbon::now()->subMonths(12),
                'account_id' => $account->id,
                'currency_id' => $currency->id,
            ],
            [
                'name' => 'Crédit automobile',
                'description' => 'Prêt pour l\'achat d\'une voiture',
                'amount' => 15000,
                'interest_rate' => 4.2,
                'duration_months' => 60, // 5 ans
                'start_date' => Carbon::now()->subMonths(6),
                'account_id' => $account->id,
                'currency_id' => $currency->id,
            ],
            [
                'name' => 'Crédit travaux',
                'description' => 'Prêt pour rénovation de la cuisine',
                'amount' => 8000,
                'interest_rate' => 3.8,
                'duration_months' => 36, // 3 ans
                'start_date' => Carbon::now()->subMonths(3),
                'account_id' => $account->id,
                'currency_id' => $currency->id,
            ],
        ];

        foreach ($credits as $creditData) {
            $credit = new Credit($creditData);
            $credit->user_id = $user->id;
            $credit->calculateAllAmounts();
            $credit->save();
        }
    }
} 