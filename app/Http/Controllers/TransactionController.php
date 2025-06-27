<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Category;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Auth::user()
            ->transactions()
            ->with(['account', 'category', 'currency', 'tags'])
            ->latest('date')
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Auth::user()->accounts()->active()->get();
        $categories = Auth::user()->categories()->active()->get();
        $currencies = Currency::all();
        $tags = Auth::user()->tags;

        return view('transactions.create', compact('accounts', 'categories', 'currencies', 'tags'));
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
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense,transfer',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        DB::transaction(function () use ($validated, $request) {
            $transaction = Auth::user()->transactions()->create($validated);

            if ($request->has('tags')) {
                $transaction->tags()->attach($request->tags);
            }

            // Mise à jour du solde du compte
            $account = Account::findOrFail($validated['account_id']);
            if ($validated['type'] === 'income') {
                $account->current_balance += $validated['amount'];
            } elseif ($validated['type'] === 'expense') {
                $account->current_balance -= $validated['amount'];
            }
            $account->save();
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        
        $transaction->load(['account', 'category', 'currency', 'tags']);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $accounts = Auth::user()->accounts()->active()->get();
        $categories = Auth::user()->categories()->active()->get();
        $currencies = Currency::all();
        $tags = Auth::user()->tags;

        return view('transactions.edit', compact('transaction', 'accounts', 'categories', 'currencies', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'nullable|exists:categories,id',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense,transfer',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        DB::transaction(function () use ($validated, $request, $transaction) {
            // Annuler l'effet de l'ancienne transaction sur le solde
            $oldAccount = Account::findOrFail($transaction->account_id);
            if ($transaction->type === 'income') {
                $oldAccount->current_balance -= $transaction->amount;
            } elseif ($transaction->type === 'expense') {
                $oldAccount->current_balance += $transaction->amount;
            }
            $oldAccount->save();

            // Appliquer la nouvelle transaction
            $transaction->update($validated);

            // Mettre à jour les tags
            if ($request->has('tags')) {
                $transaction->tags()->sync($request->tags);
            }

            // Appliquer l'effet de la nouvelle transaction sur le solde
            $newAccount = Account::findOrFail($validated['account_id']);
            if ($validated['type'] === 'income') {
                $newAccount->current_balance += $validated['amount'];
            } elseif ($validated['type'] === 'expense') {
                $newAccount->current_balance -= $validated['amount'];
            }
            $newAccount->save();
        });

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaction mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        DB::transaction(function () use ($transaction) {
            // Annuler l'effet de la transaction sur le solde
            $account = Account::findOrFail($transaction->account_id);
            if ($transaction->type === 'income') {
                $account->current_balance -= $transaction->amount;
            } elseif ($transaction->type === 'expense') {
                $account->current_balance += $transaction->amount;
            }
            $account->save();

            $transaction->delete();
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction supprimée avec succès.');
    }
}
