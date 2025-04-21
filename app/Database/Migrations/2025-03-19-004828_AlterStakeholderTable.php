<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStakeholderTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('stakeholders', [
            'classification' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'image',
            ],
            'source_agency' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'classification',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('stakeholders', ['classification', 'source_agency']);
    }
}
