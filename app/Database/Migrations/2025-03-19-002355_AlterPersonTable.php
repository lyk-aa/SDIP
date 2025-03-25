<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPersonTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('persons', [
            'position' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'description',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn(table: 'persons', 'position');
    }
}
