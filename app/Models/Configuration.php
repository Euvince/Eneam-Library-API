<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperConfiguration
 */

 #[ObservedBy([\App\Observers\ConfigurationObserver::class])]

class Configuration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuration';

    protected $fillable = [
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
        'subscription_expiration_date',
        'max_copies_books_per_student',
        'max_copies_books_per_teacher',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public static function appConfig () : self {
        return self::latest()->first();
    }

}
