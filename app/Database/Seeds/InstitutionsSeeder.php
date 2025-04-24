<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InstitutionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'stakeholder_id' => 1,
                'image' => 'inst1.png',
                'type' => 'University',
                'file' => 'brochure1.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'stakeholder_id' => 2,
                'image' => 'inst2.png',
                'type' => 'Government',
                'file' => 'report2.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'stakeholder_id' => 3,
                'image' => 'inst3.png',
                'type' => 'Private Sector',
                'file' => 'summary3.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'stakeholder_id' => 4,
                'image' => 'inst4.png',
                'type' => 'NGO',
                'file' => 'proposal4.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'stakeholder_id' => 5,
                'image' => 'inst5.png',
                'type' => 'Research Institute',
                'file' => 'data5.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('institutions')->insertBatch($data);
    }
}
