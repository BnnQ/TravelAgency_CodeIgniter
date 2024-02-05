<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Name' => 'Country 1'],
            ['Name' => 'Country 2'],
            // Add more countries as needed
        ];

        $this->db->table('Countries')->insertBatch($data);
    }
}