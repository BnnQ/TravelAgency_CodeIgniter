<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Login' => 'test', 'HashedPassword' => password_hash("Qwerty1234%", PASSWORD_DEFAULT), 'Email' => 'user1@example.com', 'RoleId' => 1, 'Discount' => 0, 'LastAuthenticationToken' => '', 'Avatar' => ''],
            ['Login' => 'admin', 'HashedPassword' => password_hash("Qwerty1234%", PASSWORD_DEFAULT), 'Email' => 'user2@example.com', 'RoleId' => 2, 'Discount' => 0, 'LastAuthenticationToken' => '', 'Avatar' => ''],
            // Add more users as needed
        ];

        $this->db->table('Users')->insertBatch($data);
    }
}