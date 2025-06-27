<?php

namespace App\Http\Controllers;

use App\Models\RecurringTransaction;
use App\Models\Account;
use App\Models\Category;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecurringTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recurringTransactions = Auth::user()
            ->recurringTransactions()
            ->with(['account', 'category', 'currency', 'destinationAccount'])
            ->latest()
            ->paginate(10);

        return view('recurring-transactions.index', compact('recurringTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Auth::user()->accounts()->active()->get();
        $categories = Auth::user()->categories()->active()->get();
        $currencies = Currency::all();

        return view('recurring-transactions.create', compact('accounts', 'categories', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'currency_id' => 'required|exists:currencies,id',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
            'interval' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'times_to_run' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'destination_account_id' => 'required_if:type,transfer|exists:accounts,id',
            'active' => 'boolean'
        ]);

        $recurringTransaction = Auth::user()->recurringTransactions()->create($validated);

        return redirect()->route('recurring-transactions.show', $recurringTransaction)
            ->with('success', 'Transaction récurrente créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RecurringTransaction $recurringTransaction)
    {
        $this->authorize('view', $recurringTransaction);
        
        $recurringTransaction->load(['account', 'category', 'currency', 'destinationAccount']);
        
        // Récupérer les 5 dernières transactions générées
        $transactions = $recurringTransaction->transactions()
            ->with(['account', 'category', 'currency'])
            ->latest()
            ->limit(5)
            ->get();

        return view('recurring-transactions.show', compact('recurringTransaction', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecurringTransaction $recurringTransaction)
    {
        $this->authorize('update', $recurringTransaction);

        $accounts = Auth::user()->accounts()->active()->get();
        $categories = Auth::user()->categories()->active()->get();
        $currencies = Currency::all();

        return view('recurring-transactions.edit', compact('recurringTransaction', 'accounts', 'categories', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecurringTransaction $recurringTransaction)
    {
        $this->authorize('update', $recurringTransaction);

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'currency_id' => 'required|exists:currencies,id',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
            'interval' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'times_to_run' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'destination_account_id' => 'required_if:type,transfer|exists:accounts,id',
            'active' => 'boolean'
        ]);

        $recurringTransaction->update($validated);

        return redirect()->route('recurring-transactions.show', $recurringTransaction)
            ->with('success', 'Transaction récurrente mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecurringTransaction $recurringTransaction)
    {
        $this->authorize('delete', $recurringTransaction);

        $recurringTransaction->delete();

        return redirect()->route('recurring-transactions.index')
            ->with('success', 'Transaction récurrente supprimée avec succès.');
    }

    /**
     * Generate a transaction manually.
     */
    public function generate(RecurringTransaction $recurringTransaction)
    {
        $this->authorize('update', $recurringTransaction);

        if ($transaction = $recurringTransaction->generateTransaction()) {
            return redirect()->route('recurring-transactions.show', $recurringTransaction)
                ->with('success', 'Transaction générée avec succès.');
        }

        return redirect()->route('recurring-transactions.show', $recurringTransaction)
            ->with('error', 'Impossible de générer la transaction pour le moment.');
    }
} 