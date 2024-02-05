<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['HotelId' => 1, 'ImagePath' => 'path/to/image1.jpg'],
            ['HotelId' => 2, 'ImagePath' => 'path/to/image2.jpg'],
            // Add more images as needed
        ];

        $this->db->table('Images')->insertBatch($data);
    }
}