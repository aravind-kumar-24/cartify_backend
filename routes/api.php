<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('/register')->group(function(){
    Route::post('/buyer_register', [RegistrationController::class, 'buyer_registration']);
});
