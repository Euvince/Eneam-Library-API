<?php

namespace App\Http\Controllers\API\SupportedMemory;

use App\Models\SupportedMemory;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupportedMemoryRequest;
use App\Responses\SupportedMemory\SupportedMemoryCollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupportedMemoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : SupportedMemoryCollectionResponse | LengthAwarePaginator
    {
        return new SupportedMemoryCollectionResponse(
            statusCode : 200,
            allowValue : 'GET',
            total : SupportedMemory::count(),
            message : "Liste des filières et spécialités",
            collection : SupportedMemory::query()->with(['sector', 'soutenance'])->paginate(perPage : 20),
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportedMemory $supportedMemory)
    {
        //
    }

    public function validateMemory()
    {

    }

    public function rejectedMemory()
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportedMemory $supportedMemory)
    {
        //
    }
}
