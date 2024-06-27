<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    const IS_LOANED = 1;
    const IS_PHYSICAL = 1;
    const IS_AVAILABLE = 1;

    protected $fillable = [
        'title', 'slug', 'type', 'summary', 'author', 'cote', 'ISBN',
        'editor', 'editing_year', 'number_pages', 'available_stock',
        'available', 'loaned', 'reserved', 'is_physical', 'has_ebooks', 'has_audios',
        'keywords', 'formats', 'thumbnail_path', 'file_path', 'files_paths', 'school_year_id',
        'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        /* 'keywords' => 'array',
        'formats' => 'array', */
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'files_paths' => 'json',

        /* 'loaned' => 'bool',
        'available' => 'bool',
        'is_physical' => 'bool',
        'has_ebooks' => 'bool',
        'has_audios' => 'bool', */
    ];


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
        )->withPivot(columns : ['deleted_at']);
    }

    public function loans () : HasMany {
        return $this->hasMany(related : \App\Models\Loan::class, foreignKey : 'article_id');
    }

    public function loanss () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Loan::class,
            table : 'article_loan',
            foreignPivotKey : 'article_id',
            relatedPivotKey : 'loan_id'
        )->withPivot(columns : ['number_copies', 'deleted_at']);
    }

    public function reservations () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Reservation::class,
            table : 'article_reservation',
            foreignPivotKey : 'article_id',
            relatedPivotKey : 'reservation_id'
        )->withPivot(columns : ['deleted_at']);
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

    public function scopeAvailable (Builder $builder, bool $available = self::IS_AVAILABLE) : Builder {
        return $builder->where('available', $available);
    }

    public function scopeLoaned (Builder $builder, bool $loaned = self::IS_LOANED) : Builder {
        return $builder->where('loaned', $loaned);
    }

    public function scopePhysical (Builder $builder, bool $isPhysical = self::IS_PHYSICAL) : Builder {
        return $builder->where('is_physical', $isPhysical);
    }

    public static function isAvailable (Article $article) : bool {
        return
            /* $article->available_stock > 0 && */
            $article->available === self::IS_AVAILABLE;
    }

    public static function markAsAvailable (Article $article) :void {
        $article->update(['available' => self::IS_AVAILABLE]);
    }

    public static function isLoaned (Article $article) : bool {
        return $article->available === self::IS_LOANED;
    }

    public static function markAsLoaned (Article $article) :void {
        $article->update(['loaned' => self::IS_LOANED]);
    }

    public static function isPhysical (Article $article) : bool {
        return $article->available === self::IS_LOANED;
    }

    public static function markAsPhysic (Article $article) :void {
        $article->update(['is_physical' => self::IS_PHYSICAL]);
    }

}
