<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportedMemory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'theme', 'soutenance_date', 'soutanance_hour',
        'first_author_name', 'second_author_name',
        'first_author_email', 'second_author_email',
        'first_author_phone', 'second_author_phone', 'jury_president',
        'memory_master', 'file_path', 'cote', 'status',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

}
