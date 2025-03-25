<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConsortiumRolesTable extends Migration
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
            'consortium_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'role_name' => [
                'type' => 'ENUM',
                'constraint' => "'member', 'alternate member', 'twg', 'alternate twg'",
            ],
            'member_since' => [
                'type' => 'DATE',
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
        $this->forge->addForeignKey('consortium_id', 'consortiums', 'id', false, 'CASCADE');
        $this->forge->createTable('consortium_roles');
    }

    public function down()
    {
        $this->forge->dropTable('consortium_roles');
    }
}
