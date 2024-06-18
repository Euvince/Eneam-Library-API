<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperRole
 */

#[ObservedBy([\App\Observers\RoleObserver::class])]

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function roleType () : BelongsTo {
        return $this->belongsTo(related : \App\Models\RoleType::class, foreignKey : 'role_type_id');
    }

}
