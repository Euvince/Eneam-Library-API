<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sector extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'acronym',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function sector () : BelongsTo {
        return $this->belongsTo(related : \App\Models\Sector::class, foreignKey : 'sector_id');
    }

    public function specialities () : HasMany {
        return $this->hasMany(related : \App\Models\Sector::class, foreignKey : 'sector_id');
    }

    public function supportedMemories () : HasMany {
        return $this->hasMany(related : \App\Models\SupportedMemory::class, foreignKey : 'sector_id');
    }

}
