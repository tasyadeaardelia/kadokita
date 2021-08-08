<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// use Carbon\Carbon;
// use App\Models\Concerns\UuidTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    // use HasFactory, Notifiable, UuidTrait, HasRoles;
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'fullname',
        'address',
        'profil',
        'province',
        'city',
        'zip_code',
        'phone_number',
        'gender',
        'account_number',
        'id_card',
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function province(){
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

}
