<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lampiran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pengaduan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
