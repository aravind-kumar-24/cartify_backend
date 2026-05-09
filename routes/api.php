<?php

use App\Http\Controllers\AssetsController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('/register')->group(function(){
    Route::post('/buyer_register', [RegistrationController::class, 'buyer_registration']);
    Route::get('/email_verification/{cartify_user_id}', [RegistrationController::class, 'email_verification']);
    Route::post('/seller_register', [RegistrationController::class, 'seller_registration']);
});

Route::prefix('/assets')->group(function(){
    Route::get('/get_business_types', [AssetsController::class, 'get_business_types']);
    Route::get('/get_states', [AssetsController::class, 'get_states']);
    Route::get('/get_cities/{state_id}', [AssetsController::class, 'get_cities']);
});
