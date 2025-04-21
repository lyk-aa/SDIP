<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AcademeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'University of the Philippines Visayas', 'category' => 'Academe'],
            ['name' => 'Central Philippine University', 'category' => 'Academe'],
            ['name' => 'West Visayas State University', 'category' => 'Academe'],
            ['name' => 'University of San Agustin', 'category' => 'Academe'],
            ['name' => 'Iloilo Science and Technology University', 'category' => 'Academe'],
            ['name' => 'John B. Lacson Foundation Maritime University', 'category' => 'Academe'],
            ['name' => 'St. Paul University Iloilo', 'category' => 'Academe'],
            ['name' => 'Western Institute of Technology', 'category' => 'Academe'],
            ['name' => 'Iloilo Doctors', 'category' => 'Academe']
        ];

        $this->db->table('stakeholders')->insertBatch($data);
    }
}
