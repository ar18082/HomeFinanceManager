<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingsGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeGoals = Auth::user()
            ->savingsGoals()
            ->active()
            ->with(['account', 'currency'])
            ->latest()
            ->get();

        $completedGoals = Auth::user()
            ->savingsGoals()
            ->completed()
            ->with(['account', 'currency'])
            ->latest()
            ->take(5)
            ->get();

        return view('savings-goals.index', compact('activeGoals', 'completedGoals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Auth::user()->accounts()->active()->get();
        $currencies = Currency::all();

        return view('savings-goals.create', compact('accounts', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'currency_id' => 'required|exists:currencies,id',
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'target_date' => 'required|date|after:today',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $savingsGoal = Auth::user()->savingsGoals()->create($validated);

        return redirect()->route('savings-goals.show', $savingsGoal)
            ->with('success', 'Objectif d\'épargne créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SavingsGoal $savingsGoal)
    {
        $this->authorize('view', $savingsGoal);
        
        $savingsGoal->load(['account', 'currency']);

        // Récupérer les transactions liées à cet objectif d'épargne
        $transactions = $savingsGoal->account
            ->transactions()
            ->where('type', 'income')
            ->whereBetween('date', [$savingsGoal->created_at, now()])
            ->latest()
            ->limit(10)
            ->get();

        return view('savings-goals.show', compact('savingsGoal', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);

        $accounts = Auth::user()->accounts()->active()->get();
        $currencies = Currency::all();

        return view('savings-goals.edit', compact('savingsGoal', 'accounts', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'currency_id' => 'required|exists:currencies,id',
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'target_date' => 'required|date|after:today',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $savingsGoal->update($validated);
        $savingsGoal->checkAndUpdateCompletion();

        return redirect()->route('savings-goals.show', $savingsGoal)
            ->with('success', 'Objectif d\'épargne mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavingsGoal $savingsGoal)
    {
        $this->authorize('delete', $savingsGoal);

        $savingsGoal->delete();

        return redirect()->route('savings-goals.index')
            ->with('success', 'Objectif d\'épargne supprimé avec succès.');
    }

    /**
     * Add progress to a savings goal.
     */
    public function addProgress(Request $request, SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        if ($savingsGoal->addProgress($validated['amount'])) {
            return redirect()->route('savings-goals.show', $savingsGoal)
                ->with('success', 'Félicitations ! Votre objectif d\'épargne a été atteint !');
        }

        return redirect()->route('savings-goals.show', $savingsGoal)
            ->with('success', 'Progression ajoutée avec succès.');
    }
}
