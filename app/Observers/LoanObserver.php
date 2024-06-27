<?php

namespace App\Observers;

use Auth;
use DateTime;
use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Auth\AuthManager;

class LoanObserver
{

    /* private DateTime $now; */

    public function __construct(
        private readonly Request $request,
        private readonly AuthManager $auth
    )
    {
        /* $this->now = Carbon::now(); */
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }


    public function creating(Loan $loan): void
    {
        /**
         * @var User $user
         */
        $user = $this->request->user() ?? \App\Models\User::find(2);

        /**
         * @var Configuration $config
         */
        $config = Configuration::appConfig();

        $durationValue = $user->hasAnyRole(roles : [
                'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? $config->student_loan_delay
            : $config->teacher_loan_delay;

        if (!app()->runningInConsole()) {
            $loan->title = "Nouvelle demande d'emprunt pour le Livre". ' '.$loan->article->title;
            $loan->slug = \Illuminate\Support\Str::slug($loan->title);
            $loan->status = "En cours";
            $loan->loan_date = Carbon::now();
            $loan->duration = $durationValue;
            $loan->user_id = $user->id;
        }

        $loan->created_by = auth()->check()
            ? $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : "APPLICATION";
    }

    /**
     * Handle the Loan "renewed" event.
     */
    public static function renewed(Loan $loan): void
    {
        /**
         * @var User $user
         */
        $user = Auth::user() ?? \App\Models\User::find(2);

        /**
         * @var Configuration $config
         */
        $config = Configuration::appConfig();

        $durationValue = $user->hasAnyRole(roles : [
                'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? $config->student_loan_delay
            : $config->teacher_loan_delay;

        $loan->update([
            'reniew_at' => Carbon::now(),
            'renewals' => ++ $loan->renewals,
            'book_must_returned_on' => Carbon::parse($loan->book_must_returned_on)->addMinutes($durationValue)/* ->format(format : "Y-m-d") */
        ]);
    }

    /**
     * Handle the Loan "created" event.
     */
    public function created(Loan $loan): void
    {
        //
    }

    /**
     * Handle the Loan "accepted" event.
     */
    public static function accepted(Loan $loan): void
    {
        /**
         * @var User $user
         */
        $user = Auth::user() ?? \App\Models\User::find(2);

        /**
         * @var Configuration $config
         */
        $config = Configuration::appConfig();

        $article = Article::find($loan->article_id);
        $articleData = ['available_stock' => -- $loan->article->available_stock];

        $durationValue = $user->hasAnyRole(roles : [
                'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? $config->student_loan_delay
            : $config->teacher_loan_delay;

        $loan->update([
            'status' => "Acceptée",
            'accepted_at' => Carbon::now(),
            'processing_date' => Carbon::now(),
            'book_must_returned_on' => Carbon::now()->addMinutes($durationValue)/* ->format(format : "Y-m-d") */
        ]);
        $article->update($articleData);
        /* if ($article->available_stock === 0) $articleData['available'] = false; */
    }

    /**
     * Handle the Loan "rejected" event.
     */
    public static function rejected(Loan $loan): void
    {
        $loan->update([
            'status' => "Rejetée",
            'rejected_at' => Carbon::now(),
            'processing_date' => Carbon::now(),
        ]);
        $loan->delete();
    }

    public function updating(Loan $loan): void
    {
        if (!app()->runningInConsole()) $loan->title = \App\Helpers::mb_ucfirst($loan->title);
        $loan->slug = \Illuminate\Support\Str::slug($loan->title);
        $loan->updated_by = auth()->check()
            ? $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : "APPLICATION";
    }

    /**
     * Handle the Loan "updated" event.
     */
    public function updated(Loan $loan): void
    {
        //
    }

    public function deleting(Loan $loan): void
    {
        $loan->deleted_by = auth()->check()
            ? $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : "APPLICATION";
        $loan->save();
    }

    /**
     * Handle the Loan "deleted" event.
     */
    public function deleted(Loan $loan): void
    {
        //
    }

    /**
     * Handle the Loan "restored" event.
     */
    public function restored(Loan $loan): void
    {
        //
    }

    /**
     * Handle the Loan "force deleted" event.
     */
    public function forceDeleted(Loan $loan): void
    {
        //
    }
}
