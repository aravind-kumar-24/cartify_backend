<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CartifyUserRoles extends Model
{
    use SoftDeletes;
    
    protected $table = 'cartify_user_roles';

    protected $guarded = [];

    public function User(){
        return $this->belongsTo(CartifyUsers::class, 'cartify_user_id');
    }


}
