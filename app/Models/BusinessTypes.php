<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessTypes extends Model
{
    use SoftDeletes;
    
    protected $table = 'business_types';

    protected $guarded = [];
}
