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
 * @mixin IdeHelperSupportedMemory
 */

#[ObservedBy([\App\Observers\SupportedMemoryObserver::class])]

class SupportedMemory extends Model
{
    use HasFactory, SoftDeletes;

    const VALID_STATUS = "Validé";
    const INVALID_STATUS = "Invalidé";

    protected $fillable = [
        'theme', 'slug', 'start_at', 'ends_at',
        'first_author_matricule', 'second_author_matricule',
        'first_author_firstname', 'second_author_firstname',
        'first_author_lastname', 'second_author_lastname',
        'first_author_email', 'second_author_email', 'soutenance_id', 'sector_id',
        'first_author_phone', 'second_author_phone', 'jury_president_name',
        'memory_master_name', 'memory_master_email', 'file_path',
        'cover_page_path', 'cote', 'status', 'user_id',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
        'printed_number', 'download_number', 'views_number'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user () : BelongsTo {
        return $this->belongsTo(related : \App\Models\User::class, foreignKey : 'user_id');
    }

    public function soutenance () : BelongsTo {
        return $this->belongsTo(related : \App\Models\Soutenance::class, foreignKey : 'soutenance_id');
    }

    public function sector () : BelongsTo {
        return $this->belongsTo(related : \App\Models\Sector::class, foreignKey : 'sector_id');
    }

    public function finlingReports () : HasMany {
        return $this->hasMany(related : \App\Models\FilingReport::class, foreignKey : 'supported_memory_id');
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

    public function scopeValide (Builder $builder, string $valid = self::VALID_STATUS) : Builder {
        return $builder->where('status', $valid);
    }

    public function scopeInvalide (Builder $builder, string $invalid = self::INVALID_STATUS) : Builder {
        return $builder->where('status', $invalid);
    }

    public static function isValide (SupportedMemory $memory) : bool {
        return $memory->status === self::VALID_STATUS;
    }

    public static function markAsValid (SupportedMemory $memory) :void {
        $memory->update(['status' => self::VALID_STATUS]);
    }

    public static function isInvalide (SupportedMemory $memory) : bool {
        return $memory->status === self::INVALID_STATUS;
    }

    public static function markAsInvalid (SupportedMemory $memory) :void {
        $memory->update(['status' => self::INVALID_STATUS]);
    }
}
