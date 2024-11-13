<?php

namespace App\Http\Controllers\API;

use Imagick;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\ImportRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Role;
use App\Models\User;
use App\Http\Responses\User\{
    SingleUserResponse,
    UserCollectionResponse
};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Org_Heigl\Ghostscript\Ghostscript;
use Spatie\PdfToImage\Pdf;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Jobs\AskAgainEmailVerificationLinkJob;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

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
            collection : User::query()->with(['roles', 'permissions'])->orderBy('created_at', 'desc')->get()/* paginate(perPage : 20) */,
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
        $pdf->format(outputFormat : \Spatie\PdfToImage\Enums\OutputFormat::Jpg)->save(public_path("images")); */

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
        /* unset($data['roles']); */
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
        if ($data['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            AskAgainEmailVerificationLinkJob::dispatch($user);
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
        $this->authorize('checkChildrens', $user);
        // $rolesCount = $user->roles()->count();
        $commentsCount = $user->comments()->count();
        $remindersCount = $user->reminders()->count();
        // $permissionsCount = $user->permissions()->count();
        $subscriptionsCount = $user->subscriptions()->count();
        $supportedMemoriesCount = $user->supportedMemories()->count();
        $hasChildrens = (
                $commentsCount > 0 || $subscriptionsCount > 0 ||
                $supportedMemoriesCount > 0 || $remindersCount > 0
            )
            ? true
            : false;
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
        if(($profilPictureFilePath = $user->profile_picture_path) !== '') {
            $path = 'public/'.$profilPictureFilePath;
            if(Storage::exists($path)) Storage::delete($path);
        }
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
        /* $this->authorize('delete', User::class); */
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            $user = User::find($id);
            $user->delete();
            if(($profilPictureFilePath = $user->profil_picture_path) !== '') {
                $path = 'public/'.$profilPictureFilePath;
                if(Storage::exists($path)) Storage::delete($path);
            }
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
        /* $this->authorize('giveAccessToUser', $user); */
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
                data : ["message" => "Cette opération n'est possible que sur les étudiants n'ayant pas encore accès à la bibliothèque."],
            );
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function getUsers() : View
    {
        $users = User::paginate(30);
        return view('users', compact('users'));
    }

    /**
     * Method importUsers
     *
     * @param ImportRequest $request [explicite description]
     */
    public function importUsers(ImportRequest $request) : RedirectResponse | JsonResponse
    {
        /* $this->authorize('importUsers', User::class); */
        /* if ($request->routeIs("import.eneamiens.students")) {
            $students = User::query()
                ->whereHas(relation : 'roles', callback : function (Builder $query) {
                    $query->where('name', "Etudiant-Eneamien");
                })->get();
            foreach ($students as $student) {
                $student->permissions()->detach();
                $student->roles()->detach();
                $student->forceDelete();
            }
        }

        else if ($request->routeIs("import.teachers")) {
            $teachers = User::query()
                ->whereHas(relation : 'roles', callback : function (Builder $query) {
                    $query->where('name', "Enseignant");
                })->get();
            foreach ($teachers as $teacher) {
                $teacher->permissions()->detach();
                $teacher->roles()->detach();
                $teacher->delete();
            }
        } */

        $message = $request->routeIs('import.teachers')
            ? "Enseignants importés avec succès"
            : "Étudiants énéamiens importés avec succès";

        try {
            Excel::import(new UsersImport($request), $request->file);
            return str_contains(request()->route()->uri(), 'api')
                ?  response()->json(
                        status : 200,
                        data : ['message' => $message]
                    )
                :  (request()->routeIs('teachers.import')
                        ? back()->with(['success' => $message])
                        : back()->with(['success' => $message])
                    );
        }catch(\Exception $e) {
            return (int)$e->getCode() === 23000
                ? (str_contains(request()->route()->uri(), 'api')
                        ? response()->json(
                                status : 200,
                                data : ['message' => "Un ou plusieurs enrégistrement(s) dans le fichier existent déjà, veuillez vérifier vos données"]
                            )
                        : back()->with(['error' => "Un ou plusieurs enrégistrement(s) dans le fichier existent déjà, veuillez vérifier vos données"])
                    )
                : back()->with(['error' => "Une erreur est survenue lors de l'enrégistrement des données."]);
        }
    }

    public function exportUsers()
    {
        /* $this->authorize('exportUsers', User::class); */
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}
