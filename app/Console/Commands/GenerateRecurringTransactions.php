<?php

namespace App\Console\Commands;

use App\Models\RecurringTransaction;
use App\Notifications\RecurringTransactionNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-recurring-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les transactions récurrentes dues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de la génération des transactions récurrentes...');

        try {
            $recurringTransactions = RecurringTransaction::due()->get();
            $count = 0;

            foreach ($recurringTransactions as $recurringTransaction) {
                if ($transaction = $recurringTransaction->generateTransaction()) {
                    // Envoyer la notification
                    $recurringTransaction->user->notify(new RecurringTransactionNotification($recurringTransaction, $transaction));
                    
                    $count++;
                    $this->line("Transaction générée : {$transaction->description} ({$transaction->amount})");
                }
            }

            $this->info("{$count} transaction(s) générée(s) avec succès.");
            Log::info("{$count} transaction(s) récurrente(s) générée(s).");
        } catch (\Exception $e) {
            $this->error('Une erreur est survenue lors de la génération des transactions récurrentes.');
            Log::error('Erreur lors de la génération des transactions récurrentes : ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
} 