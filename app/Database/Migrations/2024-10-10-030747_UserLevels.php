<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserLevels extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nip' => [
                'type'       => 'CHAR',
                'constraint' => 18, 
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

        // 
        $this->forge->addKey('nip', true);

        // Create the table
        $this->forge->createTable('user_levels');
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('user_levels');
    }
}
