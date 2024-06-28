<?php

namespace App\Actions\SupportedMemory;

use ZipArchive;
use App\Models\SupportedMemory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Http\Requests\SupportedMemory\SupportedMemoryRequest;

class GenerateReports
{

    public static function printReportUsingBladeView (SupportedMemory $supportedMemory) {

        if (SupportedMemory::isValide($supportedMemory)) {
            $supportedMemory->update([
                'printed_number' => ++$supportedMemory->printed_number,
            ]);
            $pdf = FacadePdf::loadView(view : 'fiche', data : [
                'memory' => $supportedMemory,
                'config' => \App\Models\Configuration::appConfig(),
            ])
            ->setOptions(['defaultFont' => 'sans-serif'])
            ->setPaper('A4', 'portrait');

            $firstAuthorName = $supportedMemory->first_author_firstname;
            $secondAuthorName = $supportedMemory->second_author_firstname;
            $filename = $secondAuthorName !== NULL
                ? $firstAuthorName."-".$secondAuthorName.".pdf"
                : $firstAuthorName.".pdf";

            return $pdf->download(
                filename : $filename
            );
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
                data : ['message' => "Impossible d'imprimer la fiche de dépôt d'un mémoire soutenu invalidé"],
            );
        }
    }

    public static function printReportsUsingBladeView (SupportedMemoryRequest $request) {

        $ids = $request->validated('ids');

        $validMemories = SupportedMemory::whereIn('id', $ids)
            ->where('status', "Invalidé")
            ->count();

        if ($validMemories > 0) {
            return response()->json(
                status : 200,
                headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
                data : ['message' => "Certains mémoires envoyés ne sont pas encore validés"],
            );
        }
        else {
            $sourcePath = storage_path('app/public/SupportedMemories');
            $zipFileName = 'fiches.zip';
            $tempPath = storage_path('app/temp');
            if (!File::exists($tempPath)) {
                File::makeDirectory($tempPath, 0755, true);
            }
            $zipFilePath = $tempPath.'/'.$zipFileName;
            $zip = new ZipArchive();

            if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
                array_map(function (int $id) use ($zip) {
                    $supportedMemory = SupportedMemory::find($id);
                    $supportedMemory->update([
                        'printed_number' => ++$supportedMemory->printed_number,
                    ]);
                    $pdf = FacadePdf::loadView(view : 'fiche', data : [
                        'memory' => $supportedMemory,
                        'config' => \App\Models\Configuration::appConfig(),
                    ])
                    ->setOptions(['defaultFont' => 'sans-serif'])
                    ->setPaper('A4', 'portrait');

                    $firstAuthorName = $supportedMemory->first_author_firstname;
                    $secondAuthorName = $supportedMemory->second_author_firstname;
                    $filename = $secondAuthorName !== NULL
                        ? $firstAuthorName."-".$secondAuthorName.".pdf"
                        : $firstAuthorName.".pdf";

                    Storage::put(path : 'public/fiches/' . $filename, contents : $pdf->output());
                    $zip->addFile(public_path(path : 'storage/fiches/'). $filename, $filename);
                    $supportedMemory->update([
                        'printed_number' => ++$supportedMemory->printed_number
                    ]);
                }, $ids);

                $zip->close();
                Storage::delete(paths : ['public/fiches/']);

            }
            return Response::download($zipFilePath, $zipFileName)->deleteFileAfterSend();
        }
    }

    public static function printReportUsingWord () {

    }

    public static function printReportsUsingWord () {

    }

}
