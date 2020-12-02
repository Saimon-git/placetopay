<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Joselfonseca\LighthouseGraphQLPassport\HasLoggedInTokens;
use Joselfonseca\LighthouseGraphQLPassport\HasSocialLogin;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    use HasLoggedInTokens;
    use HasSocialLogin;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userRoles() : MorphMany
    {
        return $this->morphMany(UserRole::class, 'model');
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function firstRole()
    {
        return $this->userRoles()->first();
    }

    public function isSuperAdmin()
    {
        return $this->roles()->where('name', Role::SUPERADMIN)->exists();
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', Role::ADMIN)->exists();
    }

    // scopes

    public function scopeByUser($query)
    {
        $role = auth()->user()->firstRole();

        return $query->when($role, function ($q) use ($role) {
            $q->whereHas('roles', function ($newQuery) use ($role) {
                $newQuery->where('model_id', $role->model_id);
            });
        });
    }

    // accesors

    public function getAvatarAttribute($value)
    {
        return $value ?? url('/images/Avatar_Male.png');
    }

    public function forFront()
    {
        $this->load('roles.permissions', 'permissions');

        return $this->toArray();
    }
}
