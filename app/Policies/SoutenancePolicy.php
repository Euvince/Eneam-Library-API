<?php

namespace App\Policies;

use App\Models\Soutenance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SoutenancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can("Gérer les Soutenances");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Soutenance $soutenance): bool
    {
         return $user->can("Gérer les Soutenances");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return $user->can("Gérer les Soutenances");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Soutenance $soutenance): bool
    {
         return $user->can("Gérer les Soutenances");
    }

    /**
     * Determine whether the user can check if the model has any children.
     */
    public function checkChildrens(User $user, Soutenance $soutenance): bool
    {
        return $user->can("Gérer les Soutenances");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Soutenance $soutenance): bool
    {
         return $user->can("Gérer les Soutenances");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Soutenance $soutenance): bool
    {
         return $user->can("Gérer les Soutenances");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Soutenance $soutenance): bool
    {
         return $user->can("Gérer les Soutenances");
    }
}
