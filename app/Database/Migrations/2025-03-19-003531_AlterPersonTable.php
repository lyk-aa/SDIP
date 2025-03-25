<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPersonTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('persons', [
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('persons', 'image');
    }
}
