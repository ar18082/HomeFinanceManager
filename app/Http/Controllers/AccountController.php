<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Auth::user()
            ->accounts()
            ->with('currency')
            ->withCount('transactions')
            ->get()
            ->groupBy('type');

        $totalsByType = $accounts->mapWithKeys(function ($accounts, $type) {
            return [$type => $accounts->sum('current_balance')];
        });

        return view('accounts.index', compact('accounts', 'totalsByType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencies = Currency::all();
        return view('accounts.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(Account::TYPES)],
            'currency_id' => 'required|exists:currencies,id',
            'initial_balance' => 'required|numeric',
            'description' => 'nullable|string',
            'include_in_net_worth' => 'boolean',
            'active' => 'boolean'
        ]);

        // Le solde initial devient le solde courant
        $validated['current_balance'] = $validated['initial_balance'];

        Auth::user()->accounts()->create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Compte créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        $this->authorize('view', $account);

        $account->load(['currency', 'transactions' => function ($query) {
            $query->with(['category', 'tags'])
                ->latest('date')
                ->limit(10);
        }]);

        return view('accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        $this->authorize('update', $account);

        $currencies = Currency::all();
        return view('accounts.edit', compact('account', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(Account::TYPES)],
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'nullable|string',
            'include_in_net_worth' => 'boolean',
            'active' => 'boolean'
        ]);

        $account->update($validated);

        return redirect()->route('accounts.show', $account)
            ->with('success', 'Compte mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);

        // Vérifier si le compte a des transactions
        if ($account->transactions()->exists()) {
            return redirect()->route('accounts.index')
                ->with('error', 'Ce compte contient des transactions et ne peut pas être supprimé.');
        }

        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Compte supprimé avec succès.');
    }
}
