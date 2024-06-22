<?php

namespace App\Http\Controllers\API\Loan;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Loan\LoanResource;
use App\Http\Responses\Loan\SingleLoanResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserLoanController extends Controller
{

    public function canDoLoanRequest(Request $request) : JsonResponse
    {
        return response()->json();
    }

    public function doLoanRequest(Request $request) : SingleLoanResponse
    {
        $loan = Loan::create($request->validated());
        return new SingleLoanResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Votre demande d'emprunt a été soumise avec succès.",
            resource : new LoanResource(resource : Loan::query()->with([/* 'articles', */'article', 'user'])->where('id', $loan->id)->first())
        );
    }

    public function reniewLoanRequest() : JsonResponse
    {
        return response()->json();
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
