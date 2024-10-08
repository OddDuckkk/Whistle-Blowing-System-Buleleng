<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PihakTerlibat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'CHAR',
                'constraint'     => 36,
            ],
            'pengaduan_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
            ],
            'nama_terlapor' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'jabatan_terlapor' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'unit_kerja' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Foreign key
        $this->forge->addForeignKey('pengaduan_id', 'pengaduan', 'id', 'CASCADE', 'CASCADE');

        // Create table
        $this->forge->createTable('pihak_terlibat');
    }

    public function down()
    {
        $this->forge->dropTable('pihak_terlibat');
    }
}
