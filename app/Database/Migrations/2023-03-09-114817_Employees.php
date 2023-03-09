<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Employees extends Migration
{
    public function up()
    {
        $isTable = [
            'id' => [
                'type' => 'INT',
                'constraint' => 32,
                'auto_increment' => true,
            ],
            'employee_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'departement' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];
        $this->forge->addField($isTable);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('employees', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('employees');
    }
}
