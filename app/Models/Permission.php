<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperPermission
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, SoftDeletes;

    public function rolesTypes () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\RoleType::class,
            table : 'roletype_has_permission',
            foreignPivotKey : 'permission_id',
            relatedPivotKey : 'role_type_id',
        );
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

}
