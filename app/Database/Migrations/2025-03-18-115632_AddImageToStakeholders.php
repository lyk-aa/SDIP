<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageToStakeholders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('stakeholders', [
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'postal_code',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('stakeholders', 'image');
    }
}
