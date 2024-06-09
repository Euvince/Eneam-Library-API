<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Responses\Cycle\CommentCollectionResponse;
use App\Http\Responses\Cycle\SingleCommentResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends Controller
{
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
    public function store(CommentRequest $request) : SingleCommentResponse
    {
        $comment = Comment::create($request->validated());
        return new SingleCommentResponse(
            statusCode : 201,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Votre commentaire a été envoyé avec succès",
            resource : new CommentResource(resource : Comment::query()->with(['article', 'user'])->where('id', $comment->id)->first())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment) : SingleCommentResponse
    {
        return new SingleCommentResponse(
            statusCode : 200,
            allowedMethods : 'GET, POST, PUT, PATCH, DELETE',
            message : "Informations sur le commentaire $comment->id",
            resource : new CommentResource(resource : Comment::query()->with(['article', 'user'])->where('id', $comment->id)->first())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment) : SingleCommentResponse
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
    public function destroy(Comment $comment) : JsonResponse
    {
        $comment->delete();
        return response()->json(
            status : 200,
            headers : ["Allow" => 'GET, POST, PUT, PATCH, DELETE'],
            data : ['message' => "Votre commentaire a bien été supprimé",],
        );
    }
}
