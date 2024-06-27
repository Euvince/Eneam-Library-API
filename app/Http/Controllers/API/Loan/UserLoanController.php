<?php

namespace App\Http\Controllers\API\Loan;

use App\Models\Loan;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Observers\LoanObserver;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyLoanRequestJob;
use App\Http\Resources\Loan\LoanResource;
use App\Jobs\NotifyLoanRequestReniwedJob;
use App\Http\Responses\Loan\SingleLoanResponse;
use App\Services\LoansOperationsService;
use Illuminate\Auth\AuthManager;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserLoanController extends Controller
{

    public function __construct(
        private readonly Request $request,
        private readonly AuthManager $auth
    )
    {
    }

    public function canDoLoanRequest(Article $article) : JsonResponse
    {
        $response = LoansOperationsService::userCanDoLoanRequest(
            $this->auth->user() ??
            \App\Models\User::find(2),
            $article
        );
        $message = $response
            ? "L'emprunteur peut éffectuer une demande d'emprunt"
            : "L'emprunteur ne peut éffectuer de demande d'emprunt";

        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => $message,
                'response' => $response
            ],
        );
    }

    public function doLoanRequest(Article $article) : SingleLoanResponse | JsonResponse
    {
        if (LoansOperationsService::userCanDoLoanRequest(
                $this->auth->user() ??
                \App\Models\User::find(2),
                $article
            )
        ) {
            $loan = $article->loans()->create();
            NotifyLoanRequestJob::dispatch($loan);
            return new SingleLoanResponse(
                statusCode : 201,
                allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
                message : "Votre demande d'emprunt a été soumise avec succès.",
                resource : new LoanResource(resource : Loan::query()->with([/* 'articles', */'article', 'user'])->where('id', $loan->id)->first())
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Impossible d'éffectuer une demande d'emprunt sur cet article.",],
            );
        }
    }

    public function canReniewLoanRequest(Loan $loan) : JsonResponse
    {
        $response = LoansOperationsService::userCanReniewLoanRequest(
            $loan,
            $this->auth->user() ??
            \App\Models\User::find(2),
        );
        $message = $response
            ? "L'emprunteur peut renouveller la demande d'emprunt"
            : "L'emprunteur ne peut renouveller la demande d'emprunt";

        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => $message,
                'response' => $response
            ],
        );
    }

    public function reniewLoanRequest(Loan $loan) : JsonResponse
    {
        if (LoansOperationsService::userCanReniewLoanRequest(
            $loan,
            $this->auth->user() ??
            \App\Models\User::find(2),
        )) {
            LoanObserver::renewed($loan);
            NotifyLoanRequestReniwedJob::dispatch($loan);
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "La demande d'emprunt a été renouvellée avec succès.",],
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Vous n'êtes pas éligible à ce renouvellement d'emprunt.",],
            );
        }
    }

    public function cancelLoanRequest(Loan $loan) : JsonResponse
    {
        if ($loan->book_recovered_at === NULL) {
            /**
             * @var Article $article
             */
            $article = Article::find($loan->article_id);
            $article->update([
                'available_stock' => ++ $loan->article->available_stock
            ]);
            Article::markAsAvailable($article);
            $loan->delete();
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "La demande d'emprunt a été annulée avec succès.",],
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Impossible d'annuler un emprunt après récupération du Livre.",],
            );
        }
    }

}
