<?php

namespace App\Http\Controllers\API\Loan;

use App\Models\Loan;
use App\Http\Requests\LoanRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Loan\LoanResource;
use App\Http\Responses\Loan\LoanCollectionResponse;
use App\Http\Responses\Loan\SingleLoanResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    * Valide LoanRequest of users.
     */
    public function valideLoanRequest () : JsonResponse
    {
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "La demande d'emprunt a bien été validée et l'utilisateur sera averti"],
        );
    }

    /**
    * Reject LoanRequest of users.
     */
    public function rejectLoanRequest () : JsonResponse
    {
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "La demande d'emprunt a bien été rejetée et l'utilisateur sera averti"],
        );
    }

    /**
    * Mark loan article as recovered.
     */
    public function markArticleAsRecovered () : JsonResponse
    {
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Le document a bien été marqué comme récupéré"],
        );
    }

    /**
    * Mark loan article as returned.
     */
    public function markArticleAsReturned () : JsonResponse
    {
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Le document a bien été marqué comme retourné"],
        );
    }

}
