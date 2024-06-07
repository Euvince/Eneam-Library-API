<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperKeyword
 */
class Keyword extends Model
{
    use HasFactory, SoftDeletes;

    public function articles () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Keyword::class,
            table : 'article_keyword',
            foreignPivotKey : 'keyword_id',
            relatedPivotKey : 'article_id'
        );
    }

}
