<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConsortiumMembersTable extends Migration
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
            'consortium_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
            ],
            'institution_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
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
        $this->forge->createTable('consortium_members');

        $this->forge->addForeignKey('consortium_id', 'consortiums', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('institution_id', 'institutions', 'id', false, 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('consortium_members');
    }
}
