<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterColumnFromNRCPTable extends Migration
{
    public function up()
    {
        // Add the image column to the nrcp table
        $fields = [
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, // Allows NULL values
                'after'      => 'description' // Change to the column after which you want to add this
            ],
        ];

        $this->forge->addColumn('nrcp_members', $fields);
    }

    public function down()
    {
        // Remove the image column when rolling back
        $this->forge->dropColumn('nrcp_members', 'image');
    }
}
