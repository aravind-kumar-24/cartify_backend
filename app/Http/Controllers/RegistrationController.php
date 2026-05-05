<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyerRegistrationRequest;
use App\Models\CartifyUserRoles;
use App\Models\CartifyUsers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function buyer_registration(BuyerRegistrationRequest $request){
        try{

            $buyer_data = $request->all();

            $buyer_existing_check = CartifyUsers::where('email_id', $buyer_data['email_id'])
                ->orWhere('mobile_number', $buyer_data['mobile_number'])->first();

            if($buyer_existing_check){
                $role_check = CartifyUserRoles::where('cartify_user_id', $buyer_existing_check->id)
                    ->where('role_name', 'buyer')
                    ->first();

                if($role_check){
                    if($buyer_existing_check->email_id === $buyer_data['email_id']) {
                        return Response::json([
                            'message'=> 'Buyer with this Email ID already exists!',
                        ], 409);
                    }else if($buyer_existing_check->mobile_number === $buyer_data['mobile_number']){
                        return Response::json([
                            'message'=> 'Buyer with this Mobile Number already exists!',
                        ], 409);
                    }
                }

                if ($buyer_existing_check->email_id === $buyer_data['email_id']) {
                    CartifyUserRoles::create([
                        'role_name' => 'buyer',
                        'cartify_user_id' => $buyer_existing_check->id
                    ]);
    
                    return Response::json([
                        'message' => 'Buyer Registration completed successfully for a existing Seller!',
                    ], 201);

                } else if ($buyer_existing_check->mobile_number === $buyer_data['mobile_number']){
                    return Response::json([
                        'message' => 'Mobile Number is already registered with another account!'
                    ], 409);
                }
            }

            $user_id = 'CARTIFY' . date('Ymd') . strtoupper(substr(Str::uuid()->toString(), 0, 8));

            $create_new_buyer = new CartifyUsers();
            $create_new_buyer->cartify_user_id = $user_id;
            $create_new_buyer->first_name = $buyer_data['first_name'];
            $create_new_buyer->last_name = $buyer_data['last_name'];
            $create_new_buyer->email_id = $buyer_data['email_id'];
            $create_new_buyer->mobile_number = $buyer_data['mobile_number'];
            $create_new_buyer->password = Hash::make($buyer_data['password']);
            $create_new_buyer->save();

            CartifyUserRoles::create([
                'role_name' => 'buyer',
                'cartify_user_id' => $create_new_buyer->id
            ]);

            return Response::json([
                'message' => 'Buyer Registered successfully!',
            ], 201);
            
        }catch(Exception $e){
            return Response::json([
                'message' => 'Something went wrong!',
                'error'=> $e->getMessage()
            ], 500);
        }
    }
}
