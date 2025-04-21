<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterRdInnovationCentersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rd_innovation_centers', [
            'longitude' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'description',
            ],
            'latitude' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'longitude',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rd_innovation_centers', ['longitude', 'latitude']);
    }
}
