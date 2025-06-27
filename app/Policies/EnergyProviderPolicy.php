<?php

namespace App\Policies;

use App\Models\EnergyProvider;
use App\Models\User;

class EnergyProviderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EnergyProvider $energyProvider): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EnergyProvider $energyProvider): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EnergyProvider $energyProvider): bool
    {
        // Empêcher la suppression si le fournisseur a des tarifs
        return $energyProvider->tariffs()->count() === 0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EnergyProvider $energyProvider): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EnergyProvider $energyProvider): bool
    {
        return false;
    }
} 