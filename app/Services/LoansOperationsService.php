<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\User;
use App\Models\Article;
use App\Models\Configuration;

class LoansOperationsService
{

    private static int $maxBooksPerUser;
    private static Configuration $config;

    private static function initConfig () : Configuration {
        return self::$config = Configuration::appConfig();
    }

    public static function userCanDoLoanRequest (User $user, Article $article) : bool {

        /* dump("Livre physique : " . (Article::isPhysical($article) ? "Oui" : "Non"));
        dump("Livre disponible : " . (Article::isAvailable($article) ? "Oui" : "Non"));
        dump("Une demande soumis pour cet l'article : " . (self::theBorrowerHasAlreadyLoanRequestForThisArticle($user, $article) ? "Oui" : "Non"));
        dump("Deux livres avec l'emprunteur : " . (self::twoBooksAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        dump("Deux demandes en cours : " . (self::twoRequestsAlreadyInProgress($user) ? "Oui" : "Non"));
        dump("Deux demandes acceptées : " . (self::twoRequestsAlreadyValidated($user) ? "Oui" : "Non"));
        dump("Une demande en cours et une demande acceptée : " . (self::OneRequestAlreadyInProgress__OneRequestAlreadyValidated($user) ? "Oui" : "Non"));
        dump("Une demande en cours et n'ayant pas commencée et un livre avec l'emprunteur : " . (self::OneRequestAlreadyInProgressAndNotStarted__OneBookAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        dump("Une demande acceptée mais n'ayant pas commencée et un livre avec l'emprunteur : " . (self::OneRequestAlreadyValidatedButNotStarted__OneBookAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        die(); */

        return
            Article::isPhysical(article : $article) &&
            Article::isAvailable(article : $article) &&
            !self::twoBooksAlreadyWithTheBorrower(user : $user) &&
            !self::twoRequestsAlreadyInProgress(user : $user) &&
            !self::twoRequestsAlreadyValidated(user : $user) &&
            !self::OneRequestAlreadyInProgress__OneRequestAlreadyValidated(user : $user) &&
            !self::OneRequestAlreadyInProgressAndNotStarted__OneBookAlreadyWithTheBorrower(user : $user) &&
            !self::OneRequestAlreadyValidatedButNotStarted__OneBookAlreadyWithTheBorrower(user : $user) &&
            !self::theBorrowerHasAlreadyLoanRequestForThisArticle(user : $user, article : $article)
        ;
    }

    public static function userCanReniewLoanRequest (Loan $loan) : bool {
        return
            Loan::hasStarted($loan) &&
            !self::theBorrowerHasAlreadyReniewedRequestOnce($loan);
    }

    private static function twoBooksAlreadyWithTheBorrower(User $user) : bool {
        return $user->loans()->whereNotNull('book_recovered_at')->count() >= self::getMaxBooksPerBorrower($user);
    }

    private static function twoRequestsAlreadyInProgress(User $user) : bool {
        return $user->loans()->where('status', 'En cours')->count() >= self::getMaxBooksPerBorrower($user);
    }

    private static function twoRequestsAlreadyValidated(User $user) : bool {
        return $user->loans()->where('status', 'Acceptée')->count() >= self::getMaxBooksPerBorrower($user);
    }

    private static function OneRequestAlreadyInProgress__OneRequestAlreadyValidated(User $user) : bool {
        return
            $user->loans()->where('status', 'En cours')->count() > 0 &&
            $user->loans()->where('status', 'Acceptée')->count() > 0;
    }

    private static function OneRequestAlreadyInProgressAndNotStarted__OneBookAlreadyWithTheBorrower(User $user) : bool {
        return
            $user->loans()->where('status', 'En cours')->whereNull('book_recovered_at')->count() > 0 &&
            $user->loans()->where('status', 'En cours')->whereNotNull('book_recovered_at')->count() > 0;
    }

    private static function OneRequestAlreadyValidatedButNotStarted__OneBookAlreadyWithTheBorrower(User $user) : bool {
        return
            $user->loans()->where('status', 'Acceptée')->whereNull('book_recovered_at')->count() > 0 &&
            $user->loans()->where('status', 'Acceptée')->whereNotNull('book_recovered_at')->count() > 0;
    }

    private static function theBorrowerHasAlreadyReniewedRequestOnce(Loan $loan) : bool {
        return $loan->renewals > 0;
    }

    private static function theBorrowerHasAlreadyLoanRequestForThisArticle(User $user, Article $article) : bool {

        $builder = $user->loans()->where('article_id', $article->id);
        return
            $builder->where('status', 'En cours')->count() > 0 ||
            $builder->where('status', 'Acceptée')->count() > 0 ||
            $builder->whereNotNull('book_recovered_at')->count() > 0;
    }


    private static function getMaxBooksPerBorrower (User $user) : int {
        return $user->hasAnyRole(roles : [
            'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? self::initConfig()->max_books_per_student
            : self::initConfig()->max_books_per_teacher;
    }

    private static function setMaxBooksPerBorrower (User $user) : void {
        self::$maxBooksPerUser = $user->hasAnyRole(roles : [
            'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? self::initConfig()->max_books_per_student
            : self::initConfig()->max_books_per_teacher;
    }

}
