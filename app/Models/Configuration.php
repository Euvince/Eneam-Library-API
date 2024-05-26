<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_debt_price',
        'teacher_debt_price',
        'student_loan_delay',
        'teacher_loan_delay',
        'student_renewals_number',
        'teacher_renewals_number',
        'extern_subscribe_rising',
        'eneamien_subscribe_rising',
        'subscription_expiration_date',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public static function getApplicationConfiguration () : mixed {
        return self::first();
    }

}
