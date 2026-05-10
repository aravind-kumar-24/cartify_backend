<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\CartifyUserRoles;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request){

        try{

            $credentials = $request->validated();

            $token = auth('api')->attempt([
                'email_id' => $credentials['email_id'],
                'password' => $credentials['password']
            ]);

            if(!$token){
                return Response::json([
                    'message' => 'Invalid credentials!'
                ], 401);
            }

            $user = auth('api')->user();

            if($user->status === 'inactive'){
                return Response::json([
                    'message' => 'Your Account is Inactive! Contact the Admin.'
                ], 401);
            }
            
            if($user->status === 'deleted'){
                return Response::json([
                    'message' => 'Your Account is Suspended! Contact the Admin.'
                ], 401);
            }

            if($user->email_verified_at === null){
                return Response::json([
                    'message' => 'Please verify your email before logging in.'
                ], 401);
            }

            $user_role_check = CartifyUserRoles::where('cartify_user_id', $user->id)
                ->where('role_name', $credentials['user_type'])
                ->first();

            if(!$user_role_check){
                auth('api')->logout();
                $opposite = $credentials['user_type'] === 'Buyer' ? 'Seller' : 'Buyer';

                return Response::json([
                    'message' => "This account is registered as a {$opposite}.",
                ], 401);
            }

            return Response::json([
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'bearer',
            ], 200);

        }catch(\Throwable $e){
            return Response::json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
