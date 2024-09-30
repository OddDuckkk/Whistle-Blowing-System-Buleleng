<?php

namespace App\Models;

use CodeIgniter\Model;

class PihakTerlibatModel extends Model
{
    protected $table            = 'pihak_terlibat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['pengaduan_id', 'nama_terlapor', 'jabatan_terlapor', 'unit_kerja'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findByPengaduanId($pengaduanId) {
        return $this->where('pengaduan_id', $pengaduanId)->findAll();
    }

    public function deleteByPengaduanId($pengaduanId) {
        return $this->where('pengaduan_id', $pengaduanId)->delete();
    }
}
