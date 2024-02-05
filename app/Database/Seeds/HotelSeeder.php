<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Name' => 'Hotel 1', 'CountryId' => 1, 'CityId' => 1, 'Stars' => 5, 'Cost' => 100, 'Info' => 'Info about Hotel 1'],
            ['Name' => 'Hotel 2', 'CountryId' => 1, 'CityId' => 2, 'Stars' => 4, 'Cost' => 80, 'Info' => 'Info about Hotel 2'],
            // Add more hotels as needed
        ];

        $this->db->table('Hotels')->insertBatch($data);
    }
}