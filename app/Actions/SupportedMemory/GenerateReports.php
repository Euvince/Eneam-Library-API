<?php

namespace App\Actions\SupportedMemory;

use ZipArchive;
use Carbon\Carbon;
use App\Models\Configuration;
use PhpOffice\PhpWord\PhpWord;
use App\Models\SupportedMemory;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpWord\SimpleType\JcTable;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Http\Requests\SupportedMemory\SupportedMemoryRequest;

class GenerateReports
{

    public static function printReportUsingBladeView (SupportedMemory $supportedMemory)
    {
        if (SupportedMemory::isValide($supportedMemory)) {
            $supportedMemory->update([
                'printed_number' => ++$supportedMemory->printed_number,
            ]);
            $pdf = FacadePdf::loadView(view : 'fiche', data : [
                'memory' => $supportedMemory,
                'config' => Configuration::appConfig(),
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


    public static function printReportsUsingBladeView (SupportedMemoryRequest $request)
    {
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
                        'config' => Configuration::appConfig(),
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


    public static function printReportUsingWord (SupportedMemory $memory)
    {
        $config = Configuration::appConfig();
        $now = Carbon::parse(Carbon::now())->translatedFormat("l d F Y");;
        $document = new PhpWord();
        $section = $document->addSection();
        $document->addTitleStyle(1, ['bold' => true, 'size' => 13], ['align' => 'start']);
        $section->addTitle(mb_strtoupper($config->school_name), 1);
        $section->addText('FICHE DE DÉPÔT DE MÉMOIRE', ['size' => 11], ['align' => 'center', 'spaceAfter' => 350, 'spaceBefore' => 350]);
        $section->addText($config->school_city.', le '.$now, ['size' => 11], ['align' => 'end', 'spaceAfter' => 430]);
        $tableStyle = [
            'width' => 100 * 50, // 100% de la largeur
            'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT,
            'alignment' => JcTable::CENTER,
        ];

        $table = $section->addTable($tableStyle);
        $table->addRow();
        $table->addCell(width : 100 * 50)->addText("NOM ET PRENOM DE L'ÉTUDIANT : ". $memory->first_author_firstname." ".$memory->first_author_lastname, ['size' => 12], ['spaceAfter' => 350]);
        $table->addRow();
        $table->addCell(width : 100 * 50)->addText("FILIÈRE &amp; CLASSE : Gestion des Banques, assurance, finances, comptabilité/Banques, finances, assurance, budget" /* $memory->sector->sector->name."/".$memory->sector->name */, ['size' => 12], ['spaceAfter' => 350]);
        $table->addRow();
        $table->addCell(width : 100 * 50)->addText("PROMOTION : ". $memory->soutenance->schoolYear->school_year, ['size' => 12], ['spaceAfter' => 350]);
        $table->addRow();
        $table->addCell(width : 100 * 50)->addText("THÈME : ". $memory->theme, ['size' => 12, 'spaceAfter' => 800]);
        $table->addRow();
        $table->addCell(width : 100 * 50)->addText("SIGNATURE DE L'ÉTUDIANT");
        $table->addCell(width : 100 * 50)->addText("SIGNATURE CHEF SERVICE DOCUMENTATION ET ARCHIVES");
        $section->addText($config->archivist_full_name, ['size' => 11], ['align' => 'end', 'spaceAfter' => 430]);

        $writer = IOFactory::createWriter($document, 'Word2007');
        $writer->save('fiche-depot.docx');
    }


    public static function printReportsUsingWord (SupportedMemoryRequest $request)
    {
    }

}
