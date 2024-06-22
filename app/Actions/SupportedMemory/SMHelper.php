<?php

namespace App\Actions\SupportedMemory;

use Illuminate\Http\Request;
use App\Models\SupportedMemory;
use Illuminate\Support\Facades\Storage;

class SMHelper
{
    public static function helper(SupportedMemory $supportedMemory, Request $request) : array {
        $data = $request->validated();
        if(array_key_exists('file_path', $data) &&  array_key_exists('cover_page_path', $data))
        {
            /** @var UploadedFile|null $memoryCollection */
            $memoryCollection = $data['file_path'];
            /** @var UploadedFile|null $coverPageCollection */
            $coverPageCollection = $data['cover_page_path'];
            $data['file_path'] = $memoryCollection->storeAs('SupportedMemories/memories', time().'-'.$request->file('file_path')->getClientOriginalName(), 'public');
            $data['cover_page_path'] = $coverPageCollection->storeAs('SupportedMemories/cover-pages', time().'-'.$request->file('cover_page_path')->getClientOriginalName(), 'public');
            $memorypath = 'public/' . $supportedMemory->file_path;
            $coverPagePath = 'public/' . $supportedMemory->cover_page_path;
            if(Storage::exists($memorypath)) Storage::delete($memorypath);
            if(Storage::exists($coverPagePath)) Storage::delete($coverPagePath);
        }
        return $data;
    }

    public static function downloadMemories () {

    }

    public static function validateMemories () {

    }

}
