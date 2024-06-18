<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperFilingReport
 */
class FilingReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'observation', 'supported_memory_id',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function supportedMemory () : BelongsTo {
        return $this->belongsTo(related : \App\Models\SupportedMemory::class, foreignKey : 'supported_memory_id');
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

}
