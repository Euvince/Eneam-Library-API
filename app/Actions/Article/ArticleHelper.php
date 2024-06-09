<?php

namespace App\Actions\Article;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleHelper
{
    public static function traitmentWithOneFile (Article $article, Request $request) {
        $data = $request->validated();
        unset($data['keywords']);
        if(array_key_exists('file_path', $data))
        {
            /** @var UploadedFile|null $filePathCollection */
            $filePathCollection = $data['file_path'];
            $data['file_path'] = $filePathCollection->storeAs('Articles/articles', time().'-'.$request->file('file_path')->getClientOriginalName(), 'public');
            $filepath = 'public/' . $article->file_path;
            if(Storage::exists($filepath)) Storage::delete($filepath);
        }
        if (array_key_exists('thumbnail_path', $data)) {
            /** @var UploadedFile|null $thumbanailPathCollection */
            $thumbanailPathCollection = $data['thumbnail_path'];
            $data['thumbnail_path'] = $thumbanailPathCollection->storeAs('Articles/cover-pages', time().'-'.$request->file('thumbnail_path')->getClientOriginalName(), 'public');
            $thumbnailpath = 'public/' . $article->thumbnail_path;
            if(Storage::exists($thumbnailpath)) Storage::delete($thumbnailpath);
        }
        return $data;
    }

    public static function traitmentWithManyFiles(Article $article, Request $request) {
        $data = $request->validated();
        unset($data['keywords']);
        if(array_key_exists('files_paths', $data))
        {
            $filespaths = [];
            foreach($data['files_paths'] as $file) {
                /** @var UploadedFile|null $filesPathsCollection */
                $file = $file->storeAs('Articles/articles', time().'-'.$file->getClientOriginalName(), 'public');
                $filespaths[] = $file;
            }
            $data['files_paths'] = json_encode($filespaths);
            if ($article->files_paths !== NULL) {
                foreach(json_decode($article->files_paths) as $path) {
                    $filepath = 'public/' . $path;
                    if(Storage::exists($filepath)) Storage::delete($filepath);
                }
            }
        }
        if (array_key_exists('thumbnail_path', $data)) {
            /** @var UploadedFile|null $thumbanailPathCollection */
            $thumbanailPathCollection = $data['thumbnail_path'];
            $data['thumbnail_path'] = $thumbanailPathCollection->storeAs('Articles/cover-pages', time().'-'.$request->file('thumbnail_path')->getClientOriginalName(), 'public');
            $thumbnailpath = 'public/' . $article->thumbnail_path;
            if(Storage::exists($thumbnailpath)) Storage::delete($thumbnailpath);
        }
        return $data;
    }

}
