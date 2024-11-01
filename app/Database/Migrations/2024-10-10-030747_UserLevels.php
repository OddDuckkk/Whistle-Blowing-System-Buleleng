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
            'nama_pegawai' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'jabatan_pegawai' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'unit_kerja' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'level' => [
                'type'       => 'ENUM',
                'constraint' => ['operator', 'verifikator', 'peninjau', 'superadmin'],
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
