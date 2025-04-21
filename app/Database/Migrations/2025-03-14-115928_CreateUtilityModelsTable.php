<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUtilityModelsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'filing_date' => [
                'type' => 'DATE',
            ],
            'application_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => "'pending', 'approved', 'rejected'",
            ],
            'institution_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('institution_id', 'institutions', 'id', false, 'CASCADE');
        $this->forge->createTable('utility_models');
    }

    public function down()
    {
        $this->forge->dropTable('utility_models');
    }
}
