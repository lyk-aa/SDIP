<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStakeholderTable extends Migration
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

            'abbreviation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'category' => [
                'type' => 'ENUM',
                'constraint' => ['Regional Office', 'NGA', 'Academe', 'LGU', 'NGO', 'SUC', 'Business Sector'],
                'null' => false,
            ],
            'municipality' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'street' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'barangay' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => null,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => null,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('stakeholders');
    }

    public function down()
    {
        $this->forge->dropTable('stakeholders');
    }
}
