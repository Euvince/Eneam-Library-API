<?php

namespace App\Services;

use Carbon\Carbon;
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
        dump("L'utilisateur a une demande soumise pour cet l'article : " . (self::theBorrowerHasAlreadyLoanRequestForThisArticle($user, $article) ? "Oui" : "Non"));
        dump("Deux livres avec l'emprunteur : " . (self::twoBooksAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        dump("Deux demandes en cours de traitement : " . (self::twoRequestsAlreadyInProgress($user) ? "Oui" : "Non"));
        dump("Deux demandes acceptées : " . (self::twoRequestsAlreadyAccepted($user) ? "Oui" : "Non"));
        dump("Une demande en cours de traitement et une demande acceptée : " . (self::OneRequestAlreadyInProgress__OneRequestAlreadyAccepted($user) ? "Oui" : "Non"));
        dump("Une demande en cours de traitement n'ayant pas commencée et un livre avec l'emprunteur : " . (self::OneRequestAlreadyInProgressAndNotStarted__OneBookAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        dump("Une demande acceptée n'ayant pas commencée et un livre avec l'emprunteur : " . (self::OneRequestAlreadyAcceptedButNotStarted__OneBookAlreadyWithTheBorrower($user) ? "Oui" : "Non"));
        die(); */

        return
            $article->available_stock > 0 &&
            Article::isPhysical(article : $article) &&
            Article::isAvailable(article : $article) &&
            !self::twoBooksAlreadyWithTheBorrower(user : $user) &&
            !self::twoRequestsAlreadyInProgress(user : $user) &&
            !self::twoRequestsAlreadyAccepted(user : $user) &&
            !self::OneRequestAlreadyInProgress__OneRequestAlreadyAccepted(user : $user) &&
            !self::OneRequestAlreadyInProgressAndNotStarted__OneBookAlreadyWithTheBorrower(user : $user) &&
            !self::OneRequestAlreadyAcceptedButNotStarted__OneBookAlreadyWithTheBorrower(user : $user) &&
            !self::theBorrowerHasAlreadyLoanRequestForThisArticle(user : $user, article : $article)
        ;
    }

    public static function userCanReniewLoanRequest (Loan $loan, User $user) : bool {

        /* dump("Livre récupéré : " . (Loan::hasStarted($loan)  ? "Oui" : "Non"));
        dump("Livre retourné : " . (Loan::isFinished($loan) ? "Oui" : "Non"));
        dump("La demande appartient à l'utilisateur : " . ($loan->user_id === $user->id ? "Oui" : "Non"));
        dump("La demande a déjà été renouvellée : " . (self::theBorrowerHasAlreadyReniewedRequestOnce($loan) ? "Oui" : "Non"));
        dump("La date limite de retour du livre est passée : " . (Carbon::parse($loan->book_must_returned_on)->format("Y-m-d H:i:s") < Carbon::parse(Carbon::now())->format("Y-m-d H:i:s") ? "Oui" : "Non"));
        die(); */

        return
            Loan::hasStarted($loan) &&
            !Loan::isFinished($loan) &&
            $loan->user_id === $user->id &&
            /* !self::theBorrowerHasAlreadyReniewedRequestOnce($loan) && */
            !self::theBorrowerAttemptHerMaxRenewals($user, $loan) &&
            !(
                Carbon::parse($loan->book_must_returned_on)->format("Y-m-d H:i:s") <
                Carbon::parse(Carbon::now())->format("Y-m-d H:i:s")
            );
    }

    private static function twoBooksAlreadyWithTheBorrower(User $user) : bool {
        return $user->loans()->whereNotNull('book_recovered_at')->count() >= self::getMaxBooksPerBorrower($user);
    }

    private static function twoRequestsAlreadyInProgress(User $user) : bool {
        return $user->loans()->where('status', 'En cours de traitement')->count() >= self::getMaxBooksPerBorrower($user);
    }

    private static function twoRequestsAlreadyAccepted(User $user) : bool {
        return $user->loans()->where('status', 'Acceptée')->count() >= self::getMaxBooksPerBorrower($user);
    }

    private static function OneRequestAlreadyInProgress__OneRequestAlreadyAccepted(User $user) : bool {
        return
            $user->loans()->where('status', 'En cours de traitement')->count() > 0 &&
            $user->loans()->where('status', 'Acceptée')->count() > 0;
    }

    private static function OneRequestAlreadyInProgressAndNotStarted__OneBookAlreadyWithTheBorrower(User $user) : bool {
        return
            $user->loans()->where('status', 'En cours de traitement')->whereNull('book_recovered_at')->count() > 0 &&
            $user->loans()->where('status', 'En cours')->whereNotNull('book_recovered_at')->count() > 0;
    }

    private static function OneRequestAlreadyAcceptedButNotStarted__OneBookAlreadyWithTheBorrower(User $user) : bool {
        return
            $user->loans()->where('status', 'Acceptée')->whereNull('book_recovered_at')->count() > 0 &&
            $user->loans()->where('status', 'En cours')->whereNotNull('book_recovered_at')->count() > 0;
    }

    private static function theBorrowerHasAlreadyReniewedRequestOnce(Loan $loan) : bool {
        return $loan->renewals > 0;
    }

    public static function theBorrowerAttemptHerMaxRenewals(User $user, Loan $loan) : bool {
        $userRenewalsNumber = $user->hasAnyRole(roles : [
            'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? self::initConfig()->student_renewals_number
            : self::initConfig()->teacher_renewals_number;

        return $loan->renewals === $userRenewalsNumber;
    }

    private static function theBorrowerHasAlreadyLoanRequestForThisArticle(User $user, Article $article) : bool {
        return
            $user->loans()->where('article_id', $article->id)->where('status', 'En cours de traitement')->whereNull('book_recovered_at')->count() > 0 ||
            $user->loans()->where('article_id', $article->id)->where('status', 'Acceptée')->whereNull('book_recovered_at')->count() > 0 ||
            $user->loans()->where('article_id', $article->id)->where('status', 'En cours')->whereNotNull('book_recovered_at')->count() > 0;
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
