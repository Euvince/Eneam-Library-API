<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperSupportedMemory
 */

#[ObservedBy([\App\Observers\SupportedMemoryObserver::class])]

class SupportedMemory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'theme', 'slug', 'start_at', 'ends_at',
        'first_author_firstname', 'second_author_firstname',
        'first_author_lastname', 'second_author_lastname',
        'first_author_email', 'second_author_email', 'soutenance_id', 'sector_id',
        'first_author_phone', 'second_author_phone', 'jury_president_name',
        'memory_master_name', 'memory_master_email', 'file_path',
        'cover_page_path', 'cote', 'status',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function soutenance () : BelongsTo {
        return $this->belongsTo(related : \App\Models\Soutenance::class, foreignKey : 'soutenance_id');
    }

    public function sector () : BelongsTo {
        return $this->belongsTo(related : \App\Models\Sector::class, foreignKey : 'sector_id');
    }

    public function finlingReports () : HasMany {
        return $this->hasMany(related : \App\Models\FilingReport::class, foreignKey : 'supported_memory_id');
    }

}
