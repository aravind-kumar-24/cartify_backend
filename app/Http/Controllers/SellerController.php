<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerProfileUpdationRequest;
use App\Models\CartifyUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    public function update_seller_profile(SellerProfileUpdationRequest $request){
        try{
            $updated_data = $request->validated();

            $seller = CartifyUsers::find(auth('api')->id());

            if(!$seller){
                return Response::json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $mobile_unique_check = CartifyUsers::where('mobile_number', $updated_data['mobile_number'])
                ->where('cartify_user_id', '!=', $seller->cartify_user_id)->exists();

            if($mobile_unique_check){
                return Response::json([
                    'message'=> 'Seller with this Mobile Number already exists!',
                ], 409);
            }

            $seller->first_name = $updated_data['first_name'];
            $seller->last_name = $updated_data['last_name'];
            $seller->mobile_number = $updated_data['mobile_number'];

            if($request->hasFile('profile_pic')){
                if(!empty($seller->profile_picture_path) && Storage::disk('public')->exists($seller->profile_picture_path)){
                    Storage::disk('public')->delete($seller->profile_picture_path);
                }

                $path = $request->file('profile_pic')->store('seller/profile-pictures', 'public');
                $seller->profile_picture_path = $path;
            }

            $seller->save();

            return Response::json([
                'message' => 'Seller Profile Updated Successfully'
            ], 200);
        }catch(\Throwable $e){
            return Response::json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
