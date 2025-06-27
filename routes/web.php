<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\RecurringTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EnergyMeterController;
use App\Http\Controllers\EnergyReadingController;
use App\Http\Controllers\EnergyProviderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestion des comptes
    Route::resource('accounts', AccountController::class);

    // Gestion des catégories
    Route::resource('categories', CategoryController::class);

    // Gestion des devises
    Route::resource('currencies', CurrencyController::class);

    // Transactions
    Route::resource('transactions', TransactionController::class);

    // Budgets
    Route::resource('budgets', BudgetController::class);

    // Transactions récurrentes
    Route::resource('recurring-transactions', RecurringTransactionController::class);
    Route::post('recurring-transactions/{recurringTransaction}/generate', [RecurringTransactionController::class, 'generate'])
        ->name('recurring-transactions.generate');

    // Rapports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
        Route::get('/by-category', [ReportController::class, 'byCategory'])->name('by-category');
        Route::get('/balance-evolution', [ReportController::class, 'balanceEvolution'])->name('balance-evolution');
        Route::get('/predictions', [ReportController::class, 'predictions'])->name('predictions');
    });

    // Routes pour les objectifs d'épargne
    Route::resource('savings-goals', SavingsGoalController::class);
    Route::post('savings-goals/{savingsGoal}/add-progress', [SavingsGoalController::class, 'addProgress'])
        ->name('savings-goals.add-progress');

    // Routes pour les crédits
    Route::resource('credits', CreditController::class);
    Route::post('credits/{credit}/mark-completed', [CreditController::class, 'markAsCompleted'])
        ->name('credits.mark-completed');
    Route::post('credits/calculate', [CreditController::class, 'calculate'])
        ->name('credits.calculate');

    // Routes pour les notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::get('/unread', [NotificationController::class, 'getUnread'])->name('unread');
    });

    // Routes pour les compteurs d'énergie
    Route::resource('energy-meters', EnergyMeterController::class);
    Route::post('energy-meters/{energyMeter}/toggle-active', [EnergyMeterController::class, 'toggleActive'])
        ->name('energy-meters.toggle-active');

    // Routes pour les relevés de compteurs d'énergie
    Route::resource('energy-readings', EnergyReadingController::class);
    Route::get('energy-meters/{energyMeter}/readings', [EnergyReadingController::class, 'meterReadings'])
        ->name('energy-meters.readings');

    // Routes pour les fournisseurs d'énergie
    Route::resource('energy-providers', EnergyProviderController::class);
    Route::post('energy-providers/{energyProvider}/toggle-active', [EnergyProviderController::class, 'toggleActive'])
        ->name('energy-providers.toggle-active');
    Route::get('energy-providers/{energyProvider}/tariffs', [EnergyProviderController::class, 'tariffs'])
        ->name('energy-providers.tariffs');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
