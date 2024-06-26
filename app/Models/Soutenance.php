<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperSoutenance
 */

#[ObservedBy([\App\Observers\SoutenanceObserver::class])]

class Soutenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug','start_date', 'end_date',
        'number_memories_expected', 'cycle_id', 'school_year_id',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function schoolYear () : BelongsTo {
        return $this->belongsTo(related : \App\Models\SchoolYear::class, foreignKey : 'school_year_id');
    }

    public function cycle () : BelongsTo {
        return $this->belongsTo(related : \App\Models\Cycle::class, foreignKey : 'cycle_id');
    }

    public function supportedMemories () : HasMany {
        return $this->hasMany(related : \App\Models\SupportedMemory::class, foreignKey : 'soutenance_id');
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

}
