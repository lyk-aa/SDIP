<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNcrpMembersTable extends Migration
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
            'person_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'institution_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addForeignKey('person_id', 'persons', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('institution_id', 'institutions', 'id', false, 'CASCADE'); // Added Institution Foreign Key
        $this->forge->createTable('nrcp_members');
    }

    public function down()
    {
        $this->forge->dropTable('nrcp_members');
    }
}
