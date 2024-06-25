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
        dump("Livre physique : " . (Article::isPhysical($article) ? "Oui" : "Non"));
        dump("Livre disponible : " . (Article::isAvailable($article) ? "Oui" : "Non"));
        dump("Deux livres avec l'emprunteur : " . (self::twoBooksAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        dump("Deux demandes en cours : " . (self::twoRequestsAlreadyInProgress($user) ? "Oui" : "Non"));
        dump("Deux demandes validées : " . (self::twoRequestsAlreadyValidated($user) ? "Oui" : "Non"));
        dump("Une demande en cours et Une demande validée : " . (self::OneRequestAlreadyInProgress__OneRequestAlreadyValidated($user) ? "Oui" : "Non"));
        dump("Une demande en cours et Un Livre avec l'emprunteur : " . (self::OneRequestAlreadyInProgress__OneBookAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        dump("Une demande validée et Un Livre avec l'emprunteur : " . (self::OneRequestAlreadyValidated__OneBookAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        die();

        return
            !Article::isPhysical($article) ||
            !Article::isAvailable($article) ||
            !self::twoBooksAlreadyWithTheBorrower($user) ||
            !self::twoRequestsAlreadyInProgress($user) ||
            !self::twoRequestsAlreadyValidated($user) ||
            !self::OneRequestAlreadyInProgress__OneRequestAlreadyValidated($user) ||
            !self::OneRequestAlreadyInProgress__OneBookAlreadyWithTheBorrower($user) ||
            !self::OneRequestAlreadyValidated__OneBookAlreadyWithTheBorrower($user)
        ;
    }

    public static function userCanReniewLoanRequest (Loan $loan) : bool {
        return
            Loan::hasStarted($loan) &&
            !self::theLenderHasAlreadyReniewedRequestOnce($loan);
    }

    private static function articleIsAvailable_articleIsPhysical(Article $article) : bool {
        return
            $article->available_stock > 0 &&
            Article::isAvailable($article) &&
            Article::isPhysical($article);
    }

    private static function twoBooksAlreadyWithTheBorrower(User $user) : bool {
        return $user->loans()->whereNotNull('book_recovered_at')->count() >= self::getMaxBooksPerUser($user);
    }

    private static function twoRequestsAlreadyInProgress(User $user) : bool {
        return $user->loans()->where('status', 'En cours')->count() >= self::getMaxBooksPerUser($user);
    }

    private static function twoRequestsAlreadyValidated(User $user) : bool {
        return $user->loans()->where('status', 'Validée')->count() >= self::getMaxBooksPerUser($user);
    }

    private static function OneRequestAlreadyInProgress__OneRequestAlreadyValidated(User $user) : bool {
        return
            $user->loans()->where('status', 'En cours')->count() > 0 &&
            $user->loans()->where('status', 'Validée')->count() > 0;
    }

    private static function OneRequestAlreadyInProgress__OneBookAlreadyWithTheBorrower(User $user) : bool {
        return
            $user->loans()->where('status', 'En cours')->count() > 0 &&
            $user->loans()->whereNotNull('book_recovered_at')->count() > 0;
    }

    private static function OneRequestAlreadyValidated__OneBookAlreadyWithTheBorrower(User $user) : bool {
        return
            $user->loans()->where('status', 'Validée')->count() > 0 &&
            $user->loans()->whereNotNull('book_recovered_at')->count() > 0;
    }

    private static function theLenderHasAlreadyReniewedRequestOnce(Loan $loan) : bool {
        return $loan->renewals > 0;
    }


    private static function getMaxBooksPerUser (User $user) : int {
        return $user->hasAnyRole(roles : [
            'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? self::initConfig()->max_books_per_student
            : self::initConfig()->max_books_per_teacher;
    }

    private static function setMaxBooksPerUser (User $user) : void {
        self::$maxBooksPerUser = $user->hasAnyRole(roles : [
            'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? self::initConfig()->max_books_per_student
            : self::initConfig()->max_books_per_teacher;
    }

}
