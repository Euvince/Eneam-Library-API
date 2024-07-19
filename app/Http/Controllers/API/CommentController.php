<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Responses\Comment\SingleCommentResponse;
use App\Http\Responses\Comment\CommentCollectionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentController extends Controller
{
    public function __construct(
        private readonly AuthManager $auth
    )
    {
        /* $this->authorizeResource(Comment::class); */
    }

    /**
     * Display a listing of the resource.
     */
    public function index() : CommentCollectionResponse | LengthAwarePaginator
    {
        return new CommentCollectionResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            total : Comment::count(),
            message : "Liste de tous les commentaires",
            collection : Comment::query()->with(['article', 'user'])->orderBy('created_at', 'desc')->paginate(perPage : 20),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Article $article, CommentRequest $request) : SingleCommentResponse
    {
        $comment = Comment::create($request->validated() + [
            'article_id' => $article->id,
            'user_id' => $this->auth->user()->id ?? 2,
        ]);
        return new SingleCommentResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Votre commentaire a été soumis avec succès",
            resource : new CommentResource(resource : Comment::query()->with(['article', 'user'])->where('id', $comment->id)->first())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article, Comment $comment) : SingleCommentResponse
    {
        return new SingleCommentResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur le commentaire $comment->content de l'article $article->title",
            resource : new CommentResource(resource : Comment::query()->with(['article', 'user'])->where('id', $comment->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Article $article, Comment $comment) : SingleCommentResponse
    {
        $comment->update($request->validated());
        return new SingleCommentResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Votre commentaire a bien été édité",
            resource : new CommentResource(resource : Comment::query()->with(['article', 'user'])->where('id', $comment->id)->first())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article, Comment $comment) : JsonResponse
    {
        $comment->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Votre commentaire a bien été supprimé",],
        );
    }

    /**
     * Remove many specified resources from storage
     *
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function destroyComments (CommentRequest $request) : JsonResponse
    {
        $ids = $request->validated('ids');
        array_map(function (int $id) {
            Comment::find($id)->delete();
        }, $ids);
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : [
                'message' => count($ids) > 1
                    ? "Les commentaires ont été supprimés avec succès"
                    : "Le commentaire a été supprimé avec succès"
            ],
        );
    }
}
