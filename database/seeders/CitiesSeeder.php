<?php

namespace Database\Seeders;

use App\Models\Cities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            [
                'city_name' => 'Chennai',
                'state_id' => 1
            ],
            [
                'city_name' => 'Coimbatore',
                'state_id' => 1
            ],
            [
                'city_name' => 'Madurai',
                'state_id' => 1
            ],
            [
                'city_name' => 'Tiruchirappalli',
                'state_id' => 1
            ],
            [
                'city_name' => 'Salem',
                'state_id' => 1
            ],
            [
                'city_name' => 'Tirunelveli',
                'state_id' => 1
            ],
            [
                'city_name' => 'Tiruppur',
                'state_id' => 1
            ],
            [
                'city_name' => 'Ranipet',
                'state_id' => 1
            ],
            [
                'city_name' => 'Vellore',
                'state_id' => 1
            ],
            [
                'city_name' => 'Erode',
                'state_id' => 1
            ],
            [
                'city_name' => 'Thoothukudi',
                'state_id' => 1
            ],
            [
                'city_name' => 'Dindigul',
                'state_id' => 1
            ],
            [
                'city_name' => 'Thanjavur',
                'state_id' => 1
            ],
            [
                'city_name' => 'Kancheepuram',
                'state_id' => 1
            ],
            [
                'city_name' => 'Tiruvannamalai',
                'state_id' => 1
            ],
            [
                'city_name' => 'Kanyakumari',
                'state_id' => 1
            ],
            [
                'city_name' => 'Namakkal',
                'state_id' => 1
            ],
            [
                'city_name' => 'Cuddalore',
                'state_id' => 1
            ],
            [
                'city_name' => 'Karur',
                'state_id' => 1
            ],
            [
                'city_name' => 'Villupuram',
                'state_id' => 1
            ],
            [
                'city_name' => 'Nagapattinam',
                'state_id' => 1
            ],
            [
                'city_name' => 'Virudhunagar',
                'state_id' => 1
            ],
            [
                'city_name' => 'Sivaganga',
                'state_id' => 1
            ],
            [
                'city_name' => 'Pudukkottai',
                'state_id' => 1
            ],
            [
                'city_name' => 'Theni',
                'state_id' => 1
            ],
            [
                'city_name' => 'Ramanathapuram',
                'state_id' => 1
            ],
            [
                'city_name' => 'Nilgiris',
                'state_id' => 1
            ],
            [
                'city_name' => 'Krishnagiri',
                'state_id' => 1
            ],
            [
                'city_name' => 'Dharmapuri',
                'state_id' => 1
            ],
            [
                'city_name' => 'Perambalur',
                'state_id' => 1
            ],
            [
                'city_name' => 'Ariyalur',
                'state_id' => 1
            ],
            [
                'city_name' => 'Tiruvarur',
                'state_id' => 1
            ],
            [
                'city_name' => 'Kallakurichi',
                'state_id' => 1
            ],
            [
                'city_name' => 'Chengalpattu',
                'state_id' => 1
            ],
            [
                'city_name' => 'Tenkasi',
                'state_id' => 1
            ],
            [
                'city_name' => 'Tirupattur',
                'state_id' => 1
            ],
            [
                'city_name' => 'Mayiladuthurai',
                'state_id' => 1
            ],
            [
                'city_name' => 'Viruthachalam',
                'state_id' => 1
            ],
        ];

        foreach($cities as $city){
            Cities::create($city);
        }
    }
}
