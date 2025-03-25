<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStakeholderMembersTable extends Migration
{
    public function up()
    {
        $this->forge->addKey('person_id', TRUE);
        $this->db->query('ALTER TABLE stakeholder_members ADD CONSTRAINT unique_person UNIQUE (person_id)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE stakeholder_members DROP CONSTRAINT unique_person');
    }
}
