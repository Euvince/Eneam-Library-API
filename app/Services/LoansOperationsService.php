<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Loan;
use App\Models\User;

class LoansOperationsService
{
    public static function userCanDoLoanRequest (User $user, Article $article) : bool {
        return
            !self::articleIsAvailable_articleIsPhysical($article) ||
            !self::twoBooksAlreadyWithTheBorrower($user) ||
            !self::twoRequestsAlreadyInProgress($user) ||
            !self::twoRequestsAlreadyValidated($user) ||
            !self::OneRequestAlreadyInProgress__OneBookAlreadyWithTheBorrower($user) ||
            !self::OneRequestAlreadyValidated__OneBookAlreadyWithTheBorrower($user) ||
            !self::OneRequestAlreadyInProgress__OneRequestAlreadyValidated($user)
        ;
    }

    public static function userCanReniewLoanRequest (Loan $loan) : bool {
        // Vérifier si la demande a été acceptée, le Livre a été recupéré et s'il n'a pas déjà renouveller une fois la demande
        return
            self::theLenderHasAlreadyReniewedRequestOnce($loan);
    }

    private static function articleIsAvailable_articleIsPhysical(Article $article) : bool {
        return (Article::isAvailable($article) && Article::isPhysical($article));
    }

    private static function twoBooksAlreadyWithTheBorrower(User $user) : bool {
        return $user->loans()->whereNotNull('book_recovered_at') > 1;
    }

    private static function twoRequestsAlreadyInProgress(User $user) : bool {
        return $user->loans()->where('status', 'En cours') > 1;
    }

    private static function twoRequestsAlreadyValidated(User $user) : bool {
        return $user->loans()->where('status', 'Validée') > 1;
    }

    private static function OneRequestAlreadyInProgress__OneBookAlreadyWithTheBorrower(User $user) : bool {
        return
            $user->loans()->where('status', 'En cours') > 0 &&
            $user->loans()->whereNotNull('book_recovered_at') > 0;
    }

    private static function OneRequestAlreadyValidated__OneBookAlreadyWithTheBorrower(User $user) : bool {
        return
            $user->loans()->where('status', 'Validée') > 0 &&
            $user->loans()->whereNotNull('book_recovered_at') > 0;
    }

    private static function OneRequestAlreadyInProgress__OneRequestAlreadyValidated(User $user) : bool {
        return
            $user->loans()->where('status', 'En cours') > 0 &&
            $user->loans()->where('status', 'Validée') > 0;
    }

    private static function theLenderHasAlreadyReniewedRequestOnce(Loan $loan) : bool {
        return $loan->renewals > 0;
    }

}
