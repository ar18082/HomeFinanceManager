<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class CreditController extends Controller
{
    /**
     * Afficher la liste des crédits
     */
    public function index(): View
    {
        $credits = auth()->user()->credits()->with(['account', 'currency'])->latest()->paginate(10);
        
        return view('credits.index', compact('credits'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create(): View
    {
        $accounts = auth()->user()->accounts()->get();
        $currencies = Currency::all();
        
        return view('credits.create', compact('accounts', 'currencies'));
    }

    /**
     * Stocker un nouveau crédit
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'duration_months' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        $credit = new Credit($validated);
        $credit->user_id = auth()->id();
        $credit->start_date = Carbon::parse($validated['start_date']);
        
        // Calculer tous les montants
        $credit->calculateAllAmounts();
        
        $credit->save();

        return redirect()->route('credits.index')
            ->with('success', 'Crédit créé avec succès.');
    }

    /**
     * Afficher un crédit spécifique
     */
    public function show(Credit $credit): View
    {
        $this->authorize('view', $credit);
        
        // Recalculer les montants pour avoir les données à jour
        $credit->calculateAllAmounts();
        $credit->save();
        
        return view('credits.show', compact('credit'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Credit $credit): View
    {
        $this->authorize('update', $credit);
        
        $accounts = auth()->user()->accounts()->get();
        $currencies = Currency::all();
        
        return view('credits.edit', compact('credit', 'accounts', 'currencies'));
    }

    /**
     * Mettre à jour un crédit
     */
    public function update(Request $request, Credit $credit): RedirectResponse
    {
        $this->authorize('update', $credit);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'duration_months' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'currency_id' => 'required|exists:currencies,id',
            'status' => 'required|in:active,completed,defaulted',
        ]);

        $credit->fill($validated);
        $credit->start_date = Carbon::parse($validated['start_date']);
        
        // Recalculer tous les montants
        $credit->calculateAllAmounts();
        
        $credit->save();

        return redirect()->route('credits.show', $credit)
            ->with('success', 'Crédit mis à jour avec succès.');
    }

    /**
     * Supprimer un crédit
     */
    public function destroy(Credit $credit): RedirectResponse
    {
        $this->authorize('delete', $credit);
        
        $credit->delete();

        return redirect()->route('credits.index')
            ->with('success', 'Crédit supprimé avec succès.');
    }

    /**
     * Marquer un crédit comme terminé
     */
    public function markAsCompleted(Credit $credit): RedirectResponse
    {
        $this->authorize('update', $credit);
        
        $credit->status = 'completed';
        $credit->remaining_balance = 0;
        $credit->save();

        return redirect()->route('credits.show', $credit)
            ->with('success', 'Crédit marqué comme terminé.');
    }

    /**
     * Calculer les montants en temps réel (AJAX)
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'duration_months' => 'required|integer|min:1',
            'start_date' => 'required|date',
        ]);

        $credit = new Credit($validated);
        $credit->start_date = Carbon::parse($validated['start_date']);
        $credit->calculateAllAmounts();

        return response()->json([
            'monthly_payment' => number_format($credit->monthly_payment, 2),
            'total_interest' => number_format($credit->total_interest, 2),
            'total_amount' => number_format($credit->total_amount, 2),
            'end_date' => $credit->end_date->format('d/m/Y'),
        ]);
    }
} 