<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperSchoolYear
 */
class SchoolYear extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'school_years';

    protected $fillable = [
        'start_date', 'end_date', 'school_year',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function articles () : HasMany {
        return $this->hasMany(related : \App\Models\Article::class, foreignKey : 'year_id');
    }

    public function soutenances () : HasMany {
        return $this->hasMany(related : \App\Models\Soutenance::class, foreignKey : 'year_id');
    }

    public function configurations () : HasMany {
        return $this->hasMany(related : \App\Models\Configuration::class, foreignKey : 'year_id');
    }

}
