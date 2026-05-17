<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class CartifyUsers extends Authenticatable implements JWTSubject
{
    use SoftDeletes, Notifiable;
    
    protected $table = "cartify_users";

    protected $with = ['Role', 'SellerProfile'];

    protected $guarded = [];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function Role(){
        return $this->hasMany(CartifyUserRoles::class, 'cartify_user_id');
    }

    public function SellerProfile(){
        return $this->hasOne(CartifySellerProfiles::class, 'cartify_user_id');
    }
}
