<?php

namespace App\Http\Controllers\API;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ImportRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Http\Responses\User\{
    SingleUserResponse,
    UserCollectionResponse
};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Org_Heigl\Ghostscript\Ghostscript;
use Spatie\PdfToImage\Pdf;
use Symfony\Component\HttpFoundation\JsonResponse;

use Imagick;

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
    public function store(UserRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) : SingleUserResponse
    {
       /* $myModel = User::find(3);
       $myModel->addMedia("C:\Users\Euvince\OneDrive\Documents\Cours IG-2\Mes Cours IG2\Anglais\ENEAM Year 2 Book.pdf")
            ->preservingOriginal()
            ->toMediaCollection('pdfs'); */

        /* $myModel = User::find(3);
        $myModel->addMediaFromUrl("https://placehold.co/600x400/png")
                ->toMediaCollection(); */

        /* dd(file_exists(public_path("pdfs/file.pdf")));
        Ghostscript::setGsPath(path : "C:\Program Files\gs\gs10.03.1\bin\gswin64c.exe");
        $pdf = new Pdf(public_path("pdfs/file.pdf"));
        $pdf->format(outputFormat : \Spatie\PdfToImage\Enums\OutputFormat::Jpg)->save(public_path("Images")); */

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
    public function update(UserRequest $request, User $user) : SingleUserResponse
    {
        $data = $request->validated();
        $user->update($data);
        if (array_key_exists('roles', $data)) {
            $user->roles()->sync($request['roles']);
            foreach ($user->permissions as $permission) {
                $user->revokePermissionTo($permission);
            }
            foreach($request['roles'] as $role){
                foreach (Role::find($role)->permissions as $permission) {
                    $user->givePermissionTo($permission->name);
                }
            }
        }
        return new SingleUserResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Utilisateur modifié avec succès",
            resource : new UserResource(resource : User::query()->with(['roles', 'permissions'])->where('id', $user->id)->first())
        );
    }


    /**
     * Check if the specified resource has any children.
    */
    public function checkChildrens (User $user) : JsonResponse
    {
        $rolesCount = $user->roles()->count();
        $commentsCount = $user->comments()->count();
        $permissionsCount = $user->permissions()->count();
        $subscriptionsCount = $user->subscriptions()->count();
        $hasChildrens = ($commentsCount > 0 || $subscriptionsCount > 0) ? true : false;
        $message = $hasChildrens === true
            ? "Attention, cet utilisateur est relié à certaines données, souhaitez vous-vraiment le supprimer ?"
            : "Voulez-vous vraiment supprimer cet utilisateur ?, attention, cette action est irréversible.";

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
    public function destroy(User $user) : JsonResponse
    {
        $user->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "L'utilisateur a été supprimé avec succès",],
        );
    }

    /**
     * Remove many specified resources from storage
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function destroyUsers (UserRequest $request) : JsonResponse
    {
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            User::find($id)->delete();
        }, $ids);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => count($ids) > 1
                    ? "Les utilisateurs ont été supprimés avec succès"
                    : "L'utilisateur a été supprimé avec succès"
            ],
        );
    }


    /**
     * Give Access to Students
     * @param User $user [explicite description]
     * @return JsonResponse
     */
    public function giveAccessToUser (User $user) : JsonResponse
    {
        if ($user->hasAnyRole(
            roles : [
                'Etudiant-Externe', 'Etudiant-Eneamien'
            ]
        ) && (!User::hasPaid($user) && !User::hasAccess($user))) {
            User::markAsHasPaid($user);
            User::markAsHasAccess($user);
            \App\Models\Subscription::create([
                'user_id' => $user->id
            ]);
            return response()->json(
                status : 200,
                data : ["message" => "L'opération a été éffectuée avec succès."],
            );
        }
        else {
            return response()->json(
                status : 403,
                data : ["message" => "Cette opération n'est possible que sur les étudiants n'ayant pas encore validé leur abonnement."],
            );
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function getUsers() : View
    {
        $users = User::get();
        return view('users', compact('users'));
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(ImportRequest $request) : RedirectResponse
    {
        Excel::import(new UsersImport($request), $request->file);
        return back()->with(['success' => "Données importées avec succès"]);
    }

}
