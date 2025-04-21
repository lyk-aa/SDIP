<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DelimiterFunction extends Migration
{
    public function up()
    {
        // Trigger for deleting from persons when NRCP member is deleted
        $this->db->query("
            CREATE TRIGGER after_delete_nrcp
            AFTER DELETE ON nrcp_members
            FOR EACH ROW
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM balik_scientist_engaged WHERE person_id = OLD.person_id
                ) THEN
                    DELETE FROM persons WHERE id = OLD.person_id;
                END IF;
            END
        ");

        // Trigger for deleting from persons when Balik Scientist is deleted
        $this->db->query("
            CREATE TRIGGER after_delete_scientist
            AFTER DELETE ON balik_scientist_engaged
            FOR EACH ROW
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM nrcp_members WHERE person_id = OLD.person_id
                ) THEN
                    DELETE FROM persons WHERE id = OLD.person_id;
                END IF;
            END
        ");
    }

    public function down()
    {
        // Drop the triggers
        $this->db->query("DROP TRIGGER IF EXISTS after_delete_nrcp");
        $this->db->query("DROP TRIGGER IF EXISTS after_delete_scientist");
    }
}
