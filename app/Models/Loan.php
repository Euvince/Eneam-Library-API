<?php

namespace App\Models;

use Carbon\Carbon;
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
        'title', 'loan_date', 'processing_date', 'book_must_returned_on',
        'duration', 'status', 'renewals', 'book_recovered_at', 'book_returned_at',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at', 'reniew_at', 'withdraw_at'
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

    public function scopeRenewed (Builder $builder) : Builder {
        return $builder->whereNull('renewed_at');
    }

    public function scopeStarted (Builder $builder) : Builder {
        return $builder->whereNotNull('book_recovered_at');
    }

    public function scopeReturned (Builder $builder) : Builder {
        return $builder->whereNotNull('book_returned_at');
    }

    public function scopeWithdrawed (Builder $builder) : Builder {
        return $builder->whereNull('renewed_at');
    }

    public static function hasStarted (Loan $loan) : bool {
        return $loan->book_recovered_at !== NULL;
    }

    public static function markAsStarted (Loan $loan) :void {
        $loan->update(['book_recovered_at' => Carbon::now()]);
    }

    public static function isReniewed (Loan $loan) : bool {
        return $loan->reniew_at !== NULL;
    }

    public static function markAsReniewed (Loan $loan) :void {
        $loan->update(['reniew_at' => Carbon::now()]);
    }

    public static function isFinished (Loan $loan) : bool {
        return $loan->book_returned_at !== NULL;
    }

    public static function markAsFinished (Loan $loan) :void {
        $loan->update(['book_returned_at' => Carbon::now()]);
    }

    public static function isWithdrawed (Loan $loan) : bool {
        return $loan->withdraw_at !== NULL;
    }

    public static function markAsWithdrawed (Loan $loan) :void {
        $loan->update(['withdraw_at' => Carbon::now()]);
    }

}
