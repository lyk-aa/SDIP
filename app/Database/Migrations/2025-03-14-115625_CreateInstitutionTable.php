<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstitutionTable extends Migration
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
            'stakeholder_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'abbreviation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => "'member institution', 'sucsheis'",
            ],
            'address' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('stakeholder_id', 'stakeholders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('institutions');
    }

    public function down()
    {
        $this->forge->dropTable('institutions');
    }
}
