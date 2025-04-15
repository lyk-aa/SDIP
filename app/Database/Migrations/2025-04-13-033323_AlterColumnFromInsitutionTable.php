<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterColumnFromInstitutionTable extends Migration
{
    public function up()
    {
        // Add description column as VARCHAR(255)
        $this->forge->addColumn('institution', [
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,  // Optional: set to true if the description is nullable
            ],
            'status' => [
                'type'    => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active', // Optional: default to 'active'
            ],
        ]);
    }

    public function down()
    {
        // Remove description and status columns if rolling back
        $this->forge->dropColumn('institution', ['description', 'status']);
    }
}
