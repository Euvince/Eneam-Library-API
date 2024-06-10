<?php

namespace App\Http\Responses\Comment;

use App\Http\Resources\Comment\CommentCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentCollectionResponse implements Responsable
{
    public function __construct(
        private readonly string $allowedMethods,
        private readonly int|null $total = 0,
        private readonly int $statusCode = 200,
        private readonly string|null $message = "",
        private readonly Collection|LengthAwarePaginator $collection,
    )
    {
    }

    public function toResponse($request) {

        $response = response()->json(
            status : $this->statusCode,
            headers : [
                'Allow' => $this->allowedMethods,
                'Content-Type' => 'application/json',
            ],
            data : CommentCollection::make(resource : $this->collection)->response()->getData()
        );
        return $response->header(key : 'Content-Length', values : mb_strlen($response->content()));
    }
}
