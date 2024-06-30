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

    const ACCEPT_STATUS = "Acceptée";
    const REJECT_STATUS = "Rejetée";

    protected $fillable = [
        'title', 'loan_date', 'processing_date', 'book_must_returned_on',
        'duration', 'status', 'renewals', 'book_recovered_at', 'book_returned_at',
        'created_by', 'updated_by', 'deleted_by', 'accepted_at', 'rejected_at',
        'created_at', 'updated_at', 'deleted_at', 'reniew_at', 'withdraw_at'
    ];

    protected $casts = [
        'loan_date' => 'date',
        'processing_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'withdraw_at' => 'datetime',
        'book_recovered_at' => 'datetime',
        'book_returned_at' => 'datetime',
        /* 'book_must_returned_on' => 'date', */
        'book_must_returned_on' => 'datetime',
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

    public function scopeAccepted (Builder $builder, string $accepted = self::ACCEPT_STATUS) : Builder {
        return $builder->where('status', $accepted);
    }

    public function scopeRejected (Builder $builder, string $rejected = self::REJECT_STATUS) : Builder {
        return $builder->where('status', $rejected);
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

    public static function isAccepted (Loan $loan) : bool {
        return $loan->status === self::ACCEPT_STATUS;
    }

    public static function markAsAccepted (Loan $loan) :void {
        $loan->update(['status' => self::ACCEPT_STATUS]);
    }

    public static function isRejected (Loan $loan) : bool {
        return $loan->status === self::REJECT_STATUS;
    }

    public static function markAsRejected (Loan $loan) :void {
        $loan->update(['status' => self::REJECT_STATUS]);
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
        $loan->update([
            'status' => "Terminé",
            'book_returned_at' => Carbon::now()
        ]);
    }

    public static function isWithdrawed (Loan $loan) : bool {
        return $loan->withdraw_at !== NULL;
    }

    public static function markAsWithdrawed (Loan $loan) :void {
        $loan->update(['withdraw_at' => Carbon::now()]);
    }

}
