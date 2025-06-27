<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Génération des transactions récurrentes
        $schedule->command('app:generate-recurring-transactions')
            ->daily()
            ->at('00:01')
            ->withoutOverlapping();

        // Génération des paiements de crédit (le 1er du mois à 00:05)
        $schedule->command('app:generate-credit-payments')
            ->monthly()
            ->at('00:05')
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
