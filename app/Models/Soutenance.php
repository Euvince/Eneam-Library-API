<?php

namespace App\Models;

use App\Models\Cycle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Soutenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name','year', 'start_date', 'end_date',
        'number_memories_expected',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function cycle () : BelongsTo {
        return $this->belongsTo(related : Cycle::class, foreignKey : 'cycle_id');
    }

}
