<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterColumnFromInstitutionTable extends Migration
{
    public function up()
    {
        // Modify the 'type' column with new ENUM values
        $fields = [
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['State University', 'College', 'Training Center', 'Research Institute', 'Member Institution'],
                'null'       => false,
            ],
        ];

        $this->forge->modifyColumn('institutions', $fields);
    }

    public function down()
    {
        // Revert the 'type' column to its previous state
        $fields = [
            'type' => [
                'type'       => 'ENUM', 
                'constraint' => ['member institution', 'sucsheis'], // Replace with the original enum values
                'null'       => false,
            ],
        ];

        $this->forge->modifyColumn('institutions', $fields);
    }
}
