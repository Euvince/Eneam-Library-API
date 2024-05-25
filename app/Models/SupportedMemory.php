<?php

namespace App\Models;

use App\Models\Sector;
use App\Models\Soutenance;
use App\Models\FilingReport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportedMemory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'theme', 'soutenance_date', 'soutanance_hour',
        'first_author_name', 'second_author_name',
        'first_author_email', 'second_author_email',
        'first_author_phone', 'second_author_phone', 'jury_president',
        'memory_master', 'file_path', 'cote', 'status',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    /* protected static function boot() {

        parent::boot();

        if (!app()->runningInConsole() && auth()->check()) {
            $userFullName = Auth::user()->nom . " " . Auth::user()->prenoms;

            static::creating(function ($rayon) use ($userFullName) {
                $rayon->created_by = $userFullName;
            });

            static::created(function ($rayon) {
                $rayon->update([
                    'code' => 'R' . $rayon->id
                ]);
            });

            static::updating(function ($rayon) use ($userFullName) {
                $rayon->updated_by = $userFullName;
            });

            static::deleting(function ($rayon) use ($userFullName) {
                $rayon->boitearchives->each(function ($boite) {
                    $boite->delete();
                });
                $rayon->deleted_by = $userFullName;
                $rayon->save();
            });
        }

    } */

    public function soutenance () : BelongsTo {
        return $this->belongsTo(related : Soutenance::class, foreignKey : 'soutenance_id');
    }

    public function sector () : BelongsTo {
        return $this->belongsTo(related : Sector::class, foreignKey : 'sector_id');
    }

    public function finlingReports () : HasMany {
        return $this->hasMany(related : FilingReport::class, foreignKey : 'supported_memory_id');
    }

}
