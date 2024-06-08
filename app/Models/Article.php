<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperArticle
 */

#[ObservedBy([\App\Observers\ArticleObserver::class])]

class Article extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'type', 'summary', 'author', 'cote', 'ISBN',
        'editor', 'editing_year', 'number_pages', 'available_stock',
        'available', 'loaned', 'reserved', 'is_physical', 'has_ebooks', 'has_audios',
        'keywords', 'formats', 'thumbnail_path', 'file_path', 'files_paths', 'school_year_id',
        'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at',
    ];

    /* protected $casts = [
        'keywords' => 'array',
        'formats' => 'array',
        'access_paths' => 'array'
    ]; */


    /* public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumbnail')
            ->fit(Fit::Contain, 300, 300)
            ->performOnCollections('pdfs');
    } */

    public function schoolYear () : BelongsTo {
        return $this->belongsTo(related : \App\Models\SchoolYear::class, foreignKey : 'school_year_id');
    }

    public function comments () : HasMany {
        return $this->hasMany(related : \App\Models\Comment::class, foreignKey : 'article_id');
    }

    public function keywords () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Keyword::class,
            table : 'article_keyword',
            foreignPivotKey : 'article_id',
            relatedPivotKey : 'keyword_id'
        );
    }

    public function loans () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Loan::class,
            table : 'article_loan',
            foreignPivotKey : 'article_id',
            relatedPivotKey : 'loan_id'
        )->withPivot(columns : 'number_copies');
    }

    public function reservations () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Reservation::class,
            table : 'article_reservation',
            foreignPivotKey : 'article_id',
            relatedPivotKey : 'reservation_id'
        );
    }

}
