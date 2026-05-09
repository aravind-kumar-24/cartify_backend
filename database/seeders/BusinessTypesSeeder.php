<?php

namespace Database\Seeders;

use App\Models\BusinessTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessTypesSeeder extends Seeder
{
    
    public function run(): void
    {
        $business_types = [
            [
                'business_type_name' => 'Individual'
            ],
            [
                'business_type_name' => 'Proprietorship'
            ],
            [
                'business_type_name' => 'Partnership'
            ],
            [
                'business_type_name' => 'Private Limited'
            ],
        ];

        foreach($business_types as $types){
            BusinessTypes::create($types);
        }
    }
}
