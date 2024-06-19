<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): void
    {
        /* return $user->can("Gérer les Commentaires"); */
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): void
    {
        /* return $user->can("Gérer les Commentaires"); */
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return
            $user->can("Commenter un Livre") ||
            $user->can("Gérer les Commentaires");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return
            $comment->user_id === $user->id ||
            $user->can("Gérer les Commentaires");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return
            $comment->user_id === $user->id ||
            $user->can("Gérer les Commentaires");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->can("Gérer les Commentaires");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->can("Gérer les Commentaires");
    }
}
