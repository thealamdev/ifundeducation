<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonalProfile extends Model {
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthday' => 'date',
    ];

    public function country() {
        return $this->hasOne( Country::class, 'id', 'country_id' );
    }

    public function state() {
        return $this->hasOne( State::class, 'id', 'state_id' );
    }

    public function city() {
        return $this->hasOne( City::class, 'id', 'city_id' );
    }

}