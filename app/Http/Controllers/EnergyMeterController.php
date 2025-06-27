<?php

namespace App\Http\Controllers;

use App\Models\EnergyMeter;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnergyMeterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meters = auth()->user()->energyMeters()
            ->with(['latestReading'])
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->groupBy('type');

        return view('energy-meters.index', compact('meters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencies = Currency::all();
        $types = [
            'electricity' => 'Électricité',
            'gas' => 'Gaz',
            'water' => 'Eau'
        ];

        return view('energy-meters.create', compact('currencies', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(['electricity', 'gas', 'water'])],
            'meter_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'unit' => 'required|string|max:10',
            'current_reading' => 'nullable|numeric|min:0',
            'last_reading_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = auth()->id();
        
        // S'assurer que current_reading a une valeur par défaut
        if (!isset($validated['current_reading']) || $validated['current_reading'] === null) {
            $validated['current_reading'] = 0;
        }

        EnergyMeter::create($validated);

        return redirect()->route('energy-meters.index')
            ->with('success', 'Compteur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EnergyMeter $energyMeter)
    {
        $this->authorize('view', $energyMeter);

        $readings = $energyMeter->readings()
            ->with('currency')
            ->orderBy('reading_date', 'desc')
            ->paginate(20);

        $statistics = [
            'total_consumption' => $energyMeter->total_consumption,
            'total_cost' => $energyMeter->total_cost,
            'last_month_consumption' => $energyMeter->last_month_consumption,
            'last_month_cost' => $energyMeter->last_month_cost,
            'average_monthly_consumption' => $energyMeter->readings()->count() > 0 
                ? $energyMeter->total_consumption / max(1, $energyMeter->readings()->count())
                : 0
        ];

        return view('energy-meters.show', compact('energyMeter', 'readings', 'statistics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EnergyMeter $energyMeter)
    {
        $this->authorize('update', $energyMeter);

        $currencies = Currency::all();
        $types = [
            'electricity' => 'Électricité',
            'gas' => 'Gaz',
            'water' => 'Eau'
        ];

        return view('energy-meters.edit', compact('energyMeter', 'currencies', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EnergyMeter $energyMeter)
    {
        $this->authorize('update', $energyMeter);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(['electricity', 'gas', 'water'])],
            'meter_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'unit' => 'required|string|max:10',
            'current_reading' => 'nullable|numeric|min:0',
            'last_reading_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'active' => 'boolean'
        ]);

        // S'assurer que current_reading a une valeur par défaut
        if (!isset($validated['current_reading']) || $validated['current_reading'] === null) {
            $validated['current_reading'] = 0;
        }

        $energyMeter->update($validated);

        return redirect()->route('energy-meters.show', $energyMeter)
            ->with('success', 'Compteur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EnergyMeter $energyMeter)
    {
        $this->authorize('delete', $energyMeter);

        $energyMeter->delete();

        return redirect()->route('energy-meters.index')
            ->with('success', 'Compteur supprimé avec succès.');
    }

    /**
     * Toggle the active status of the meter.
     */
    public function toggleActive(EnergyMeter $energyMeter)
    {
        $this->authorize('update', $energyMeter);

        $energyMeter->update(['active' => !$energyMeter->active]);

        return redirect()->back()
            ->with('success', 'Statut du compteur mis à jour.');
    }
} 