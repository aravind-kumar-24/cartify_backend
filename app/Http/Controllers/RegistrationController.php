<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyerRegistrationRequest;
use App\Http\Requests\SellerRegistrationRequest;
use App\Mail\SuccessfullRegistrationMail;
use App\Models\CartifySellerProfiles;
use App\Models\CartifyUserRoles;
use App\Models\CartifyUsers;
use Exception;
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

                    return Response::json([
                        'message' => 'Seller with this Email ID already exists! Sign in to add a Buyer role',
                    ], 409);

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
            $role = 'buyer';
            $buyer_name = $create_new_buyer->first_name . ' ' . $create_new_buyer->last_name;
            $encrypted_buyer_id = Crypt::encryptString($create_new_buyer->cartify_user_id);
            $verification_url = url('api/register/email_verification/'.$encrypted_buyer_id);

            try{
                Mail::to($create_new_buyer->email_id)->send(new SuccessfullRegistrationMail($buyer_name, $verification_url, $role));
            }catch(Exception $e){
                return Response::json([
                    'message' => 'Failed to send registration completed mail',
                    'error' => $e->getMessage()
                ], 400);
            }

            return Response::json([
                'message' => 'Buyer Registered successfully! Please Log in...',
            ], 201);
            
        }catch(\Throwable $e){
            DB::rollBack();
            return Response::json([
                'message' => 'Something went wrong!',
                'error'=> $e->getMessage()
            ], 500);
        }
    }

    public function seller_registration(SellerRegistrationRequest $request){
        try{

            $seller_data = $request->validated();

            $seller_existing_check = CartifyUsers::where('email_id', $seller_data['email_id'])
                ->orWhere('mobile_number', $seller_data['mobile_number'])->first();

            if($seller_existing_check){
                $role_check = CartifyUserRoles::where('cartify_user_id', $seller_existing_check->id)
                    ->where('role_name', 'seller')
                    ->first();

                if($role_check){
                    if($seller_existing_check->email_id === $seller_data['email_id']) {
                        return Response::json([
                            'message'=> 'Seller with this Email ID already exists!',
                        ], 409);
                    }else if($seller_existing_check->mobile_number === $seller_data['mobile_number']){
                        return Response::json([
                            'message'=> 'Seller with this Mobile Number already exists!',
                        ], 409);
                    }
                }

                if ($seller_existing_check->email_id === $seller_data['email_id']) {

                    return Response::json([
                        'message' => 'Buyer with this Email ID already exists! Sign in to add a Seller role',
                    ], 409);

                } else if ($seller_existing_check->mobile_number === $seller_data['mobile_number']){
                    return Response::json([
                        'message' => 'Mobile Number is already registered with another account!'
                    ], 409);
                }
            }

            $user_id = 'CARTIFY' . date('Ymd') . strtoupper(substr(Str::uuid()->toString(), 0, 8));
            
            DB::beginTransaction();

            $create_new_seller = new CartifyUsers();
            $create_new_seller->cartify_user_id = $user_id;
            $create_new_seller->first_name = $seller_data['first_name'];
            $create_new_seller->last_name = $seller_data['last_name'];
            $create_new_seller->email_id = $seller_data['email_id'];
            $create_new_seller->mobile_number = $seller_data['mobile_number'];
            $create_new_seller->password = Hash::make($seller_data['password']);
            $create_new_seller->save();

            CartifySellerProfiles::create([
                'cartify_user_id' => $create_new_seller->id,
                'business_name' => $seller_data['business_name'],
                'business_type_id' => $seller_data['business_type'],
                'business_address' => $seller_data['business_address'],
                'city_id' => $seller_data['city'],
                'state_id' => $seller_data['state'],
                'pincode' => $seller_data['pincode']
            ]);

            CartifyUserRoles::create([
                'role_name' => 'seller',
                'cartify_user_id' => $create_new_seller->id
            ]);

            DB::commit();

            // For Testing
            $create_new_seller->email_id = 'aravindreigns797920@gmail.com';
            $role = 'seller';
            $seller_name = $create_new_seller->first_name . ' ' . $create_new_seller->last_name;
            $encrypted_seller_id = Crypt::encryptString($create_new_seller->cartify_user_id);
            $verification_url = url('api/register/email_verification/'.$encrypted_seller_id);

            try{
                Mail::to($create_new_seller->email_id)->send(new SuccessfullRegistrationMail($seller_name, $verification_url, $role));
            }catch(Exception $e){
                return Response::json([
                    'message' => 'Failed to send registration completed mail',
                    'error' => $e->getMessage()
                ], 400);
            }

            return Response::json([
                'message' => 'Seller Registered successfully! Please Log in...',
            ], 201);

        }catch(\Throwable $e){
            DB::rollBack();
            return Response::json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function email_verification(string $cartify_user_id){
        try{

            $decrypted_id = Crypt::decryptString($cartify_user_id);

            $cartify_user = CartifyUsers::where('cartify_user_id', $decrypted_id)->first();

            if(!$cartify_user){
                return view('EmailTemplates.UserNotFoundTemplate');
            }

            if($cartify_user->email_verified_at !== null){
                return view('EmailTemplates.EmailAlreadyVerifiedTemplate');
            }

            DB::beginTransaction();

            $cartify_user->email_verified_at = now();
            $cartify_user->mobile_verified_at = now();
            $cartify_user->status = 'active';
            $cartify_user->save();

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

    public function get_count(string $page){
        try{

            $users = CartifyUsers::whereNull('deleted_at')
                ->whereNotNull('email_verified_at')
                ->whereNotNull('mobile_verified_at')
                ->where('status', 'active');
            
            if($page != 'all'){
                $users->whereHas('CartifyUserRoles', function($query) use ($page){
                    $query->where('role_name', strtolower($page));
                });
            }

            $count = $users->count();

            return Response::json([
                'message' => 'Count fetched successfully!',
                'count' => $count
            ],200);

        }catch(\Throwable $e){
            return Response::json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
