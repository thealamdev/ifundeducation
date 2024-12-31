<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'photo',
        'provider_id',
        'provider',
        'avatar',
        'email_verified_at',
        'stripe_account_id',
        'stripe_connect_id',
        'status',
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
        'email_verified_at' => 'datetime',
    ];

    public function personal_profile() {
        return $this->hasOne(UserPersonalProfile::class);
    }

    public function academic_profile() {
        return $this->hasOne(AcademicProfile::class);
    }

    public function userSocial() {
        return $this->hasOne(UserSocialProfile::class);
    }

    public function balance() {
        return $this->hasOne(FundraiserBalance::class);
    }

    public function fundraiser_post() {
        return $this->hasMany(FundraiserPost::class);
    }

    public function all_donars() {
        return $this->hasManyThrough(Donate::class, FundraiserPost::class);
    }
    public function donates() {
        return $this->hasMany(Donate::class, 'donar_id', 'id');
    }

}