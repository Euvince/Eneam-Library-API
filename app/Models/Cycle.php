<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperCycle
 */

#[ObservedBy([\App\Observers\CycleObserver::class])]

class Cycle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'code',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* protected $dispatchesEvents = [
        'creating' => \App\Events\Cycle\CycleCreatingEvent::class,
        'updating' => \App\Events\Cycle\CycleUpdatingEvent::class,
        'deleting' => \App\Events\Cycle\CycleDeletingEvent::class,
    ]; */

    public function soutenances () : HasMany {
        return $this->hasMany(related : \App\Models\Soutenance::class, foreignKey : 'cycle_id');
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

}
