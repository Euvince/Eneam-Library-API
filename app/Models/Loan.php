<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperLoan
 */

#[ObservedBy([\App\Observers\LoanObserver::class])]

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_date', 'processing_date',
        'duration', 'status', 'renewals',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user () : BelongsTo {
        return $this->belongsTo(related : \App\Models\User::class, foreignKey : 'user_id');
    }

    public function article () : BelongsTo {
        return $this->belongsTo(related : \App\Models\Article::class, foreignKey : 'article_id');
    }

    public function articless () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Article::class,
            table : 'article_loan',
            foreignPivotKey : 'loan_id',
            relatedPivotKey : 'article_id'
        )->withPivot(columns : ['number_copies', 'deleted_at']);
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

    /* public function scopeAvailable (Builder $builder, bool $available = self::IS_AVAILABLE) : Builder {
        return $builder->where('available', $available);
    }

    public static function isAvailable (Article $article) : bool {
        return $article->available === self::IS_AVAILABLE;
    }

    public static function markAsAvailable (Article $article) :void {
        $article->update(['available' => self::IS_AVAILABLE]);
    } */

}
