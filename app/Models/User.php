<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Listeners\UserCreatingListener;
use App\Models\Loan;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Subscription;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricule', 'firstname', 'lastname', 'email',
        'password', 'phone_numer', 'birth_date', 'sex',
        'hasPaid', 'hasAccess', 'debt_price',
        'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'creating' => UserCreatingListener::class
    ];

    protected static function boot() {

        parent::boot();

        if (!app()->runningInConsole() && auth()->check()) {
            $userFullName = Auth::user()->firstname . " " . Auth::user()->lastname;
            static::creating(callback : fn ($user) => $user->created_by = $userFullName);
            static::creating(callback : fn ($user) => $user->updated_by = $userFullName);
            static::deleting(function ($user) use ($userFullName) {
                $user->deleted_by = $userFullName;
                $user->save();
            });
        }

    }

    public function payments () : HasMany {
        return $this->hasMany(related : Payment::class, foreignKey : 'user_id');
    }

    public function subscriptions () : HasMany {
        return $this->hasMany(related : Subscription::class, foreignKey : 'user_id');
    }

    public function comments () : HasMany {
        return $this->hasMany(related : Comment::class, foreignKey : 'user_id');
    }

    public function loans () : HasMany {
        return $this->hasMany(related : Loan::class, foreignKey : 'user_id');
    }

    public function reservations () : HasMany {
        return $this->hasMany(related : Reservation::class, foreignKey : 'user_id');
    }

}
