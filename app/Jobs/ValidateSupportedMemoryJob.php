<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Configuration;
use Illuminate\Bus\Queueable;
use PhpOffice\PhpWord\PhpWord;
use App\Models\SupportedMemory;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\ValidateSupportedMemoryMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\SupportedMemory\GenerateReports;

class ValidateSupportedMemoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /* public $deletingWhenMissingModels = true; */

    /* private SupportedMemory $supportedMemory; */

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly SupportedMemory $supportedMemory
    ){
        /* $this->supportedMemory = $supportedMemory->withoutRelations(); */
    }

    /**
     * Execute the job.
     */
    public function handle() : void
    {
        $firstAuthorFullName = $this->supportedMemory->first_author_firstname." ".$this->supportedMemory->first_author_lastname;
        $emails[$firstAuthorFullName] = $this->supportedMemory->first_author_email;

        $secondAuthorFullName = $this->supportedMemory->second_author_firstname." ".$this->supportedMemory->second_author_lastname;
        $emails[$secondAuthorFullName] = $this->supportedMemory->second_author_email;

        $firstAuthorFirstname = $this->supportedMemory->first_author_firstname;
        $secondAuthorFirstname = $this->supportedMemory->second_author_firstname;
        $filename = $secondAuthorFirstname !== NULL
            ? $firstAuthorFirstname."-".$secondAuthorFirstname.".docx"
            : $firstAuthorFirstname.".docx";

        foreach ($emails as $name => $email) {

            /* $file = GenerateReports::generateQrCodeImage($this->supportedMemory->id); */
            $config = Configuration::appConfig();
            $now = Carbon::parse(Carbon::now())->translatedFormat("l d F Y");
            /* $imagePath = public_path(path : "qrcodes/$file"); */
            $signaturePath = public_path(path : "images/signature.png");
            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
            $document = new PhpWord();
            $sectionStyles = [
                'marginTop' => 600,
                'marginBottom' => 200,
            ];
            $section1 = $document->addSection(/* $sectionStyles */);
            $document->addTitleStyle(1, ['bold' => true, 'size' => 13], ['align' => 'start']);
            $section1->addTitle(mb_strtoupper($config->school_name), 1);
            $section1->addText('FICHE DE DÉPÔT DE MÉMOIRE : '.Carbon::parse($this->supportedMemory->soutenance->start_date)->year."-".$this->supportedMemory->sector->acronym."-".$this->supportedMemory->id,
                ['size' => 11], ['align' => 'center', 'spaceBefore' => 300, 'spaceAfter' => 300]
            );
            $section1->addText($config->school_city.', le '.$now, ['size' => 11], ['align' => 'end', 'spaceAfter' => 250]);

            $table1 = $section1->addTable();
            $table1->addRow();
            $table1->addCell(width : 32500)->addText("NOM ET PRÉNOMS : " .$name, ['size' => 11], ['spaceAfter' => 300]);
            $table1->addRow();
            $table1->addCell(width : 32500)->addText("FILIÈRE & CLASSE : " .$this->supportedMemory->sector->sector->name."/".$this->supportedMemory->sector->name, ['size' => 11], ['spaceAfter' => 300]);
            $table1->addRow();
            $table1->addCell(width : 32500)->addText("PROMOTION : " .$this->supportedMemory->soutenance->schoolYear->school_year, ['size' => 11], ['spaceAfter' => 300]);
            $table1->addRow();
            $table1->addCell(width : 32500)->addText("THÈME : " .$this->supportedMemory->theme, ['size' => 11], ['spaceAfter' => 600]);
            $bottomTable1 = $section1->addTable();
            $bottomTable1->addRow();
            $bottomTable1->addCell(width : 16000)->addText("SIGNATURE DE L'ÉTUDIANT");
            $bottomTable1->addCell(width : 24000)->addText("SIGNATURE CHEF SERVICE DOCUMENTATION ET ARCHIVES", ['align' => 'end']);
            $bottomTable1->addRow();
            $bottomTable1->addCell()->addText(' ');
            /* $bottomTable1->addCell()->addImage(
                $imagePath, [
                    'width' => 60,
                    'height' => 60,
                    // 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                ]
            ); */
            $bottomTable1->addCell()->addImage(
                $signaturePath, [
                    'width' => 125,
                    'height' => 100,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                ]
            );
            $bottomTable1->addRow();
            $bottomTable1->addCell();
            $bottomTable1->addCell()->addText($config->archivist_full_name, ['size' => 11], ['align' => 'center', 'spaceBefore' => 50, 'spaceAfter' => 80]);

            $writer = IOFactory::createWriter($document, 'Word2007');
            $writer->save(public_path($filename));
            /* GenerateReports::wordToPdf(
                wordFilePath : public_path($filename),
                memory : $this->supportedMemory,
            ); */

            Mail::send(new ValidateSupportedMemoryMail($filename, $name, $email, $this->supportedMemory));
        }
        File::delete(public_path($filename));
        File::deleteDirectory(public_path('qrcodes'));
        $this->supportedMemory->update([
            'printed_number' => ++$this->supportedMemory->printed_number,
        ]);
    }
}
