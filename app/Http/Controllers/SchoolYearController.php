<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use App\Http\Requests\SchoolYearRequest;
use App\Http\Responses\SchoolYear\SchoolYearCollectionResponse;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SchoolYearCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : SchoolYear::count(),
            message : "Liste de toutes les années scolaires",
            collection : SchoolYear::query()->orderBy('start_date', 'desc')->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolYearRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolYearRequest $request, SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolYear $schoolYear)
    {
        //
    }
}
