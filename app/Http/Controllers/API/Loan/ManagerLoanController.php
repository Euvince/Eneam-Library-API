<?php

namespace App\Http\Controllers\API\Loan;

use App\Models\Loan;
use App\Observers\LoanObserver;
use App\Http\Requests\LoanRequest;
use App\Jobs\AcceptLoanRequestJob;
use App\Jobs\RejectLoanRequestJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\Loan\LoanResource;
use App\Http\Responses\Loan\SingleLoanResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Responses\Loan\LoanCollectionResponse;
use App\Jobs\CancelLoanRequestJob;
use App\Jobs\RemindTheUserAboutLoanRequestSomeTimesAfterJob;
use App\Models\Configuration;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ManagerLoanController extends Controller
{
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

    /**
    * Accept LoanRequest of users.
     */
    public function acceptLoanRequest (Loan $loan) : JsonResponse
    {
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
        // if (!Loan::isAccepted($loan)) {
            LoanObserver::accepted($loan);
            AcceptLoanRequestJob::dispatch($loan);
            CancelLoanRequestJob::dispatch($loan)
                ->delay(delay : Carbon::now()->addDays(value : $delayValue));
            RemindTheUserAboutLoanRequestSomeTimesAfterJob::dispatch($loan)
                ->delay(delay : Carbon::now()->addDays(value : ($delayValue / 2)));
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "La demande d'emprunt a bien été acceptée et l'emprunteur est informé"],
            );
        // }
    }

    /**
    * Reject LoanRequest of users.
     */
    public function rejectLoanRequest (Loan $loan, LoanRequest $request) : JsonResponse
    {
        // if (!Loan::isRejected($loan)) {
            LoanObserver::rejected($loan);
            RejectLoanRequestJob::dispatch($loan, $request->validated('reason'));
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "La demande d'emprunt a bien été rejetée et l'emprunteur est informé"],
            );
        // }
    }

    /**
    * Mark loan article as recovered.
     */
    public function markArticleAsRecovered (Loan $loan) : JsonResponse
    {
        // Vérifier que le Livre peut-être récupérer
        Loan::markAsStarted($loan);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Le document a bien été marqué comme récupéré"],
        );
    }

    /**
    * Mark loan article as returned.
     */
    public function markArticleAsReturned (Loan $loan) : JsonResponse
    {
        // Vérifier que le Livre peut-être retourner
        Loan::markAsFinished($loan);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Le document a bien été marqué comme retourné"],
        );
    }

    /**
    * Mark loan article as returned.
     */
    public function markAsWithdrawed (Loan $loan) : JsonResponse
    {
        // Vérifier que le Livre peut-être retirer du Listing
        Loan::markAsWithdrawed($loan);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Le document a bien été marqué comme retourné"],
        );
    }

}
