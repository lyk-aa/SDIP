<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterColumnFromBalikScientistEngageTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('balik_scientist_engaged', [
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, 
                'after'      => 'description'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('balik_scientist_engaged', 'image');
    }
}
