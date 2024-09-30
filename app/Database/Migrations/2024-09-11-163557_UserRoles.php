<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        // Add foreign keys
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('user_roles');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('user_roles');
    }
}
