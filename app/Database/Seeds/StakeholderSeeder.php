<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StakeholderSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $db->table('persons')->insertBatch([
            [
                'honorifics' => 'Dr.',
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'designation' => 'Director',
                'role' => 'Director',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'honorifics' => 'Hon.',
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'designation' => 'Director',
                'role' => 'Head',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);

        $persons = $db->table('persons')->get()->getResult();

        $db->table('stakeholders')->insertBatch([
            [
                'abbreviation' => 'DOST',
                'name' => 'Department of Science and Technology',
                'category' => 'NGA',
                'municipality' => 'Lapaz',
                'province' => 'Iloilo',
                'street' => 'Magsaysay',
                'barangay' => 'Magsaysay Village',
                'country' => 'Philippines',
                'postal_code' => '5000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbreviation' => 'CHED',
                'name' => 'Commission on Higher Education',
                'category' => 'Academe',
                'municipality' => 'Lapaz',
                'province' => 'Iloilo',
                'street' => 'Magsaysay',
                'barangay' => 'Magsaysay Village',
                'country' => 'Philippines',
                'postal_code' => '5000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);

        $stakeholders = $db->table('stakeholders')->get()->getResult();

        $db->table('stakeholder_members')->insertBatch([
            [
                'person_id' => $persons[0]->id,
                'stakeholder_id' => $stakeholders[0]->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'person_id' => $persons[1]->id,
                'stakeholder_id' => $stakeholders[1]->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);

        $db->table('contact_details')->insertBatch([
            [
                'person_id' => $persons[0]->id,
                'telephone_num' => '123-4567',
                'email_address' => 'juan.dela.cruz@example.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'person_id' => $persons[1]->id,
                'telephone_num' => '765-4321',
                'email_address' => 'maria.santos@example.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
