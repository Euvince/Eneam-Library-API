<?php

namespace App\Actions\Article;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleHelper
{
    public static function handle (Article $article, Request $request) {
        $data = $request->validated();
        if(array_key_exists('files_paths', $data))
        {
            /** @var UploadedFile|null $filesPathsCollection */
            $filesPathsCollection = $data['files_paths'];
            $data['files_paths'] = json_encode($filesPathsCollection->storeAs('Articles/Articles', time().'-'.$request->file('files_paths')->getClientOriginalName(), 'public'));
            $filespaths = 'public/' . $article->files_paths;
            if(Storage::exists($filespaths)) Storage::delete($filespaths);
        }
        if (array_key_exists('thumbnails_paths', $data)) {
            /** @var UploadedFile|null $thumbanailsPathsCollection */
            $thumbanailsPathsCollection = $data['thumbnails_paths'];
            $data['thumbnails_paths'] = json_encode($thumbanailsPathsCollection->storeAs('Articles/Cover pages', time().'-'.$request->file('thumbnails_paths')->getClientOriginalName(), 'public'));
            $thumbnailspaths = 'public/' . $article->thumbnails_paths;
            if(Storage::exists($thumbnailspaths)) Storage::delete($thumbnailspaths);
        }
        return $data;
    }

    private function traitmentWithManyFiles(Article $article, Request $request) {

    }

}
