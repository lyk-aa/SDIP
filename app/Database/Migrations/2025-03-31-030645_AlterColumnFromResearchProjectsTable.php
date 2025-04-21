<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterColumnFromResearchProjectsTable extends Migration
{
    public function up()
    {
        // Define the new columns to be added
        $fields = [
            'sector' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'id'
            ],
            'project_objectives' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'description'
            ],
            'duration' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'status'
            ],
            'project_leader' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'duration'
            ],
            'approved_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
                'after'      => 'project_leader'
            ],
        ];

        // Add the columns to the table
        $this->forge->addColumn('research_projects', $fields);
    }

    public function down()
    {
        // Drop the added columns during rollback
        $this->forge->dropColumn('research_projects', ['sector', 'project_objectives', 'duration', 'project_leader', 'approved_amount']);
    }
}
