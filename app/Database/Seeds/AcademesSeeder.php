<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AcademesSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Insert into stakeholders (Academe category)
        $db->table('stakeholders')->insert([
            'category' => 'Academe',
            'name' => 'XYZ University',
            'abbreviation' => 'XYZU',
            'image' => 'xyz_university.png',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $stakeholderId = $db->insertID();

        // Insert into persons
        $db->table('persons')->insert([
            'salutation' => 'Dr.',
            'first_name' => 'John',
            'middle_name' => 'A.',
            'last_name' => 'Doe',
            'designation' => 'Dean',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $personId = $db->insertID();

        // Insert into stakeholder_members
        $db->table('stakeholder_members')->insert([
            'person_id' => $personId,
            'stakeholder_id' => $stakeholderId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Insert into contact_details
        $db->table('contact_details')->insert([
            'person_id' => $personId,
            'mobile_num' => '09123456789',
            'telephone_num' => '123-4567',
            'fax_num' => '789-4567',
            'email_address' => 'johndoe@xyzu.edu',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
