<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Utils\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Name' => Role::User],
            ['Name' => Role::Admin],
            // Add more roles as needed
        ];

        $this->db->table('Roles')->insertBatch($data);
    }
}