<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonTable extends Migration
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
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'middle_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'designation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'salutation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'honorifics' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['Key Official', 'Scientist'],
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'driver_num' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'plate_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('persons');

    }

    public function down()
    {
        $this->forge->dropTable('persons');
    }
}
