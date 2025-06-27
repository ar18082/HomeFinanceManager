<?php

namespace App\Console\Commands;

use App\Models\Credit;
use App\Models\Transaction;
use App\Notifications\CreditPaymentNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GenerateCreditPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-credit-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les paiements de crédit mensuels et envoie les notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de la génération des paiements de crédit...');

        try {
            $activeCredits = Credit::active()->get();
            $count = 0;

            foreach ($activeCredits as $credit) {
                // Vérifier si le paiement du mois courant a déjà été effectué
                $currentMonth = Carbon::now()->startOfMonth();
                $existingPayment = Transaction::where('user_id', $credit->user_id)
                    ->where('description', 'Paiement mensuel - ' . $credit->name)
                    ->where('date', '>=', $currentMonth)
                    ->where('date', '<', $currentMonth->copy()->addMonth())
                    ->first();

                if (!$existingPayment && $credit->monthly_payment > 0) {
                    // Créer la transaction de paiement
                    $transaction = Transaction::create([
                        'user_id' => $credit->user_id,
                        'account_id' => $credit->account_id,
                        'category_id' => $this->getCreditCategoryId($credit->user_id),
                        'currency_id' => $credit->currency_id,
                        'type' => 'expense',
                        'amount' => $credit->monthly_payment,
                        'description' => 'Paiement mensuel - ' . $credit->name,
                        'date' => now(),
                    ]);

                    // Mettre à jour le solde restant du crédit
                    $credit->calculateRemainingBalance();
                    $credit->save();

                    // Envoyer la notification
                    $credit->user->notify(new CreditPaymentNotification($credit, $transaction));

                    $count++;
                    $this->line("Paiement généré pour le crédit : {$credit->name} ({$credit->monthly_payment})");
                }
            }

            $this->info("{$count} paiement(s) de crédit généré(s) avec succès.");
            Log::info("{$count} paiement(s) de crédit généré(s).");
        } catch (\Exception $e) {
            $this->error('Une erreur est survenue lors de la génération des paiements de crédit.');
            Log::error('Erreur lors de la génération des paiements de crédit : ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Obtenir l'ID de la catégorie "Crédits" pour l'utilisateur
     */
    private function getCreditCategoryId($userId)
    {
        // Chercher une catégorie "Crédits" existante
        $creditCategory = \App\Models\Category::where('user_id', $userId)
            ->where('name', 'Crédits')
            ->first();

        if (!$creditCategory) {
            // Créer la catégorie si elle n'existe pas
            $creditCategory = \App\Models\Category::create([
                'user_id' => $userId,
                'name' => 'Crédits',
                'type' => 'expense',
                'color' => '#dc2626', // Rouge
                'icon' => 'credit-card',
            ]);
        }

        return $creditCategory->id;
    }
} 