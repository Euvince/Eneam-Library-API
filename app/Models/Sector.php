<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperSector
 */

#[ObservedBy([\App\Observers\SectorObserver::class])]

class Sector extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type', 'name', 'slug', 'acronym','sector_id',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
