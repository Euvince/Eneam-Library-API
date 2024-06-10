<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use App\Http\Requests\LoanRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Loan\LoanResource;
use App\Http\Responses\Loan\LoanCollectionResponse;
use App\Http\Responses\Loan\SingleLoanResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LoanController extends Controller
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
            collection : Loan::query()->with(['articles', 'user'])->orderBy('created_at', 'desc')->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanRequest $request)
    {
        $loan = Loan::create($request->validated());
        return new SingleLoanResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Votre demande d'emprunt a été envoyé avec succès",
            resource : new LoanResource(resource : Loan::query()->with(['articles', 'user'])->where('id', $loan->id)->first())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        return new SingleLoanResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur la demande d'emprunt $loan->name",
            resource : new LoanResource(resource : Loan::query()->with(['articles', 'user'])->where('id', $loan->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanRequest $request, Loan $loan)
    {
        $loan->update($request->validated());
        return new SingleLoanResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Votre demande d'emprunt a bien été a été édité",
            resource : new LoanResource(resource : Loan::query()->with(['articles', 'user'])->where('id', $loan->id)->first())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "La demande d'emprunt a bien été annulé",],
        );
    }
}
