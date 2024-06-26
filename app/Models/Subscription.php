<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * @mixin IdeHelperSubscription
 */

#[ObservedBy([\App\Observers\SubscriptionObserver::class])]

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'amount', 'status', 'subscription_date', 'expiration_date', 'user_id',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user () : BelongsTo {
        return $this->belongsTo(related : \App\Models\User::class, foreignKey : 'user_id');
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

}
