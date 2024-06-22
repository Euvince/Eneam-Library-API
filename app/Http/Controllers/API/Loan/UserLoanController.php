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
use Symfony\Component\HttpFoundation\JsonResponse;

class UserLoanController extends Controller
{

    public function canDoLoanRequest() : JsonResponse
    {
        return response()->json();
    }

    public function doLoanRequest(Article $article) : SingleLoanResponse
    {
        // Vérifier s'il peut soumettre une nouvelle demande
        $loan = $article->loans()->create();
        NotifyLoanRequestJob::dispatch($loan);
        return new SingleLoanResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Votre demande d'emprunt a été soumise avec succès.",
            resource : new LoanResource(resource : Loan::query()->with([/* 'articles', */'article', 'user'])->where('id', $loan->id)->first())
        );
    }

    public function reniewLoanRequest(Loan $loan) : JsonResponse
    {
        // Vérifier s'il peut renouveller une demande
        LoanObserver::renewed($loan);
        NotifyLoanRequestReniwedJob::dispatch($loan);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "La demande d'emprunt a été renouvellée avec succès.",],
        );
    }

    public function cancelLoanRequest(Loan $loan) : JsonResponse
    {
        $loan->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "La demande d'emprunt a été annulée avec succès.",],
        );
    }

}
