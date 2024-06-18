<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperComment
 */

#[ObservedBy([\App\Observers\CommentObserver::class])]

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content', 'likes_number', 'user_id', 'article_id',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    /* protected $casts = [
        'created_at' => 'dateTime',
        'updated_at' => 'dateTime',
    ]; */

    public function user () : BelongsTo {
        return $this->belongsTo(related : \App\Models\User::class, foreignKey : 'user_id');
    }

    public function article () : BelongsTo {
        return $this->belongsTo(related : \App\Models\Article::class, foreignKey : 'article_id');
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

}
