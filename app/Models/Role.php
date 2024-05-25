<?php

namespace App\Models;

use App\Models\RoleType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role as SpatieRoleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRoleModel
{
    use HasFactory, SoftDeletes;

    public function roleType () : BelongsTo {
        return $this->belongsTo(related : RoleType::class, foreignKey : 'role_type_id');
    }

}
