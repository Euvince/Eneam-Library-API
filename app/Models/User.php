<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Spatie\Image\Enums\Fit;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\HasProfilePicture;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin IdeHelperUser
 */
#[ObservedBy([\App\Observers\UserObserver::class])]

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasProfilePicture, HasApiTokens, HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable, InteractsWithMedia;

    const HAS_PAID = 1;
    const HAS_ACCESS = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricule', 'firstname', 'lastname', 'email',
        'password', 'phone_numer', 'birth_date', 'sex', 'profile_picture_path',
        'has_paid', 'has_access', 'debt_amount', 'slug',
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
        'creating' => \App\Events\UserCreatingEvent::class
    ];

    /* protected static function boot() {

        parent::boot();

        if (!app()->runningInConsole() && auth()->check()) {
            $userFullName = Auth::user()->firstname . " " . Auth::user()->lastname;
            static::creating(callback : fn ($user) => $user->created_by = $userFullName);
            static::updating(callback : fn ($user) => $user->updated_by = $userFullName);
            static::deleting(function ($user) use ($userFullName) {
                $user->deleted_by = $userFullName;
                $user->save();
            });
        }

    } */

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumbnail')
            ->fit(Fit::Contain, 300, 300)
            ->performOnCollections('pdfs');

        /* $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->pdfPageNumber(2); */
    }

    public function payments () : HasMany {
        return $this->hasMany(related : \App\Models\Payment::class, foreignKey : 'user_id');
    }

    public function subscriptions () : HasMany {
        return $this->hasMany(related : \App\Models\Subscription::class, foreignKey : 'user_id');
    }

    public function comments () : HasMany {
        return $this->hasMany(related : \App\Models\Comment::class, foreignKey : 'user_id');
    }

    public function loans () : HasMany {
        return $this->hasMany(related : \App\Models\Loan::class, foreignKey : 'user_id');
    }

    public function reservations () : HasMany {
        return $this->hasMany(related : \App\Models\Reservation::class, foreignKey : 'user_id');
    }

    public function scopeRecent (Builder $builder) : Builder {
        return $builder->orderBy('created_at', 'desc');
    }

    public function scopePaid (Builder $builder, bool $hasPaid = self::HAS_PAID) : Builder {
        return $builder->where('has_paid', $hasPaid);
    }

    public function scopeAccess (Builder $builder, bool $hasAccess = self::HAS_ACCESS) : Builder {
        return $builder->where('has_access', $hasAccess);
    }

    public static function hasPaid (User $user) : bool {
        return $user->has_paid === self::HAS_PAID;
    }

    public static function markAsHasPaid (User $user) :void {
        $user->update(['has_paid' => self::HAS_PAID]);
    }

    public static function hasAccess (User $user) : bool {
        return $user->has_access === self::HAS_ACCESS;
    }

    public static function markAsHasAccess (User $user) :void {
        $user->update(['has_access' => self::HAS_ACCESS]);
    }

}
