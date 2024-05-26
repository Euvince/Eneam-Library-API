<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cycle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function soutenances () : HasMany {
        return $this->hasMany(related : \App\Models\Soutenance::class, foreignKey : 'cycle_id');
    }

}
