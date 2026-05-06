<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('/register')->group(function(){
    Route::post('/buyer_register', [RegistrationController::class, 'buyer_registration']);
    Route::get('/buyer_email_verification/{buyer_id}', [RegistrationController::class, 'buyer_email_verification']);
});
