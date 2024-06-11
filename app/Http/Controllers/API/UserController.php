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
use Illuminate\Http\Request;
use Org_Heigl\Ghostscript\Ghostscript;
use Spatie\PdfToImage\Pdf;
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

        /* $pdf = new \Spatie\PdfToImage\Pdf("C:\Users\Euvince\OneDrive\Documents\Cours IG-2\Mes Cours IG2\Base de Données\TP en Oracle.pdf");
        Ghostscript::setGsPath("C:\Program Files\gs\gs10.03.1\bin\gswin64c.exe");
        $pdf->save(storage_path('app/public/test.jpg')); */

        $pdf_file = public_path() . "\pdfs\\file.pdf";
        $output_path = public_path() . "\Images\\rashid%d";
        Ghostscript::setGsPath(path : "C:\Program Files\gs\gs10.03.1\bin\gswin64c.exe");
        $pdf = new Pdf($pdf_file);
        $pdf->format(outputFormat : \Spatie\PdfToImage\Enums\OutputFormat::Png)->save($output_path);

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


    // Tests sur le package maatwebsite excel

    /**
    * @return \Illuminate\Support\Collection
    */
    public function getUsers()
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
    public function import(ImportRequest $request)
    {
        Excel::import(new UsersImport,$request->file);
        /* Excel::import(new UsersImport,request()->file('file')); */
        return back()->with(['success' => "Données importées avec succès"]);
    }

}
