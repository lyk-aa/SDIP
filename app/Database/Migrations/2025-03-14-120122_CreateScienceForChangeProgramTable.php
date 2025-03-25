<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScienceForChangeProgramTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'research_project_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => false,
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

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('research_project_id', 'research_projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('science_for_change_program');
    }

    public function down()
    {
        $this->forge->dropTable('science_for_change_program');
    }
}
