<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengaduan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 36, 
                'null'       => false,
            ],
             'user_id' => [ 
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'nomor_pengaduan' => [
                'type'       => 'VARCHAR',
                'constraint' => 10, 
                'null'       => false,
                'unique'     => true, // Nomor laporan harus unik
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'tempat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'nominal' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['diproses operator', 'diproses verifikator', 'selesai', 'ditolak operator', 'ditolak verifikator'],
                'default'    => 'diproses operator',
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

        // Primary key
        $this->forge->addKey('id', true);

        // Create table
        $this->forge->createTable('pengaduan');
    }

    public function down()
    {
        // Drop the foreign key first
        $this->forge->dropForeignKey('pengaduan', 'pengaduan_user_id_foreign');

        $this->forge->dropTable('pengaduan');
    }
}
