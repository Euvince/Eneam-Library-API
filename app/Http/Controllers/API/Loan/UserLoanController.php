<?php

namespace App\Http\Controllers\API\Loan;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Loan\LoanResource;
use App\Http\Responses\Loan\SingleLoanResponse;

class UserLoanController extends Controller
{
    public function __invoke(Request $request) : SingleLoanResponse
    {
        $loan = Loan::create($request->validated());
        return new SingleLoanResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Votre demande d'emprunt a été envoyé avec succès",
            resource : new LoanResource(resource : Loan::query()->with(['articles', 'user'])->where('id', $loan->id)->first())
        );
    }
}
