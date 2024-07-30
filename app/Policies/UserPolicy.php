<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\AuthManager;

class UserPolicy
{
    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id = $this->auth->user()->id ||
            $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can check if the model has any children.
     */
    public function checkChildrens(User $user, User $model): bool
    {
        return $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can check if the model has any children.
     */
    public function giveAccessToUser(User $user, User $model): bool
    {
        return $user->can("Gérer les Utilisateurs")
            /*  && !User::hasPaid($model) && !User::hasAccess($model) */;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return /* $user->id = $this->auth->user()->id || */
            $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can import users.
     */
    public function importUsers(User $user, User $model): bool
    {
        return $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can export users.
     */
    public function exportUsers(User $user, User $model): bool
    {
        return $user->can("Gérer les Utilisateurs");
    }

    /**
     * Determine whether the user can update his profile.
     */
    public function UpdateProfileInformations(User $user, User $model): bool
    {
        return $user->id === $model->id &&
            $user->can("Modifier son profile");
    }

    /**
     * Determine whether the user can update his profile.
     */
    public function UpdatePassword(User $user, User $model): bool
    {
        return $user->id === $model->id &&
            $user->can("Modifier son mot de passe");
    }

}
