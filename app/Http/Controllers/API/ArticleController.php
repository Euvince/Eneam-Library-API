<?php

namespace App\Http\Controllers\API;

use App\Helpers;
use App\Models\Article;
use App\Http\Controllers\Controller;
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
    public function index(FindArticleByTypeRequest $request) : ArticleCollectionResponse | LengthAwarePaginator
    {
        $articles = $request->has('type')
            ? Article::query()->with(['comments', 'loans'])->where('type', Helpers::mb_ucfirst($request->type))->orderBy('created_at', 'desc')->paginate(perPage : 20)
            : Article::query()->with(['schoolYear', 'comments', 'loans'])->paginate(perPage : 20);
        return new ArticleCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Article::count(),
            message : "Liste de tous les articles",
            collection : $articles,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request) : SingleArticleResponse
    {
        $article = Article::create($request->validated());
        return new SingleArticleResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "L'article a été crée avec succès",
            resource : new ArticleResource(resource : $article)
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
            resource : new ArticleResource(resource : Article::query()->with(['comments', 'loans'])->where('id', $article->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article) : SingleArticleResponse
    {
        $article->update($request->validated());
        return new SingleArticleResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "L'article a été modifié avec succès",
            resource : new ArticleResource(resource : Article::query()->with(['comments', 'loans'])->where('id', $article->id)->first())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article) : JsonResponse
    {
        $article->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "L'article a été supprimé avec succès",],
        );
    }
}
