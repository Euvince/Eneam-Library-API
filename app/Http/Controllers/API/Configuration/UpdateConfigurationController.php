<?php

namespace App\Http\Controllers\API\Configuration;

use File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ConfigurationRequest;

class UpdateConfigurationController extends Controller
{
    /**
     * Edit an application configuration attribute.
     */
    public function __invoke(ConfigurationRequest $request)
    {
       /*  $this->authorize('updateConfiguration', Configuration::class); */
        $routeName = $request->route()->getName();
        $config = Configuration::appConfig();
        if (Str::contains($routeName, 'school-name')) $config->update(['school_name' => $request->school_name]);
        if (Str::contains($routeName, 'school-acronym')) $config->update(['school_acronym' => $request->school_acronym]);
        if (Str::contains($routeName, 'school-city')) $config->update(['school_city' => $request->school_city]);
        if (Str::contains($routeName, 'archivist-full-name')) $config->update(['archivist_full_name' => $request->archivist_full_name]);
        if (Str::contains($routeName, 'archivist-signature')) $config->update(['archivist_signature' => self::fileTraitment($request, $config)['archivist_signature']]);
        if (Str::contains($routeName, 'eneamien-subscribe-amount')) $config->update(['eneamien_subscribe_amount' => $request->eneamien_subscribe_amount]);
        if (Str::contains($routeName, 'extern-subscribe-amount')) $config->update(['extern_subscribe_amount' => $request->extern_subscribe_amount]);
        if (Str::contains($routeName, 'subscription-expiration-delay')) $config->update(['subscription_expiration_delay' => $request->subscription_expiration_delay]);
        if (Str::contains($routeName, 'student-debt-amount')) $config->update(['student_debt_amount' => $request->student_debt_amount]);
        if (Str::contains($routeName, 'teacher-debt-amount')) $config->update(['teacher_debt_amount' => $request->teacher_debt_amount]);
        if (Str::contains($routeName, 'student-loan-delay')) $config->update(['student_loan_delay' => $request->student_loan_delay]);
        if (Str::contains($routeName, 'teacher-loan-delay')) $config->update(['teacher_loan_delay' => $request->teacher_loan_delay]);
        if (Str::contains($routeName, 'student-renewals-number')) $config->update(['student_renewals_number' => $request->student_renewals_number]);
        if (Str::contains($routeName, 'teacher-renewals-number')) $config->update(['teacher_renewals_number' => $request->teacher_renewals_number]);
        if (Str::contains($routeName, 'max-books-per-student')) $config->update(['max_books_per_student' => $request->max_books_per_student]);
        if (Str::contains($routeName, 'max-books-per-teacher')) $config->update(['max_books_per_teacher' => $request->max_books_per_teacher]);
        if (Str::contains($routeName, 'max-copies-books-per-student')) $config->update(['max_copies_books_per_student' => $request->max_copies_books_per_student]);
        if (Str::contains($routeName, 'max-copies-books-per-teacher')) $config->update(['max_copies_books_per_teacher' => $request->max_copies_books_per_teacher]);

        $message = "";
        if (Str::contains($routeName, 'school-name')) $message = "Le nom de l'école a bien été modifié";
        if (Str::contains($routeName, 'school-acronym')) $message = "L'acronyme de l'école a bien été modifié";
        if (Str::contains($routeName, 'school-city')) $message = "La ville dans laquelle se situe l'école a bien été modifiée";
        if (Str::contains($routeName, 'archivist-full-name')) $message = "Le nom et le(s) prénom(s) de l'archiviste ont bien été modifié";
        if (Str::contains($routeName, 'archivist-signature')) $message = "La signature de l'archiviste a bien été modifiée";
        if (Str::contains($routeName, 'eneamien-subscribe-amount')) $message = "Le montant d'abonnement des étudiants internes a bien été modifié";
        if (Str::contains($routeName, 'extern-subscribe-amount')) $message = "Le montant d'abonnement des étudiants externes a bien été modifié";
        if (Str::contains($routeName, 'subscription-expiration-delay')) $message = "Le délai d'expiration d'un abonnement a bien été modifié";
        if (Str::contains($routeName, 'student-debt-amount')) $message = "Le montant des frais appliquées aux étudiants internes pour chaque jour exédant un retour de livre a bien été modifié";
        if (Str::contains($routeName, 'teacher-debt-amount')) $message = "Le montant des frais appliquées aux enseignants pour chaque jour exédant un retour de livre a bien été modifié";
        if (Str::contains($routeName, 'student-loan-delay')) $message = "La durée maximale d'un prêt de livre pour un étudiant a bien été modifié";
        if (Str::contains($routeName, 'teacher-loan-delay')) $message = "La durée maximale d'un prêt de livre pour un enseignant a bien été modifié";
        if (Str::contains($routeName, 'student-renewals-number')) $message = "Le nombre de renouvellements maximal d'un prêt de livre pour un étudiant a bien été modifié";
        if (Str::contains($routeName, 'teacher-renewals-number')) $message = "Le nombre de renouvellements maximal d'un prêt de livre pour un enseignant a bien été modifié";
        if (Str::contains($routeName, 'max-books-per-student')) $message = "Le nombre de livres maximal empruntables par un étudiant a bien été modifié";
        if (Str::contains($routeName, 'max-books-per-teacher')) $message = "Le nombre de livres maximal empruntables par un enseignant a bien été modifié";
        if (Str::contains($routeName, 'max-copies-books-per-student')) $message = "Le nombre d'exemplaires maximal d'un livre empruntable par un étudiant";
        if (Str::contains($routeName, 'max-copies-books-per-teacher')) $message = "Le nombre d'exemplaires maximal d'un livre empruntable par un enseignant";

        return response()->json(
            status : 200,
            headers : ["Allow" => 'PATCH'],
            data : ['message' => $message],
        );
    }

    private static function fileTraitment (ConfigurationRequest $request, Configuration $config) : array {
        /* $validatedData = $request->validate([
            'archivist_signature' => 'required|file'
        ], [
            'archivist_signature.required' => "La signature de l'archivist esr requise",
            'archivist_signature.file' => "La signature de l'archivist doit être un fichier"
        ]); */
        $data = $request->validated();
        /**
         * @var UploadedFile|null $signaturePathCollection
         */
        $signaturePathCollection = $data['archivist_signature'];
        // $data['archivist_signature'] = $signaturePathCollection->storeAs(public_path("images"), "signature.".$request->file('archivist_signature')->getClientOriginalExtension(), 'public');
        $data['archivist_signature'] = $signaturePathCollection->storeAs("images", "signature.".$request->file('archivist_signature')->getClientOriginalExtension(), 'public');
        $archivistSignaturePath = public_path("storage/$config->archivist_signature");
        if(Storage::exists($archivistSignaturePath)) Storage::delete($archivistSignaturePath);
        if (File::exists($archivistSignaturePath)) {
            File::delete($archivistSignaturePath);
        }
        return $data;
    }

}
