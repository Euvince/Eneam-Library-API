<?php

namespace App\Policies;

use App\Models\SupportedMemory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SupportedMemoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return
            $user->can("Consulter un Mémoire") ||
            $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can view any models without pagination.
     */
    public function viewAnyWithoutPagination(User $user): bool
    {
        return
            $user->can("Consulter un Mémoire") ||
            $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SupportedMemory $supportedMemory): bool
    {
        return
            $user->can("Consulter un Mémoire") ||
            $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return
            $user->can("Déposer un Mémoire") ||
            $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SupportedMemory $supportedMemory): bool
    {
        return $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SupportedMemory $supportedMemory): bool
    {
        return $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SupportedMemory $supportedMemory): bool
    {
        return $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SupportedMemory $supportedMemory): bool
    {
        return $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can download any supported memory.
     */
    public function downloadMemory(User $user, SupportedMemory $supportedMemory): bool
    {
        return $user->can("Télécharger un Mémoire") /* &&
            SupportedMemory::isValide($supportedMemory) */;
    }

    /**
     * Determine whether the user can print any memory sheet.
     */
    public function printFilingReport(User $user, SupportedMemory $supportedMemory): bool
    {
        return
            $user->can("Gérer les Mémoires Soutenus") /* &&
            SupportedMemory::isValide($supportedMemory) */;
    }

    /**
     * Determine whether the user can validate any supported memory.
     */
    public function validateMemory(User $user, SupportedMemory $supportedMemory): bool
    {
        return
            $user->can("Gérer les Mémoires Soutenus") /* &&
            !SupportedMemory::isValide($supportedMemory) */;
    }

    /**
     * Determine whether the user can reject any supported memory.
     */
    public function rejectMemory(User $user, SupportedMemory $supportedMemory): bool
    {
        return $user->can("Gérer les Mémoires Soutenus");
    }

    /**
     * Determine whether the user can reject any supported memory.
     */
    public function importReports(User $user): bool
    {
        return $user->can("Gérer les Mémoires Soutenus");
    }

}
