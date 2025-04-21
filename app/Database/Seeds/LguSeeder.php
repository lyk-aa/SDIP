<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LguSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Insert into stakeholders (LGU category)
        $db->table('stakeholders')->insert([
            'category' => 'LGU',
            'name' => 'Passi City Government',
            'abbreviation' => 'PCG',
            'image' => 'passi_city_logo.png',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $stakeholderId = $db->insertID();

        // LGU Officials Data
        $officials = [
            [
                'salutation' => 'Hon.',
                'first_name' => 'Stephen',
                'middle_name' => 'A.',
                'last_name' => 'Palmares',
                'designation' => 'Mayor'
            ],
            [
                'salutation' => 'Hon.',
                'first_name' => 'Jessry',
                'middle_name' => 'P.',
                'last_name' => 'Palmares',
                'designation' => 'Vice Mayor'
            ],
            [
                'salutation' => 'Hon.',
                'first_name' => 'John',
                'middle_name' => 'D.',
                'last_name' => 'Doe',
                'designation' => 'Councilor'
            ]
        ];

        foreach ($officials as $official) {
            // Insert into persons
            $db->table('persons')->insert([
                'salutation' => $official['salutation'],
                'first_name' => $official['first_name'],
                'middle_name' => $official['middle_name'],
                'last_name' => $official['last_name'],
                'designation' => $official['designation'],
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
                'telephone_num' => '033-311-50' . rand(83, 85),
                'fax_num' => '033-311-50' . rand(83, 85),
                'email_address' => strtolower($official['last_name']) . '@passi.gov.ph',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
