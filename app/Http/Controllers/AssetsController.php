<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessTypes;
use App\Models\Cities;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AssetsController extends Controller
{
    public function get_business_types(){
        try{

            $business_types = BusinessTypes::whereNull('deleted_at')
                ->select('id', 'business_type_name')
                ->orderBy('id')
                ->get();

            if($business_types->isEmpty()){
                return Response::json([
                    'message' => 'Business Types not found'
                ], 404);
            }

            return Response::json([
                'business_types' => $business_types,
            ], 200);

        }catch(\Throwable $e){
            return Response::json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get_states(){
        try{

            $states = States::whereNull('deleted_at')
                ->select('id', 'state_name')
                ->orderBy('id')
                ->get();

            if($states->isEmpty()){
                return Response::json([
                    'message' => 'States not found'
                ], 404);
            }

            return Response::json([
                'states' => $states
            ], 200);

        }catch(\Throwable $e){
            return Response::json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get_cities(int $state_id){
        try{

            $state_exists = States::whereNull('deleted_at')
                ->where('id', $state_id)
                ->exists();

            if(!$state_exists){
                return Response::json([
                    'message' => 'Invalid State'
                ], 404);
            }

            $cities = Cities::whereNull('deleted_at')
                ->select('id', 'city_name')
                ->where('state_id', $state_id)
                ->orderBy('city_name')
                ->get();

            if($cities->isEmpty()){
                return Response::json([
                    'message' => 'Cities not found'
                ], 404);
            }

            return Response::json([
                'cities' => $cities
            ], 200);

        }catch(\Throwable $e){
            return Response::json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
