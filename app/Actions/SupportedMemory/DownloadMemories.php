<?php

namespace App\Actions\SupportedMemory;

use App\Http\Requests\SupportedMemory\SupportedMemoryRequest;
use ZipArchive;
use Illuminate\Http\Request;
use App\Models\SupportedMemory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class DownloadMemories
{

    public static function downloadMemory (SupportedMemory $supportedMemory) {
        $supportedMemory->update([
            'download_number' => ++$supportedMemory->download_number,
        ]);
        $firstAuthorName = $supportedMemory->first_author_firstname;
        $secondAuthorName = $supportedMemory->second_author_firstname;
        $filename = $secondAuthorName !== NULL
            ? $firstAuthorName."-".$secondAuthorName.".pdf"
            : $firstAuthorName.".pdf";

        return Storage::download(
            path : 'public/' . $supportedMemory->file_path,
            name : $filename
        );
    }

    public static function downloadMemories (SupportedMemoryRequest $request) {

        $ids = $request->validated('ids');

        $sourcePath = storage_path('app/public/SupportedMemories');
        $zipFileName = 'mémoires.zip';
        $tempPath = storage_path('app/temp');
        if (!File::exists($tempPath)) {
            File::makeDirectory($tempPath, 0755, true);
        }
        $zipFilePath = $tempPath.'/'.$zipFileName;
        $zip = new ZipArchive();

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            foreach ($ids as $id) {
                $supportedMemory = SupportedMemory::find($id);
                $firstAuthorName = $supportedMemory->first_author_firstname;
                $secondAuthorName = $supportedMemory->second_author_firstname;
                $filename = $secondAuthorName !== NULL
                    ? $firstAuthorName."-".$secondAuthorName."pdf"
                    : $firstAuthorName.".pdf";
                $zip->addFile(public_path(path : 'storage/'). $supportedMemory->file_path, $filename);
                $supportedMemory->update([
                    'download_number' => ++$supportedMemory->download_number
                ]);
            }
            $zip->close();
        }
        return Response::download($zipFilePath, $zipFileName)->deleteFileAfterSend();
    }

}
