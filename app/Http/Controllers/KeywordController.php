<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Http\Requests\KeywordRequest;
use App\Http\Responses\Keyword\KeywordCollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : KeywordCollectionResponse | LengthAwarePaginator
    {
        return new KeywordCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Keyword::count(),
            message : "Liste de tous les mots clés",
            collection : Keyword::query()->orderBy('created_at', 'desc')->get(),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KeywordRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KeywordRequest $request, Keyword $keyword)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
    }
}
