<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleResource;
use App\Http\Responses\Role\SingleRoleResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Responses\Role\RoleCollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : RoleCollectionResponse | LengthAwarePaginator
    {
        return new RoleCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Role::count(),
            message : "Liste de tous les rôles",
            collection : Role::query()->with(['permissions'/* , 'users' */])->orderBy('created_at', 'desc')->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request) : SingleRoleResponse
    {
        $data = $request->validated();
        unset($data['permissions']);
        $role = Role::create($data);
        foreach ($request->permissions as $id) {
            $permission = Permission::findById($id);
            $role->givePermissionTo($permission->name);
        }
        return new SingleRoleResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Le rôle a été crée avec succès",
            resource : new RoleResource(resource : Role::query()->with(['permissions'])->where('id', $role->id)->first())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role) : SingleRoleResponse
    {
        return new SingleRoleResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur le rôle $role->name",
            resource : new RoleResource(resource : Role::query()->with(['permissions'/* , 'users' */])->where('id', $role->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role) : SingleRoleResponse
    {
        $data = $request->validated();
        unset($data['permissions']);
        $role->update($data);
        foreach ($role->permissions as $permission) {
            $role->revokePermissionTo($permission);
        }
        foreach ($request->permissions as $id) {
            $permission = Permission::findById($id);
            $role->givePermissionTo($permission->name);
        }
        return new SingleRoleResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Le rôle a été modifié avec succès",
            resource : new RoleResource(resource : Role::query()->with(['permissions'/* , 'users' */])->where('id', $role->id)->first())
        );
    }


    /**
     * Check if the specified resource has any children.
    */
    public function checkChildrens (Role $role) : JsonResponse
    {
        $usersCount = $role->users()->count();
        $permissionsCount = $role->permissions()->count();
        $hasChildrens = ($usersCount > 0 || $permissionsCount > 0) ? true : false;
        $message = $hasChildrens === true
            ? "Attention, ce rôle est relié à certaines données, souhaitez vous-vraiment le supprimer ?"
            : "Voulez-vous vraiment supprimer ce rôle ?, attention, cette action est irréversible.";

        return response()->json(
            status : 200,
            headers : [
                'Allow' => 'GET, POST, PUT, PATCH, DELETE',
                'Content-Type' => 'application/json',
            ],
            data :  [
                'has-children' => $hasChildrens,
                "message" => $message
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role) : JsonResponse
    {
        $role->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Le rôle a été supprimé avec succès",],
        );
    }
}
