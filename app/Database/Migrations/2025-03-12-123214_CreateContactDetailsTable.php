<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactDetailsTable extends Migration
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
                'null' => false,
            ],
            'mobile_num' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'telephone_num' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'fax_num' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'email_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('person_id', 'persons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('contact_details');
    }

    public function down()
    {
        $this->forge->dropTable('contact_details');

    }
}
