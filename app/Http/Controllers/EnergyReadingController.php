<?php

namespace App\Http\Controllers;

use App\Models\EnergyReading;
use App\Models\EnergyMeter;
use App\Models\Currency;
use Illuminate\Http\Request;

class EnergyReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $readings = auth()->user()->energyReadings()
            ->with(['energyMeter', 'currency'])
            ->orderBy('reading_date', 'desc')
            ->paginate(20);

        return view('energy-readings.index', compact('readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $meters = auth()->user()->energyMeters()->active()->get();
        $currencies = Currency::all();

        return view('energy-readings.create', compact('meters', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'energy_meter_id' => 'required|exists:energy_meters,id',
            'reading_date' => 'required|date',
            'reading_value' => 'required|numeric|min:0',
            'consumption' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'unit_price' => 'nullable|numeric|min:0',
            'reading_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_estimated' => 'boolean'
        ]);

        $validated['user_id'] = auth()->id();

        // Vérifier que le compteur appartient à l'utilisateur
        $meter = EnergyMeter::where('id', $validated['energy_meter_id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Calculer automatiquement la consommation si pas fournie
        if (!isset($validated['consumption'])) {
            $previousReading = $meter->readings()
                ->where('reading_date', '<', $validated['reading_date'])
                ->orderBy('reading_date', 'desc')
                ->first();

            if ($previousReading) {
                $validated['consumption'] = $validated['reading_value'] - $previousReading->reading_value;
            } else {
                $validated['consumption'] = 0;
            }
        }

        // Calculer automatiquement le coût si pas fourni
        if (!isset($validated['cost']) && isset($validated['unit_price']) && $validated['consumption'] > 0) {
            $validated['cost'] = $validated['consumption'] * $validated['unit_price'];
        }

        $reading = EnergyReading::create($validated);

        // Mettre à jour le compteur avec la dernière lecture
        $meter->update([
            'current_reading' => $validated['reading_value'],
            'last_reading_date' => $validated['reading_date']
        ]);

        return redirect()->route('energy-meters.show', $meter)
            ->with('success', 'Relevé ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EnergyReading $energyReading)
    {
        $this->authorize('view', $energyReading);

        return view('energy-readings.show', compact('energyReading'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EnergyReading $energyReading)
    {
        $this->authorize('update', $energyReading);

        $meters = auth()->user()->energyMeters()->active()->get();
        $currencies = Currency::all();

        return view('energy-readings.edit', compact('energyReading', 'meters', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EnergyReading $energyReading)
    {
        $this->authorize('update', $energyReading);

        $validated = $request->validate([
            'energy_meter_id' => 'required|exists:energy_meters,id',
            'reading_date' => 'required|date',
            'reading_value' => 'required|numeric|min:0',
            'consumption' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'unit_price' => 'nullable|numeric|min:0',
            'reading_method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_estimated' => 'boolean'
        ]);

        // Vérifier que le compteur appartient à l'utilisateur
        $meter = EnergyMeter::where('id', $validated['energy_meter_id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Recalculer la consommation si la valeur de lecture a changé
        if ($validated['reading_value'] != $energyReading->reading_value) {
            $previousReading = $meter->readings()
                ->where('reading_date', '<', $validated['reading_date'])
                ->where('id', '!=', $energyReading->id)
                ->orderBy('reading_date', 'desc')
                ->first();

            if ($previousReading) {
                $validated['consumption'] = $validated['reading_value'] - $previousReading->reading_value;
            } else {
                $validated['consumption'] = 0;
            }
        }

        // Recalculer le coût si nécessaire
        if (isset($validated['unit_price']) && $validated['consumption'] > 0) {
            $validated['cost'] = $validated['consumption'] * $validated['unit_price'];
        }

        $energyReading->update($validated);

        // Mettre à jour le compteur si c'est la lecture la plus récente
        $latestReading = $meter->readings()->orderBy('reading_date', 'desc')->first();
        if ($latestReading && $latestReading->id == $energyReading->id) {
            $meter->update([
                'current_reading' => $validated['reading_value'],
                'last_reading_date' => $validated['reading_date']
            ]);
        }

        return redirect()->route('energy-meters.show', $meter)
            ->with('success', 'Relevé mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EnergyReading $energyReading)
    {
        $this->authorize('delete', $energyReading);

        $meter = $energyReading->energyMeter;
        $energyReading->delete();

        // Mettre à jour le compteur avec la nouvelle lecture la plus récente
        $latestReading = $meter->readings()->orderBy('reading_date', 'desc')->first();
        if ($latestReading) {
            $meter->update([
                'current_reading' => $latestReading->reading_value,
                'last_reading_date' => $latestReading->reading_date
            ]);
        } else {
            $meter->update([
                'current_reading' => 0,
                'last_reading_date' => null
            ]);
        }

        return redirect()->route('energy-meters.show', $meter)
            ->with('success', 'Relevé supprimé avec succès.');
    }

    /**
     * Show readings for a specific meter.
     */
    public function meterReadings(EnergyMeter $energyMeter)
    {
        $this->authorize('view', $energyMeter);

        $readings = $energyMeter->readings()
            ->with('currency')
            ->orderBy('reading_date', 'desc')
            ->paginate(20);

        return view('energy-readings.meter-readings', compact('energyMeter', 'readings'));
    }
} 