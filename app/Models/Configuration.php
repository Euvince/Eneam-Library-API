<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperConfiguration
 */

#[ObservedBy([\App\Observers\ConfigurationObserver::class])]

class Configuration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configurations';

    protected $fillable = [
        'school_year_id',
        'school_name',
        'school_acronym',
        'school_city',
        'archivist_full_name',
        'student_debt_amount',
        'teacher_debt_amount',
        'student_loan_delay',
        'teacher_loan_delay',
        'max_books_per_student',
        'max_books_per_teacher',
        'student_renewals_number',
        'teacher_renewals_number',
        'extern_subscribe_amount',
        'eneamien_subscribe_amount',
        'max_copies_books_per_student',
        'max_copies_books_per_teacher',
        'subscription_expiration_delay',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public static function appConfig () {
        return self::latest()->with(['schoolYear'])->first();
    }

    public function schoolYear () : BelongsTo {
        return $this->belongsTo(related : \App\Models\SchoolYear::class, foreignKey : 'year_id');
    }

}
