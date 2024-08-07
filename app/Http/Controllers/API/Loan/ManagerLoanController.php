<?php

namespace App\Http\Controllers\API\Loan;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Article;
use App\Models\Configuration;
use App\Observers\LoanObserver;
use App\Http\Requests\LoanRequest;
use App\Jobs\AcceptLoanRequestJob;
use App\Jobs\CancelLoanRequestJob;
use App\Jobs\RejectLoanRequestJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\Loan\LoanResource;
use App\Jobs\RecoveredLoanRequestArticleJob;
use App\Http\Responses\Loan\SingleLoanResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Responses\Loan\LoanCollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Jobs\RemindTheUserAboutLoanRequestSomeTimesAfterJob;

class ManagerLoanController extends Controller
{

    /* public function __construct()
    {
        $this->authorizeResource(Loan::class, 'loan');
    } */

    /**
     * Display a listing of the resource.
     */
    public function index() : LoanCollectionResponse | LengthAwarePaginator
    {
        return new LoanCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Loan::count(),
            message : "Liste de toutes les demandes d'emprunts",
            collection : Loan::query()->with([/* 'articles',  */'article','user'])->orderBy('created_at', 'desc')->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanRequest $request) : void
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan) : SingleLoanResponse
    {
        return new SingleLoanResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur la demande d'emprunt $loan->name",
            resource : new LoanResource(resource : Loan::query()->with([/* 'articles', */'article', 'user'])->where('id', $loan->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanRequest $request, Loan $loan) : void
    {
    }

    /**
    * Accept LoanRequest of users.
     */
    public function acceptLoanRequest (Loan $loan) : JsonResponse
    {
        /* $this->authorize('acceptLoanRequest', $loan); */
        /**
         * @var User $user
         */
        $user = $loan->user;
        $config =  Configuration::appConfig();
        $delayValue = $user->hasAnyRole(roles : [
            'Etudiant-Eneamien', 'Etudiant-Externe'
            ])
            ? $config->student_recovered_delay
            : $config->teacher_recovered_delay;
        if (!Loan::isAccepted($loan)) {
            LoanObserver::accepted($loan);
            AcceptLoanRequestJob::dispatch($loan);
            CancelLoanRequestJob::dispatch($loan)
                ->delay(delay : Carbon::now()->addSeconds(value : $delayValue));
            RemindTheUserAboutLoanRequestSomeTimesAfterJob::dispatch($loan)
                ->delay(delay : Carbon::now()->addSeconds(value : ($delayValue / 2)));

            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "La demande d'emprunt a bien été acceptée et l'emprunteur est informé"],
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Les conditions nécéssaires à une acceptation d'emprunt ne sont pas remplies.",],
            );
        }
    }

    /**
    * Reject LoanRequest of users.
     */
    public function rejectLoanRequest (Loan $loan, LoanRequest $request) : JsonResponse
    {
        /* $this->authorize('rejectLoanRequest', $loan); */
        if (!Loan::isAccepted($loan) && !Loan::isRejected($loan)) {
            RejectLoanRequestJob::dispatch($request->validated('reason'), $loan);
            LoanObserver::rejected($loan);
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "La demande d'emprunt a bien été rejetée et l'emprunteur est informé"],
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Les conditions nécéssaires à un rejet d'emprunt ne sont pas remplies.",],
            );
        }
    }

    /**
    * Mark loan article as recovered.
     */
    public function markArticleAsRecovered (Loan $loan) : JsonResponse
    {
        /* $this->authorize('markArticleAsRecovered', $loan); */
        if (Loan::isAccepted($loan) && !Loan::hasStarted($loan)) {
            Loan::markAsStarted($loan);
            /* RecoveredLoanRequestArticleJob::dispatch($loan); */
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Le document a bien été marqué comme récupéré"],
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Les conditions nécéssaires à une récupération de Livre ne sont pas remplies.",],
            );
        }
    }

    /**
    * Mark loan article as returned.
     */
    public function markArticleAsReturned (Loan $loan) : JsonResponse
    {
        /* $this->authorize('markArticleAsReturned', $loan); */
        if (Loan::hasStarted($loan) && !Loan::isFinished($loan)) {
            Loan::markAsFinished($loan);
            /**
             * @var Article $article
             */
            $article = $loan->article;
            $article->update(['available_stock' => ++ $article->available_stock]);
            if (!Article::isAvailable($article)) Article::markAsAvailable($article);
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Le document a bien été marqué comme retourné"],
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Les conditions nécéssaires à un retour de Livre ne sont pas remplies.",],
            );
        }
    }

    /**
    * Mark loan article as withdrawed.
     */
    public function markAsWithdrawed (Loan $loan) : JsonResponse
    {
        /* $this->authorize('markAsWithdrawed', $loan); */
        if (
            (Loan::isFinished($loan) && !Loan::isWithdrawed($loan)) ||
            (Loan::isRejected($loan) && !Loan::isWithdrawed($loan))
        ) {
            Loan::markAsWithdrawed($loan);
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Le document a bien été marqué comme retiré"],
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Les conditions nécéssaires à un retrait d'emprunt du listing ne sont pas remplies.",],
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan) : JsonResponse
    {
        $loan->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "La demande d'emprunt a bien été supprimée",],
        );
    }

}
