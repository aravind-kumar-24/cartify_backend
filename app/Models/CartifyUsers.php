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

    protected $guarded = [];

    public function getAuthIdentifierName()
    {
        return 'email_id';
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function CartifyUserRoles(){
        return $this->hasMany(CartifyUserRoles::class, 'cartify_user_id');
    }
}
