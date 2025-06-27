<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();
        return view('currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default' => 'boolean'
        ]);

        // Si cette devise est définie par défaut, mettre toutes les autres à false
        if ($validated['is_default'] ?? false) {
            Currency::where('is_default', true)->update(['is_default' => false]);
        }

        Currency::create($validated);

        return redirect()->route('currencies.index')
            ->with('success', 'Devise créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return view('currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'size:3', Rule::unique('currencies')->ignore($currency)],
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default' => 'boolean'
        ]);

        // Si cette devise est définie par défaut, mettre toutes les autres à false
        if ($validated['is_default'] ?? false) {
            Currency::where('id', '!=', $currency->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        $currency->update($validated);

        return redirect()->route('currencies.index')
            ->with('success', 'Devise mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        // Empêcher la suppression de la devise par défaut
        if ($currency->is_default) {
            return redirect()->route('currencies.index')
                ->with('error', 'Impossible de supprimer la devise par défaut.');
        }

        // Vérifier si la devise est utilisée
        if ($currency->accounts()->exists() || $currency->transactions()->exists() || $currency->budgets()->exists()) {
            return redirect()->route('currencies.index')
                ->with('error', 'Cette devise est utilisée et ne peut pas être supprimée.');
        }

        $currency->delete();

        return redirect()->route('currencies.index')
            ->with('success', 'Devise supprimée avec succès.');
    }
} 