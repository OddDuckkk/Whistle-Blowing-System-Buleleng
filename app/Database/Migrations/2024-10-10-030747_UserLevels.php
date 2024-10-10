<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserLevels extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'level' => [
                'type'       => 'ENUM',
                'constraint' => ['operator', 'verifikator', 'superadmin'],
                'null'       => false,
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

        // Define a composite key (user_id + level) to ensure unique user and role combinations
        $this->forge->addKey(['user_id', 'level'], true);

        // Create the table
        $this->forge->createTable('user_levels');
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('user_levels');
    }
}
