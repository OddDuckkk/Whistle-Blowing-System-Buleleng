<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lampiran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'CHAR',
                'constraint'     => 36,
                'null'       => false,
            ],
            'pengaduan_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'file_lampiran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        // Primary key
        $this->forge->addKey('id', true);

        // Foreign key
        $this->forge->addForeignKey('pengaduan_id', 'pengaduan', 'id', 'CASCADE', 'CASCADE');

        // Create table
        $this->forge->createTable('lampiran');
    }

    public function down()
    {
        $this->forge->dropTable('lampiran');
    }
}
