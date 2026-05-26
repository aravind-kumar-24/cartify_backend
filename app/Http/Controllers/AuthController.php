<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\CartifyUserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        try {

            $credentials = $request->validated();

            $token = auth('api')->attempt([
                'email' => $credentials['email_id'],
                'password' => $credentials['password']
            ]);

            if (!$token) {
                return Response::json([
                    'message' => 'Invalid credentials!'
                ], 401);
            }

            $user = auth('api')->user();

            if ($user->status === 'inactive') {
                return Response::json([
                    'message' => 'Your Account is Inactive! Contact the Admin.'
                ], 401);
            }

            if ($user->status === 'deleted') {
                return Response::json([
                    'message' => 'Your Account is Suspended! Contact the Admin.'
                ], 401);
            }

            if ($user->email_verified_at === null) {
                return Response::json([
                    'message' => 'Please verify your email before logging in.'
                ], 401);
            }

            $user_role_check = CartifyUserRoles::where('cartify_user_id', $user->id)
                ->where('role_name', $credentials['user_type'])
                ->first();

            if (!$user_role_check) {
                auth('api')->logout();
                $opposite = $credentials['user_type'] === 'Buyer' ? 'Seller' : 'Buyer';

                return Response::json([
                    'message' => "This account is registered as a {$opposite}.",
                ], 401);
            }

            $encrypted_role = Crypt::encryptString($credentials['user_type']);

            return Response::json([
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'bearer',
                'role' => $credentials['user_type'],
                'encrypted_role' => $encrypted_role
            ], 200);
        } catch (\Throwable $e) {
            return Response::json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get_auth_user(Request $request)
    {
        try {

            $auth_user = auth('api')->user();
            $role = Crypt::decryptString($request->header('Role'));

            $user_data = [
                'id' => $auth_user->id,
                'user_id' => $auth_user->cartify_user_id,
                'first_name' => $auth_user->first_name,
                'last_name' => $auth_user->last_name,
                'email' => $auth_user->email,
                'mobile_number' => $auth_user->mobile_number,
                'profile_picture_path' => $auth_user->profile_picture_path,
                'role_name' => $role
            ];

            if ($role === 'Seller') {
                $seller_profile = $auth_user->SellerProfile->first();

                $user_data = array_merge($user_data, [
                    'business_name' => $seller_profile?->business_name,
                    'business_type_id' => $seller_profile?->business_type_id,
                    'business_address' => $seller_profile?->business_address,
                    'city_id' => $seller_profile?->city_id,
                    'state_id' => $seller_profile?->state_id,
                    'pincode' => $seller_profile?->pincode,
                    'kyc_status' => $seller_profile?->kyc_status,
                    'kyc_rejected_reason' => $seller_profile?->kyc_rejected_reason,
                    'aadhar_number' => $seller_profile?->aadhar_number,
                    'aadhar_document_path' => $seller_profile?->aadhar_document_path,
                    'gst_number' => $seller_profile?->gst_number,
                    'gst_document_path' => $seller_profile?->gst_document_path,
                    'pan_number' => $seller_profile?->pan_number,
                    'pan_document_path' => $seller_profile?->pan_document_path,
                    'account_holder_name' => $seller_profile?->account_holder_name,
                    'account_number' => $seller_profile?->account_number,
                    'ifsc_code' => $seller_profile?->ifsc_code,
                    'bank_name' => $seller_profile?->bank_name,
                    'bank_proof_document_path' => $seller_profile?->bank_proof_document_path,
                    'business_logo_path' => $seller_profile?->business_logo_path,
                ]);
            }

            return Response::json([
                'message' =>  $role .' details fetched successfully',
                'user_data' => $user_data
            ], 200);

        } catch (\Throwable $e) {
            return Response::json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
