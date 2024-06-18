<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperKeyword
 */

#[ObservedBy([\App\Observers\KeywordObserver::class])]

class Keyword extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'keyword', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function articles () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Keyword::class,
            table : 'article_keyword',
            foreignPivotKey : 'keyword_id',
            relatedPivotKey : 'article_id'
        )->withPivot(columns : ['deleted_at']);
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

}
