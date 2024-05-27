<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoleType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles_types';

    protected $fillable = [
        'name', 'slug',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function roles () : HasMany {
        return $this->hasMany(related : \App\Models\Role::class, foreignKey : 'role_type_id');
    }

    public function permissions () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Permission::class,
            table : 'roletype_has_permission',
            foreignPivotKey : 'role_type_id',
            relatedPivotKey : 'permission_id',
        );
    }

}
