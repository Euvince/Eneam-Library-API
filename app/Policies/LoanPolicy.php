<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;
use App\Services\LoansOperationsService;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\AuthManager;

class LoanPolicy
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
        return $user->can("Gérer les Emprunts");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Loan $loan): bool
    {
        return $user->can("Gérer les Emprunts") ||
            $user->id === $loan->user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can("Gérer les Emprunts") ||
            $user->can("Prêter un Livre");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Loan $loan): bool
    {
        return  $user->can("Gérer les Emprunts") ||
            $user->id === $loan->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Loan $loan): bool
    {
        return  $user->can("Gérer les Emprunts") ||
            $user->id === $loan->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Loan $loan): bool
    {
        return $user->can("Gérer les Emprunts");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Loan $loan): bool
    {
        return $user->can("Gérer les Emprunts");
    }

    /**
     * Determine whether the user can do loan request.
     */
    public function canDoLoanRequest(User $user, Loan $loan): bool
    {
        return $user->can("Prêter un Livre") /* &&
            LoansOperationsService::userCanDoLoanRequest($user, $loan->article) */;
    }

    /**
     * Determine whether the user can do loan request.
     */
    public function doLoanRequest(User $user, Loan $loan): bool
    {
        return $user->can("Prêter un Livre") /* &&
            LoansOperationsService::userCanDoLoanRequest($user, $loan->article) */;
    }

    /**
     * Determine whether the user can reniew loan request.
     */
    public function canReniewLoanRequest(User $user, Loan $loan): bool
    {
        return $user->can("Renouveller un Emprunt") /* &&
            LoansOperationsService::userCanReniewLoanRequest($loan, $user) */;
    }

    /**
     * Determine whether the user can reniew loan request.
     */
    public function reniewLoanRequest(User $user, Loan $loan): bool
    {
        return $user->can("Renouveller un Emprunt") /* &&
            LoansOperationsService::userCanReniewLoanRequest($loan, $user) */;
    }

    /**
     * Determine whether the user can cancel loan request.
     */
    public function cancelLoanRequest(User $user, Loan $loan): bool
    {
        return $user->can("Prêter un Livre") /* &&
            $loan->status === "En cours de traitement" && $loan->book_recovered_at === NULL */;
    }


    /**
     * Determine whether the user can accept loan request.
     */
    public function acceptLoanRequest(User $user, Loan $loan): bool
    {
        return $user->can("Gérer les Emprunts") /* &&
            !Loan::isAccepted($loan) */;
    }

    /**
     * Determine whether the user can reject loan request.
     */
    public function rejectLoanRequest(User $user, Loan $loan): bool
    {
        return $user->can("Gérer les Emprunts") /* &&
            !Loan::isAccepted($loan) && !Loan::isRejected($loan) */;
    }

    /**
     * Determine whether the user can mark article as recovered.
     */
    public function markArticleAsRecovered(User $user, Loan $loan): bool
    {
        return $user->can("Gérer les Emprunts") /* &&
            Loan::isAccepted($loan) && !Loan::hasStarted($loan) */;
    }

    /**
     * Determine whether the user can mark article as recovered.
     */
    public function markArticleAsReturned(User $user, Loan $loan): bool
    {
        return $user->can("Gérer les Emprunts") /* &&
            Loan::hasStarted($loan) && !Loan::isFinished($loan) */;
    }

    /**
     * Determine whether the user can mark article as withdraw.
     */
    public function markAsWithdrawed(User $user, Loan $loan): bool
    {
        return $user->can("Gérer les Emprunts") /* && (
            (Loan::isFinished($loan) && !Loan::isWithdrawed($loan)) ||
            (Loan::isRejected($loan) && !Loan::isWithdrawed($loan))
        ) */;
    }

}
