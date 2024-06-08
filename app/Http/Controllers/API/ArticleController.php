<?php

namespace App\Http\Controllers\API;

use App\Actions\Article\ArticleHelper;
use App\Helpers;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Article\ArticleRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Responses\Article\{
    SingleArticleResponse,
    ArticleCollectionResponse
};
use App\Http\Requests\Article\FindArticleByTypeRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(/* FindArticleByTypeRequest */ Request $request) : ArticleCollectionResponse | LengthAwarePaginator
    {
        $articles = $request->has('type')
            ? Article::query()->with(['keywords', 'schoolYear' /* , 'comments', 'loans' */])->where('type', Helpers::mb_ucfirst($request->type))->orderBy('created_at', 'desc')->paginate(perPage : 20)
            : Article::query()->with(['keywords', 'schoolYear'/* , 'comments', 'loans' */])->paginate(perPage : 20);
        return new ArticleCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Article::count(),
            message : "Liste de tous les articles",
            collection : Article::query()->with(['keywords', 'schoolYear'/* , 'comments', 'loans' */])->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request) : SingleArticleResponse
    {
        $article = Article::create(ArticleHelper::traitmentWithOneFile(new Article(), $request));
        /* $article = Article::create(ArticleHelper::traitmentWithManyFiles(new Article(), $request)); */
        $keywordsIds = [];
        array_map(function ($keyword) use(&$keywordsIds) {
            $k = \App\Models\Keyword::firstOrCreate([
                'keyword' => \App\Helpers::mb_ucfirst($keyword)
            ]);
            $keywordsIds[] = $k->id;
        }, $request->keywords);
        $article->keywords()->sync($keywordsIds);
        return new SingleArticleResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "L'article a été crée avec succès",
            resource : new ArticleResource(resource : Article::query()->with(['keywords'/* , 'comments', 'loans' */])->where('id', $article->id)->first())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article) : SingleArticleResponse
    {
        return new SingleArticleResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur l'article $article->title",
            resource : new ArticleResource(resource : Article::query()->with(['keywords', 'comments.user'/* , 'loans' */])->where('id', $article->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article) : SingleArticleResponse
    {
        $article->update(ArticleHelper::traitmentWithOneFile($article, $request));
        /* $article->update(ArticleHelper::traitmentWithManyFiles($article, $request)); */
        array_map(function ($keyword) use(&$keywordsIds) {
            $k = \App\Models\Keyword::firstOrCreate([
                'keyword' => \App\Helpers::mb_ucfirst($keyword)
            ]);
            $keywordsIds[] = $k->id;
        }, $request->keywords);
        $article->keywords()->sync($keywordsIds);
        return new SingleArticleResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "L'article a été modifié avec succès",
            resource : new ArticleResource(resource : Article::query()->with(['keywords'/* , 'comments', 'loans' */])->where('id', $article->id)->first())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article) : JsonResponse
    {
        $article->delete();
        if(($articleFilePath = $article->file_path) !== '') {
            $path = 'public/' . $articleFilePath;
            if(Storage::exists($path)) Storage::delete($path);
        }
        if(($articleThumbnailPath = $article->thumbnail_path) !== '') {
            $path = 'public/' . $articleThumbnailPath;
            if(Storage::exists($path)) Storage::delete($path);
        }
        if ($article->files_paths !== NULL) {
            foreach(json_decode($article->files_paths) as $filepath) {
                $path = 'public/' . $filepath;
                if(Storage::exists($path)) Storage::delete($path);
            }
        }
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "L'article a été supprimé avec succès",],
        );
    }

}
