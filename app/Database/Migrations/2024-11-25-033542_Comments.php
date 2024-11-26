<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Comments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'pengaduan_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'comment' => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'new_status' => [
                'type'       => 'ENUM',
                'constraint' => ['baru', 'dikirim', 'diproses operator', 'diproses verifikator', 'selesai', 'ditolak', 'dikembalikan'],
                'null'       => false,
            ],
            'created_by' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true); 
        $this->forge->addForeignKey('pengaduan_id', 'pengaduan', 'id', 'CASCADE', 'CASCADE'); 
        $this->forge->createTable('comments');
    }

    public function down()
    {
        $this->forge->dropTable('comments');
    }
}
