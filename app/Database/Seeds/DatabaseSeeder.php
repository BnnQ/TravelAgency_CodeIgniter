<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('CountrySeeder');
        $this->call('CitySeeder');
        $this->call('RoleSeeder');
        $this->call('UserSeeder');
        $this->call('HotelSeeder');
        $this->call('ImageSeeder');
    }
}