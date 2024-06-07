<?php

namespace App\Actions\Article;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleHelper
{
    public static function handle (Article $article, Request $request) {
        $data = $request->validated();
        if(array_key_exists('access_paths', $data) &&  array_key_exists('thumbnail', $data))
        {
            /** @var UploadedFile|null $accessPathsCollection */
            $accessPathsCollection = $data['access_paths'];
            /** @var UploadedFile|null $thumbanailCollection */
            $thumbanailsPathsCollection = $data['thumbnails_path'];
            $data['access_paths'] = $accessPathsCollection->storeAs('Articles/Articles', $request->file('access_paths')->getClientOriginalName(), 'public');
            $data['thumbnails_path'] = $thumbanailsPathsCollection->storeAs('Articles/Cover pages', $request->file('thumbnails_path')->getClientOriginalName(), 'public');
            $memorypath = 'public/' . $supportedMemory->file_path;
            $coverPagePath = 'public/' . $supportedMemory->cover_page_path;
            if(Storage::exists($memorypath)) Storage::delete($memorypath);
            if(Storage::exists($coverPagePath)) Storage::delete($coverPagePath);
        }
        return $data;
    }

}
