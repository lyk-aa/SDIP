<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveColumnsFromInstitutions extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('institutions', ['abbreviation', 'name', 'address']);
    }

    public function down()
    {
        $this->forge->addColumn('institutions', [
            'abbreviation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'address' => [
                'type' => 'TEXT',
            ],
        ]);
    }
}
