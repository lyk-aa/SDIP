<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDelimiterForNRCPAndBalikScientist extends Migration
{
    public function up()
    {
        // Create trigger for nrcp_members
        $this->db->query("
            DELIMITER $$

            CREATE TRIGGER after_delete_nrcp
            AFTER DELETE ON nrcp_members
            FOR EACH ROW
            BEGIN
                -- Check if the person_id exists in either table
                IF NOT EXISTS (SELECT 1 FROM balik_scientist_engaged WHERE person_id = OLD.person_id) THEN
                    DELETE FROM persons WHERE id = OLD.person_id;
                END IF;
            END $$

            DELIMITER ;
        ");

        // Create trigger for balik_scientist_engaged
        $this->db->query("
            DELIMITER $$

            CREATE TRIGGER after_delete_scientist
            AFTER DELETE ON balik_scientist_engaged
            FOR EACH ROW
            BEGIN
                -- Check if the person_id exists in either table
                IF NOT EXISTS (SELECT 1 FROM nrcp_members WHERE person_id = OLD.person_id) THEN
                    DELETE FROM persons WHERE id = OLD.person_id;
                END IF;
            END $$

            DELIMITER ;
        ");
    }

    public function down()
    {
        // Drop the triggers if rolling back
        $this->db->query("DROP TRIGGER IF EXISTS after_delete_nrcp;");
        $this->db->query("DROP TRIGGER IF EXISTS after_delete_scientist;");
    }
}
