<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateStakeholderCategoryEnum extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `stakeholders` 
        MODIFY `category` ENUM(
            'Regional Office', 'NGA', 'Academe', 'LGU', 'NGO', 'Business Sector', 'Contacts'
        ) NOT NULL");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `stakeholders` 
        MODIFY `category` ENUM(
            'Regional Office', 'NGA', 'Academe', 'LGU', 'NGO', 'SUC', 'Business Sector'
        ) NOT NULL");
    }
}
