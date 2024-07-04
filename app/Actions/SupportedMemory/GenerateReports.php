<?php

namespace App\Actions\SupportedMemory;

use ZipArchive;
use Carbon\Carbon;
use Spatie\PdfToText\Pdf;
use Illuminate\Http\Request;
use App\Models\Configuration;
use PhpOffice\PhpWord\PhpWord;
use App\Models\SupportedMemory;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\Element\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Http\Requests\SupportedMemory\SupportedMemoryRequest;
use App\Jobs\SendFilingReportSignedJob;

class GenerateReports
{

    public static function printReportUsingBladeView (SupportedMemory $memory)
    {
        if (SupportedMemory::isValide($memory)) {
            $memory->update([
                'printed_number' => ++$memory->printed_number,
            ]);
            $pdf = FacadePdf::loadView(view : 'fiche', data : [
                'memory' => $memory,
                'config' => Configuration::appConfig(),
                'qrCodeImg' => self::getImage(public_path(path : "images/47698.png"))
            ])
            ->setOptions(['defaultFont' => 'sans-serif'])
            ->setPaper('A4', 'portrait');

            $firstAuthorName = $memory->first_author_firstname;
            $secondAuthorName = $memory->second_author_firstname;
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


    public static function printReportsUsingBladeView (/* SupportedMemoryRequest $request */)
    {
        /* $ids = $request->validated('ids'); */
        $ids = [148, 149, 150, 151];

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
                        'qrCodeImg' => self::getImage(public_path(path : "images/47698.png"))
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
                }, $ids);

                $zip->close();
            }
            Storage::deleteDirectory(directory : 'public/fiches/');
            return Response::download($zipFilePath, $zipFileName)->deleteFileAfterSend();
        }
    }


    public static function printReportUsingWord (SupportedMemory $memory)
    {
        if (SupportedMemory::isValide($memory)) {
            $memory->update([
                'printed_number' => ++$memory->printed_number,
            ]);
            $config = Configuration::appConfig();
            $now = Carbon::parse(Carbon::now())->translatedFormat("l d F Y");
            $imagePath = public_path(path : "images/47698.png");
            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $document = new PhpWord();
            $sectionStyles = [
                'marginTop' => 700,
                'marginBottom' => 400,
            ];
            $section1 = $document->addSection($sectionStyles);
            $document->addTitleStyle(1, ['bold' => true, 'size' => 13], ['align' => 'start']);
            $section1->addTitle(mb_strtoupper($config->school_name), 1);
            $section1->addText('FICHE DE DÉPÔT DE MÉMOIRE : '.Carbon::parse($memory->soutenance->start_date)->year."-".$memory->sector->acronym."-".$memory->id,
                ['size' => 11], ['align' => 'center', 'spaceBefore' => 250, 'spaceAfter' => 250]
            );
            $section1->addText($config->school_city.', le '.$now, ['size' => 11], ['align' => 'end', 'spaceAfter' => 250]);

            $table1 = $section1->addTable();
            $table1->addRow();
            $table1->addCell(width : 32500)->addText("NOM ET PRÉNOMS : " .$memory->first_author_firstname." ".$memory->first_author_lastname, ['size' => 11], ['spaceAfter' => 280]);
            $table1->addRow();
            $table1->addCell(width : 32500)->addText("FILIÈRE & CLASSE : " .$memory->sector->sector->name."/".$memory->sector->name, ['size' => 11], ['spaceAfter' => 280]);
            $table1->addRow();
            $table1->addCell(width : 32500)->addText("PROMOTION : " .$memory->soutenance->schoolYear->school_year, ['size' => 11], ['spaceAfter' => 280]);
            $table1->addRow();
            $table1->addCell(width : 32500)->addText("THÈME : " .$memory->theme, ['size' => 11], ['spaceAfter' => 410]);
            $bottomTable1 = $section1->addTable();
            $bottomTable1->addRow();
            $bottomTable1->addCell(width : 16000)->addText("SIGNATURE DE L'ÉTUDIANT");
            $bottomTable1->addCell(width : 24000)->addText("SIGNATURE CHEF SERVICE DOCUMENTATION ET ARCHIVES", ['align' => 'end']);
            $bottomTable1->addRow();
            $bottomTable1->addCell()->addImage(
                $imagePath, [
                    'width' => 45,
                    'height' => 45,
                    /* 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, */
                ]
            );
            $bottomTable1->addCell()->addText($config->archivist_full_name, ['size' => 11], ['align' => 'center', 'spaceBefore' => 600, 'spaceAfter' => 300]);

            $section1->addText("...............................................................................................................................................................", ['bold' =>true], ['spaceAfter' => 420]);

            $document->addTitleStyle(1, ['bold' => true, 'size' => 13], ['align' => 'start']);
            $section1->addTitle(mb_strtoupper($config->school_name), 1);
            $section1->addText('FICHE DE DÉPÔT DE MÉMOIRE : '.Carbon::parse($memory->soutenance->start_date)->year."-".$memory->sector->acronym."-".$memory->id,
                ['size' => 11], ['align' => 'center', 'spaceBefore' => 250, 'spaceAfter' => 250]
            );
            $section1->addText($config->school_city.', le '.$now, ['size' => 11], ['align' => 'end', 'spaceAfter' => 250]);

            $table2 = $section1->addTable();
            $table2->addRow();
            $table2->addCell(width : 32500)->addText("NOM ET PRÉNOMS : " .$memory->second_author_firstname." ".$memory->second_author_lastname, ['size' => 11], ['spaceAfter' => 280]);
            $table2->addRow();
            $table2->addCell(width : 32500)->addText("FILIÈRE & CLASSE : " .$memory->sector->sector->name."/".$memory->sector->name, ['size' => 11], ['spaceAfter' => 280]);
            $table2->addRow();
            $table2->addCell(width : 32500)->addText("PROMOTION : " .$memory->soutenance->schoolYear->school_year, ['size' => 11], ['spaceAfter' => 280]);
            $table2->addRow();
            $table2->addCell(width : 32500)->addText("THÈME : " .$memory->theme, ['size' => 11], ['spaceAfter' => 410]);
            $bottomTable2 = $section1->addTable();
            $bottomTable2->addRow();
            $bottomTable2->addCell(width : 16000)->addText("SIGNATURE DE L'ÉTUDIANT");
            $bottomTable2->addCell(width : 24000)->addText("SIGNATURE CHEF SERVICE DOCUMENTATION ET ARCHIVES", ['align' => 'end']);
            $bottomTable2->addRow();
            $bottomTable2->addCell()->addImage(
                $imagePath, [
                    'width' => 45,
                    'height' => 45,
                    /* 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, */
                ]
            );
            $bottomTable2->addCell()->addText($config->archivist_full_name, ['size' => 11], ['align' => 'center', 'spaceBefore' => 600]);

            $firstAuthorName = $memory->first_author_firstname;
            $secondAuthorName = $memory->second_author_firstname;
            $filename = $secondAuthorName !== NULL
                ? $firstAuthorName."-".$secondAuthorName.".docx"
                : $firstAuthorName.".docx";

            $writer = IOFactory::createWriter($document, 'Word2007');
            $writer->save($filename);
            return Response::download(public_path(path : $filename))->deleteFileAfterSend();
        }
        else {
            return response()->json(
                status : 403,
                headers : ["Allow" => 'GET, POST, PATCH, DELETE'],
                data : ['message' => "Impossible d'imprimer la fiche de dépôt d'un mémoire soutenu invalidé"],
            );
        }
    }


    public static function printReportsUsingWord (/* SupportedMemoryRequest $request */)
    {
       /*  $ids = $request->validated('ids'); */
       $ids = [148, 149, 150, 151];

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
                    $memory = SupportedMemory::find($id);
                    $memory->update([
                        'printed_number' => ++$memory->printed_number,
                    ]);

                    $config = Configuration::appConfig();
                    $now = Carbon::parse(Carbon::now())->translatedFormat("l d F Y");
                    \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
                    $document = new PhpWord();
                    $sectionStyles = [
                        'marginTop' => 700,
                        'marginBottom' => 400,
                    ];
                    $section1 = $document->addSection($sectionStyles);
                    $document->addTitleStyle(1, ['bold' => true, 'size' => 13], ['align' => 'start']);
                    $section1->addTitle(mb_strtoupper($config->school_name), 1);
                    $section1->addText('FICHE DE DÉPÔT DE MÉMOIRE : '.Carbon::parse($memory->soutenance->start_date)->year."-".$memory->sector->acronym."-".$memory->id,
                        ['size' => 11], ['align' => 'center', 'spaceBefore' => 250, 'spaceAfter' => 250]
                    );
                    $section1->addText($config->school_city.', le '.$now, ['size' => 11], ['align' => 'end', 'spaceAfter' => 250]);

                    $table1 = $section1->addTable();
                    $table1->addRow();
                    $table1->addCell(width : 32500)->addText("NOM ET PRÉNOMS : " .$memory->first_author_firstname." ".$memory->first_author_lastname, ['size' => 11], ['spaceAfter' => 280]);
                    $table1->addRow();
                    $table1->addCell(width : 32500)->addText("FILIÈRE & CLASSE : " .$memory->sector->sector->name."/".$memory->sector->name, ['size' => 11], ['spaceAfter' => 280]);
                    $table1->addRow();
                    $table1->addCell(width : 32500)->addText("PROMOTION : " .$memory->soutenance->schoolYear->school_year, ['size' => 11], ['spaceAfter' => 280]);
                    $table1->addRow();
                    $table1->addCell(width : 32500)->addText("THÈME : " .$memory->theme, ['size' => 11], ['spaceAfter' => 410]);
                    $bottomTable1 = $section1->addTable();
                    $bottomTable1->addRow();
                    $bottomTable1->addCell(width : 16000)->addText("SIGNATURE DE L'ÉTUDIANT");
                    $bottomTable1->addCell(width : 24000)->addText("SIGNATURE CHEF SERVICE DOCUMENTATION ET ARCHIVES", ['align' => 'end']);
                    $bottomTable1->addRow();
                    $bottomTable1->addCell();
                    $bottomTable1->addCell()->addText($config->archivist_full_name, ['size' => 11], ['align' => 'center', 'spaceBefore' => 600, 'spaceAfter' => 300]);

                    $section1->addText("...............................................................................................................................................................", ['bold' =>true], ['spaceAfter' => 420]);

                    $document->addTitleStyle(1, ['bold' => true, 'size' => 13], ['align' => 'start']);
                    $section1->addTitle(mb_strtoupper($config->school_name), 1);
                    $section1->addText('FICHE DE DÉPÔT DE MÉMOIRE : '.Carbon::parse($memory->soutenance->start_date)->year."-".$memory->sector->acronym."-".$memory->id,
                        ['size' => 11], ['align' => 'center', 'spaceBefore' => 250, 'spaceAfter' => 250]
                    );
                    $section1->addText($config->school_city.', le '.$now, ['size' => 11], ['align' => 'end', 'spaceAfter' => 250]);

                    $table2 = $section1->addTable();
                    $table2->addRow();
                    $table2->addCell(width : 32500)->addText("NOM ET PRÉNOMS : " .$memory->second_author_firstname." ".$memory->second_author_lastname, ['size' => 11], ['spaceAfter' => 280]);
                    $table2->addRow();
                    $table2->addCell(width : 32500)->addText("FILIÈRE & CLASSE : " .$memory->sector->sector->name."/".$memory->sector->name, ['size' => 11], ['spaceAfter' => 280]);
                    $table2->addRow();
                    $table2->addCell(width : 32500)->addText("PROMOTION : " .$memory->soutenance->schoolYear->school_year, ['size' => 11], ['spaceAfter' => 280]);
                    $table2->addRow();
                    $table2->addCell(width : 32500)->addText("THÈME : " .$memory->theme, ['size' => 11], ['spaceAfter' => 410]);
                    $bottomTable2 = $section1->addTable();
                    $bottomTable2->addRow();
                    $bottomTable2->addCell(width : 16000)->addText("SIGNATURE DE L'ÉTUDIANT");
                    $bottomTable2->addCell(width : 24000)->addText("SIGNATURE CHEF SERVICE DOCUMENTATION ET ARCHIVES", ['align' => 'end']);
                    $bottomTable2->addRow();
                    $bottomTable2->addCell();
                    $bottomTable2->addCell()->addText($config->archivist_full_name, ['size' => 11], ['align' => 'center', 'spaceBefore' => 600]);

                    $firstAuthorName = $memory->first_author_firstname;
                    $secondAuthorName = $memory->second_author_firstname;
                    $filename = $secondAuthorName !== NULL
                        ? $firstAuthorName."-".$secondAuthorName.".docx"
                        : $firstAuthorName.".docx";

                    $writer = IOFactory::createWriter($document, 'Word2007');
                    $writer->save($filename);

                    $directory = "storage/fiches/";
                    if (!File::exists(public_path($directory))) {
                        File::makeDirectory(public_path(path : $directory), 0755, true);
                    }
                    rename(public_path(path : $filename), public_path(path : $directory . $filename));
                    $zip->addFile(public_path(path : $directory . $filename), $filename);
                }, $ids);

                $zip->close();
            }
            Storage::deleteDirectory(directory : 'public/fiches/');
            return Response::download($zipFilePath, $zipFileName)->deleteFileAfterSend();
        }
    }

    public static function importPdfsReports (Request $request) : void {
        foreach ($request->files as $file) {
            $text = Pdf::getText($file, "C:\Program Files\pdftotext\pdftotext.exe");
            preg_match("/\d{4}-[A-Z]+-\d+/", $text, $matches);
            $memory = SupportedMemory::find((int)explode('-', $matches[0])[2]);
            SendFilingReportSignedJob::dispatch($memory);
        }
    }

    public static function importWordsReports (Request $request) : void {
        foreach ($request->files as $file) {
            $loadedFile = IOFactory::load(filename : $file);
            $text = "";
            foreach($loadedFile->getSections() as $section) {
                foreach($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    }
                    else if ($element instanceof Table) {
                        foreach ($element->getRows() as $row) {
                            foreach ($row->getCells() as $cell) {
                                foreach ($cell->getElements() as $cellElement) {
                                    if (method_exists($cellElement, 'getText')) {
                                        $text .= $cellElement->getText() . "\t";
                                    }
                                }
                            }
                            $text .= "\n";
                        }
                    }
                }
            }
            preg_match("/\d{4}-[A-Z]+-\d+/", $text, $matches);
            $memory = SupportedMemory::find((int)explode('-', $matches[0])[2]);
            SendFilingReportSignedJob::dispatch($memory);
        }
    }


    public static function getImage(string $path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

}
