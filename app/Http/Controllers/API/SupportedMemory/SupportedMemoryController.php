<?php

namespace App\Http\Controllers\API\SupportedMemory;

use App\Models\SupportedMemory;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupportedMemoryRequest;

class SupportedMemoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
