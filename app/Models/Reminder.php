<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reminder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'created_at','updated_at', 'deleted_at',
        'created_by', 'updated_by', 'deleted_by',
    ];

    public function user () : BelongsTo {
        return $this->belongsTo(related : \App\Models\User::class, foreignKey : 'user_id');
    }

}
