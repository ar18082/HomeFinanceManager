<?php

namespace App\Http\Controllers;

use App\Models\EnergyProvider;
use App\Models\EnergyTariff;
use Illuminate\Http\Request;

class EnergyProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', EnergyProvider::class);

        $energyProviders = EnergyProvider::withCount(['tariffs', 'tariffs as active_tariffs_count' => function($query) {
            $query->where('active', true);
        }])
        ->orderBy('name')
        ->paginate(10);

        return view('energy-providers.index', compact('energyProviders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('energy-providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', EnergyProvider::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:energy_providers',
            'website' => 'nullable|url|max:255',
            'contact_email' => 'nullable|email|max:255',
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $energyProvider = EnergyProvider::create($validated);

        return redirect()->route('energy-providers.show', $energyProvider)
            ->with('success', 'Fournisseur d\'énergie créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EnergyProvider $energyProvider)
    {
        $this->authorize('view', $energyProvider);

        // Récupérer les tarifs groupés par type
        $tariffs = $energyProvider->tariffs()
            ->orderBy('type')
            ->orderBy('start_date', 'desc')
            ->get()
            ->groupBy('type');

        // Calculer les statistiques
        $statistics = [
            'total_tarifs' => $energyProvider->tariffs()->count(),
            'active_tariffs' => $energyProvider->tariffs()->where('active', true)->count(),
            'electricity_tariffs' => $energyProvider->tariffs()->where('name', 'like', '%électricité%')->count(),
            'gas_tariffs' => $energyProvider->tariffs()->where('name', 'like', '%gaz%')->count(),
        ];

        return view('energy-providers.show', compact('energyProvider', 'tariffs', 'statistics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EnergyProvider $energyProvider)
    {
        $this->authorize('update', $energyProvider);

        return view('energy-providers.edit', compact('energyProvider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EnergyProvider $energyProvider)
    {
        $this->authorize('update', $energyProvider);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:energy_providers,code,' . $energyProvider->id,
            'website' => 'nullable|url|max:255',
            'contact_email' => 'nullable|email|max:255',
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean'
        ]);

        $validated['active'] = $request->has('active');

        $energyProvider->update($validated);

        return redirect()->route('energy-providers.show', $energyProvider)
            ->with('success', 'Fournisseur d\'énergie mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EnergyProvider $energyProvider)
    {
        $this->authorize('delete', $energyProvider);

        // Vérifier s'il y a des tarifs associés
        if ($energyProvider->tariffs()->count() > 0) {
            return back()->withErrors(['error' => 'Impossible de supprimer ce fournisseur car il a des tarifs associés.']);
        }

        $energyProvider->delete();

        return redirect()->route('energy-providers.index')
            ->with('success', 'Fournisseur d\'énergie supprimé avec succès.');
    }

    /**
     * Show tariffs for a specific provider.
     */
    public function tariffs(EnergyProvider $energyProvider)
    {
        $tariffs = $energyProvider->tariffs()
            ->orderBy('type')
            ->orderBy('start_date', 'desc')
            ->paginate(20);

        return view('energy-providers.tariffs', compact('energyProvider', 'tariffs'));
    }

    /**
     * Toggle the active status of the provider.
     */
    public function toggleActive(EnergyProvider $energyProvider)
    {
        $energyProvider->update(['active' => !$energyProvider->active]);

        return redirect()->back()
            ->with('success', 'Statut du fournisseur mis à jour.');
    }
} 