<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Http\Responses\User\{
    SingleUserResponse,
    UserCollectionResponse
};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : UserCollectionResponse | LengthAwarePaginator
    {
        return new UserCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : User::count(),
            message : "Liste de tous les utilisateurs",
            collection : User::query()->with(['roles', 'permissions'])->orderBy('created_at', 'desc')->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) : SingleUserResponse
    {
        return new SingleUserResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur l'utilisateur" . " " . $user->firstname . " " . $user->lastname,
            resource : new UserResource(resource : User::query()->with(['roles', 'permissions'])->where('id', $user->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) : JsonResponse
    {
        $user->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "L'utilisateur a été supprimé avec succès",],
        );
    }
}
