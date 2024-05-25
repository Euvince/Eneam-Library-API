<?php

namespace App\Models;

use App\Models\RoleType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatiePermissionModel;

class Permission extends SpatiePermissionModel
{
    use HasFactory, SoftDeletes;

    public function roleType () : BelongsTo {
        return $this->belongsTo(related : RoleType::class, foreignKey : 'role_type_id');
    }

}
