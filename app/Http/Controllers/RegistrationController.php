<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyerRegistrationRequest;
use App\Mail\SuccessfullRegistrationMail;
use App\Models\CartifyUserRoles;
use App\Models\CartifyUsers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function buyer_registration(BuyerRegistrationRequest $request){
        try{

            $buyer_data = $request->validated();

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

                    DB::beginTransaction();

                    CartifyUserRoles::create([
                        'role_name' => 'buyer',
                        'cartify_user_id' => $buyer_existing_check->id
                    ]);

                    DB::commit();
    
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
            
            DB::beginTransaction();

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

            DB::commit();

            // For Testing
            $create_new_buyer->email_id = 'aravindreigns797920@gmail.com';

            $buyer_name = $create_new_buyer->first_name . ' ' . $create_new_buyer->last_name;
            $encrypted_buyer_id = Crypt::encryptString($create_new_buyer->cartify_user_id);
            $verification_url = url('api/register/buyer_email_verification/'.$encrypted_buyer_id);

            try{
                Mail::to($create_new_buyer->email_id)->send(new SuccessfullRegistrationMail($buyer_name, $verification_url));
            }catch(Exception $e){
                return Response::json([
                    'message' => 'Failed to send registration completed mail',
                    'error' => $e->getMessage()
                ], 400);
            }

            return Response::json([
                'message' => 'Buyer Registered successfully!',
            ], 201);
            
        }catch(\Throwable $e){
            DB::rollBack();
            return Response::json([
                'message' => 'Something went wrong!',
                'error'=> $e->getMessage()
            ], 500);
        }
    }

    public function buyer_email_verification($buyer_id){
        try{

            $decrypted_buyer_id = Crypt::decryptString($buyer_id);

            $buyer = CartifyUsers::where('cartify_user_id', $decrypted_buyer_id)->first();

            if(!$buyer){
                return view('EmailTemplates.UserNotFoundTemplate');
            }

            if($buyer->email_verified_at !== null){
                return view('EmailTemplates.EmailAlreadyVerifiedTemplate');
            }

            DB::beginTransaction();

            $buyer->email_verified_at = now();
            $buyer->mobile_verified_at = now();
            $buyer->status = 'active';
            $buyer->save();

            DB::commit();
            return view('EmailTemplates.EmailVerifiedSuccessfullyTemplate');

        }catch(\Throwable $e){
            DB::rollBack();
            return Response::json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ]);
        }
    }
}
