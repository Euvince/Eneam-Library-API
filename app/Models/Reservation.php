<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperReservation
 */
class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reservation_date', 'processing_date', 'user_id',
        'start_date', 'end_date', 'status',
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

    public function articles () : BelongsToMany {
        return $this->belongsToMany(
            related : \App\Models\Article::class,
            table : 'article_reservation',
            foreignPivotKey : 'reservation_id',
            relatedPivotKey : 'article_id'
        )->withPivot(columns : ['deleted_at']);
    }

}
