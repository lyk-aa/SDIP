<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBalikScientistEngagedTable extends Migration
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
            'person_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
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
        $this->forge->addForeignKey('institution_id', 'institutions', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('person_id', 'persons', 'id', false, 'CASCADE');
        $this->forge->createTable('balik_scientist_engaged');
    }

    public function down()
    {
        $this->forge->dropTable('balik_scientist_engaged');
    }
}
