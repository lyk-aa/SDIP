<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatentTable extends Migration
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
            'institution_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'application_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => "'pending', 'approved', 'rejected'",
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
        $this->forge->addForeignKey('institution_id', 'institutions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('patents');
    }

    public function down()
    {
        $this->forge->dropTable('patents');
    }
}
