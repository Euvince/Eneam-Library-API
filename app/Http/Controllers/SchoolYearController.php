<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use App\Http\Requests\SchoolYearRequest;
use App\Http\Responses\SchoolYear\SchoolYearCollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SchoolYearController extends Controller
{

    /* public function __construct()
    {
        $this->authorizeResource(SchoolYear::class, 'schoolYear');
    } */

    /**
     * Display a listing of the resource.
     */
    public function index() : SchoolYearCollectionResponse | LengthAwarePaginator
    {
        return new SchoolYearCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : SchoolYear::count(),
            message : "Liste de toutes les années scolaires",
            collection : SchoolYear::query()->orderBy('start_date', 'desc')->get(),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchoolYearRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolYear $schoolYear)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchoolYearRequest $request, SchoolYear $schoolYear)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolYear $schoolYear)
    {
    }
}
