<?php

namespace App\Http\Controllers\API;

use App\Models\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\Permission\PermissionResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Responses\Permission\SinglePermissionResponse;
use App\Http\Responses\Permission\PermissionCollectionResponse;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : PermissionCollectionResponse | LengthAwarePaginator
    {
        return new PermissionCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Permission::count(),
            message : "Liste de toutes les permissions",
            collection : Permission::query()->with(['roles'/* , 'users' */])->orderBy('created_at', 'desc')->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission) : SinglePermissionResponse
    {
        return new SinglePermissionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur la permission $permission->name",
            resource : new PermissionResource(resource : Permission::query()->with(['roles'/* , 'users' */])->where('id', $permission->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
    }
}
