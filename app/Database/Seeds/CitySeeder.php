<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Name' => 'City 1', 'CountryId' => 1],
            ['Name' => 'City 2', 'CountryId' => 1],
            // Add more cities as needed
        ];

        $this->db->table('Cities')->insertBatch($data);
    }
}