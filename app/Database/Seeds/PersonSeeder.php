<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PersonSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'first_name' => 'John',
                'middle_name' => 'A.',
                'last_name' => 'Doe',
                'designation' => 'Director',
                'salutation' => 'Mr.',
                'honorifics' => 'PhD',
                'role' => 'Key Official',
                'description' => 'Leading the department.',
                'driver_num' => '123456789',
                'plate_number' => 'ABC-123',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Jane',
                'middle_name' => 'B.',
                'last_name' => 'Smith',
                'designation' => 'Scientist',
                'salutation' => 'Dr.',
                'honorifics' => 'MSc',
                'role' => 'Scientist',
                'description' => 'Researching new innovations.',
                'driver_num' => '987654321',
                'plate_number' => 'XYZ-789',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data into the database
        $this->db->table('persons')->insertBatch($data);
    }
}
