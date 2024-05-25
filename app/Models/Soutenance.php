<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Soutenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name','year', 'start_date', 'end_date',
        'number_memories_expected',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

}
