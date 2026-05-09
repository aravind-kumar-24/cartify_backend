<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CartifySellerProfiles extends Model
{
    use SoftDeletes;

    protected $table = 'cartify_seller_profiles';

    protected $guarded = [];
}
