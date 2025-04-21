<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStakeholderMembersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'person_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'stakeholder_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
                'default' => null,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
                'default' => null,
                'on_update' => 'CURRENT_TIMESTAMP'
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('person_id', 'persons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('stakeholder_id', 'stakeholders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stakeholder_members');

    }

    public function down()
    {
        $this->forge->dropTable('stakeholder_members');
    }
}
