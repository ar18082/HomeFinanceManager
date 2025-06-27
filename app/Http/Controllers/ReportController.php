<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use App\Models\RecurringTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Affiche la page d'accueil des rapports avec un résumé
     */
    public function index()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->startOfMonth();

        // Statistiques du mois en cours
        $monthlyStats = $this->getMonthlyStats($currentMonth);

        // Évolution du solde sur les 6 derniers mois
        $balanceHistory = $this->getBalanceHistory(6);

        // Top 5 des catégories de dépenses du mois
        $topExpenseCategories = $this->getTopExpenseCategories($currentMonth);

        // Prévisions pour le mois prochain basées sur les transactions récurrentes
        $nextMonthPredictions = $this->getNextMonthPredictions();

        return view('reports.index', compact(
            'monthlyStats',
            'balanceHistory',
            'topExpenseCategories',
            'nextMonthPredictions'
        ));
    }

    /**
     * Affiche le rapport mensuel détaillé
     */
    public function monthly(Request $request)
    {
        $date = $request->input('date') 
            ? Carbon::createFromFormat('Y-m', $request->input('date'))->startOfMonth()
            : Carbon::now()->startOfMonth();

        $stats = $this->getMonthlyStats($date);
        $dailyBalance = $this->getDailyBalance($date);
        $categoryBreakdown = $this->getCategoryBreakdown($date);
        $largestTransactions = $this->getLargestTransactions($date);

        return view('reports.monthly', compact(
            'date',
            'stats',
            'dailyBalance',
            'categoryBreakdown',
            'largestTransactions'
        ));
    }

    /**
     * Affiche le rapport par catégorie
     */
    public function byCategory(Request $request)
    {
        $startDate = $request->input('start_date')
            ? Carbon::createFromFormat('Y-m-d', $request->input('start_date'))
            : Carbon::now()->subMonths(6)->startOfMonth();
        
        $endDate = $request->input('end_date')
            ? Carbon::createFromFormat('Y-m-d', $request->input('end_date'))
            : Carbon::now()->endOfMonth();

        $categoryStats = $this->getCategoryStats($startDate, $endDate);
        $categoryTrends = $this->getCategoryTrends($startDate, $endDate);

        return view('reports.by-category', compact(
            'startDate',
            'endDate',
            'categoryStats',
            'categoryTrends'
        ));
    }

    /**
     * Affiche le rapport d'évolution des soldes
     */
    public function balanceEvolution(Request $request)
    {
        $period = $request->input('period', '12'); // Nombre de mois par défaut
        $accounts = Auth::user()->accounts()->with('currency')->get();
        $balanceHistory = $this->getDetailedBalanceHistory($period);

        return view('reports.balance-evolution', compact('period', 'accounts', 'balanceHistory'));
    }

    /**
     * Affiche les prévisions financières
     */
    public function predictions()
    {
        $predictions = $this->getDetailedPredictions(3); // Prévisions sur 3 mois
        $recurringImpact = $this->getRecurringTransactionsImpact();

        return view('reports.predictions', compact('predictions', 'recurringImpact'));
    }

    /**
     * Récupère les statistiques mensuelles
     */
    private function getMonthlyStats(Carbon $date)
    {
        $user = Auth::user();
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        return [
            'income' => $user->transactions()
                ->where('type', 'income')
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('amount'),
            
            'expenses' => $user->transactions()
                ->where('type', 'expense')
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('amount'),
            
            'balance' => $user->accounts()
                ->sum('current_balance'),
            
            'transaction_count' => $user->transactions()
                ->whereBetween('date', [$startDate, $endDate])
                ->count(),
            
            'recurring_count' => $user->recurringTransactions()
                ->where('active', true)
                ->count(),
        ];
    }

    /**
     * Récupère l'historique des soldes
     */
    private function getBalanceHistory(int $months)
    {
        $user = Auth::user();
        $startDate = Carbon::now()->subMonths($months)->startOfMonth();

        return $user->transactions()
            ->select(
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expenses')
            )
            ->where('date', '>=', $startDate)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $item->balance = $item->income - $item->expenses;
                return $item;
            });
    }

    /**
     * Récupère les principales catégories de dépenses
     */
    private function getTopExpenseCategories(Carbon $date)
    {
        $user = Auth::user();
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        return $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNotNull('category_id')
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }

    /**
     * Récupère les prévisions pour le mois prochain
     */
    private function getNextMonthPredictions()
    {
        $user = Auth::user();
        $nextMonth = Carbon::now()->addMonth();
        
        // Transactions récurrentes prévues
        $recurringTransactions = $user->recurringTransactions()
            ->where('active', true)
            ->get()
            ->filter(function ($transaction) use ($nextMonth) {
                return $transaction->shouldGenerate() &&
                    (!$transaction->end_date || $transaction->end_date->greaterThan($nextMonth));
            });

        $expectedIncome = $recurringTransactions
            ->where('type', 'income')
            ->sum('amount');

        $expectedExpenses = $recurringTransactions
            ->where('type', 'expense')
            ->sum('amount');

        // Moyennes historiques
        $historicalAverages = $user->transactions()
            ->where('date', '>=', Carbon::now()->subMonths(3))
            ->select(
                'type',
                DB::raw('AVG(amount) as average_amount'),
                DB::raw('COUNT(*) / 3 as monthly_frequency')
            )
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        return [
            'recurring_income' => $expectedIncome,
            'recurring_expenses' => $expectedExpenses,
            'average_income' => $historicalAverages->get('income')?->average_amount ?? 0,
            'average_expenses' => $historicalAverages->get('expense')?->average_amount ?? 0,
            'predicted_balance' => $expectedIncome - $expectedExpenses,
        ];
    }

    /**
     * Récupère le solde quotidien pour un mois donné
     */
    private function getDailyBalance(Carbon $date)
    {
        $user = Auth::user();
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        return $user->transactions()
            ->whereBetween('date', [$startDate, $endDate])
            ->select(
                'date',
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE -amount END) as daily_balance')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Récupère la répartition par catégorie pour un mois donné
     */
    private function getCategoryBreakdown(Carbon $date)
    {
        $user = Auth::user();
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        return $user->transactions()
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNotNull('category_id')
            ->select(
                'category_id',
                'type',
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('category_id', 'type')
            ->with('category')
            ->get()
            ->groupBy('type');
    }

    /**
     * Récupère les plus grandes transactions pour un mois donné
     */
    private function getLargestTransactions(Carbon $date)
    {
        $user = Auth::user();
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        return $user->transactions()
            ->whereBetween('date', [$startDate, $endDate])
            ->with(['category', 'account'])
            ->orderByDesc('amount')
            ->limit(10)
            ->get();
    }

    /**
     * Récupère les statistiques détaillées par catégorie
     */
    private function getCategoryStats(Carbon $startDate, Carbon $endDate)
    {
        $user = Auth::user();

        return $user->transactions()
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNotNull('category_id')
            ->select(
                'category_id',
                'type',
                DB::raw('SUM(amount) as total'),
                DB::raw('AVG(amount) as average'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('category_id', 'type')
            ->with('category')
            ->get()
            ->groupBy('category.name');
    }

    /**
     * Récupère les tendances par catégorie
     */
    private function getCategoryTrends(Carbon $startDate, Carbon $endDate)
    {
        $user = Auth::user();

        return $user->transactions()
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNotNull('category_id')
            ->select(
                'category_id',
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('category_id', 'month')
            ->with('category')
            ->orderBy('month')
            ->get()
            ->groupBy('category.name');
    }

    /**
     * Récupère l'historique détaillé des soldes
     */
    private function getDetailedBalanceHistory(int $months)
    {
        $user = Auth::user();
        $startDate = Carbon::now()->subMonths($months)->startOfMonth();

        return $user->accounts()
            ->with(['transactions' => function ($query) use ($startDate) {
                $query->where('date', '>=', $startDate)
                    ->orderBy('date');
            }])
            ->get()
            ->map(function ($account) use ($startDate) {
                $balanceHistory = collect();
                $currentBalance = $account->current_balance;

                // Remonter dans le temps pour calculer les soldes historiques
                $account->transactions->reverse()->each(function ($transaction) use (&$currentBalance, &$balanceHistory) {
                    if ($transaction->type === 'expense') {
                        $currentBalance += $transaction->amount;
                    } elseif ($transaction->type === 'income') {
                        $currentBalance -= $transaction->amount;
                    }
                    $balanceHistory->push([
                        'date' => $transaction->date->format('Y-m-d'),
                        'balance' => $currentBalance
                    ]);
                });

                return [
                    'account' => $account,
                    'history' => $balanceHistory->reverse()->values()
                ];
            });
    }

    /**
     * Récupère les prévisions détaillées
     */
    private function getDetailedPredictions(int $months)
    {
        $user = Auth::user();
        $predictions = collect();
        $currentDate = Carbon::now();

        for ($i = 1; $i <= $months; $i++) {
            $monthDate = $currentDate->copy()->addMonths($i);
            
            // Transactions récurrentes prévues
            $recurringTransactions = $user->recurringTransactions()
                ->where('active', true)
                ->get()
                ->filter(function ($transaction) use ($monthDate) {
                    return $transaction->shouldGenerate() &&
                        (!$transaction->end_date || $transaction->end_date->greaterThan($monthDate));
                });

            // Calcul des moyennes historiques
            $historicalAverages = $user->transactions()
                ->where('date', '>=', $currentDate->copy()->subMonths(3))
                ->where('date', '<', $currentDate)
                ->whereNull('recurring_transaction_id')
                ->select(
                    'type',
                    DB::raw('AVG(amount) as average_amount'),
                    DB::raw('COUNT(*) / 3 as monthly_frequency')
                )
                ->groupBy('type')
                ->get();

            $predictions->push([
                'month' => $monthDate->format('Y-m'),
                'recurring' => [
                    'income' => $recurringTransactions->where('type', 'income')->sum('amount'),
                    'expenses' => $recurringTransactions->where('type', 'expense')->sum('amount'),
                ],
                'estimated' => [
                    'income' => $historicalAverages->where('type', 'income')->first()?->average_amount ?? 0,
                    'expenses' => $historicalAverages->where('type', 'expense')->first()?->average_amount ?? 0,
                ],
                'transactions' => $recurringTransactions->map(function ($transaction) {
                    return [
                        'description' => $transaction->description,
                        'amount' => $transaction->amount,
                        'type' => $transaction->type,
                        'frequency' => $transaction->frequency,
                    ];
                }),
            ]);
        }

        return $predictions;
    }

    /**
     * Analyse l'impact des transactions récurrentes
     */
    private function getRecurringTransactionsImpact()
    {
        $user = Auth::user();
        $recurringTransactions = $user->recurringTransactions()
            ->where('active', true)
            ->with(['category', 'account'])
            ->get();

        $monthlyImpact = $recurringTransactions->groupBy('frequency')->map(function ($transactions) {
            return $transactions->map(function ($transaction) {
                $monthlyAmount = match($transaction->frequency) {
                    'daily' => $transaction->amount * 30 / $transaction->interval,
                    'weekly' => $transaction->amount * 4 / $transaction->interval,
                    'monthly' => $transaction->amount / $transaction->interval,
                    'yearly' => $transaction->amount / (12 * $transaction->interval),
                };

                return [
                    'description' => $transaction->description,
                    'original_amount' => $transaction->amount,
                    'monthly_amount' => $monthlyAmount,
                    'type' => $transaction->type,
                    'category' => $transaction->category?->name,
                    'account' => $transaction->account->name,
                ];
            });
        });

        return [
            'by_frequency' => $monthlyImpact,
            'total_monthly_income' => $monthlyImpact->flatten(1)
                ->where('type', 'income')
                ->sum('monthly_amount'),
            'total_monthly_expenses' => $monthlyImpact->flatten(1)
                ->where('type', 'expense')
                ->sum('monthly_amount'),
        ];
    }
}
