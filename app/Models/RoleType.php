<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->hasMany(related : Role::class, foreignKey : 'role_type_id');
    }

    public function permissions () : HasMany {
        return $this->hasMany(related : Permission::class, foreignKey : 'role_type_id');
    }

}
