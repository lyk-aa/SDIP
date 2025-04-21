<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterInstitutionTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('institutions', [
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'address',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('institutions', 'file');
    }
}
