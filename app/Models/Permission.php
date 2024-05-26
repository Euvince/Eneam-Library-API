<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, SoftDeletes;

    public function roleType () : BelongsTo {
        return $this->belongsTo(related : \App\Models\RoleType::class, foreignKey : 'role_type_id');
    }

}
