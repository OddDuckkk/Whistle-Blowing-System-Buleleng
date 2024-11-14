<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class PengaduanModel extends Model
{
    protected $table            = 'pengaduan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul', 'tanggal', 'tempat', 'nominal', 'deskripsi', 'nomor_pengaduan', 'user_id', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
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
    protected $beforeInsert   = ['generateUUID'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    const STATUS_BARU = 'baru';
    const STATUS_DIKIRIM = 'dikirim';
    const STATUS_DIPROSES_OPERATOR = 'diproses operator';
    const STATUS_DIPROSES_VERIFIKATOR = 'diproses verifikator';
    const STATUS_DIKEMBALIKAN = 'dikembalikan';
    const STATUS_DITOLAK = 'ditolak';
    const STATUS_SELESAI = 'selesai';

    public static $pelaporActiveStatuses = [
        self::STATUS_BARU,
        self::STATUS_DIKIRIM,
        self::STATUS_DIPROSES_OPERATOR,
        self::STATUS_DIPROSES_VERIFIKATOR,
        self::STATUS_DIKEMBALIKAN,
    ];
    public static $pelaporInactiveStatuses = [
        self::STATUS_DITOLAK,
        self::STATUS_SELESAI
    ];
    public static $operatorActiveStatuses = [
        self::STATUS_DIKIRIM,
        self::STATUS_DIPROSES_OPERATOR,
        self::STATUS_DIKEMBALIKAN,
    ];
    public static $operatorInactiveStatuses = [
        self::STATUS_DITOLAK,
        self::STATUS_SELESAI
    ];
    public static $verifikatorActiveStatuses = [
        self::STATUS_DIPROSES_VERIFIKATOR
    ];
    public static $verifikatorInactiveStatuses = [
        self::STATUS_DITOLAK,
        self::STATUS_SELESAI
    ];
    public static $peninjauInactiveStatuses = [
        self::STATUS_DITOLAK,
        self::STATUS_SELESAI
    ];


    protected function generateUUID(array $data)
    {
        $data['data']['id'] = Uuid::uuid4()->toString(); // Menghasilkan UUID versi 4
        return $data;
    }

    public function generateNomorPengaduan() {
        // Mulai transaksi untuk mengunci tabel
        $this->db->transStart();
    
        // Ambil pengaduan terakhir berdasarkan nomor_pengaduan
        $lastPengaduan = $this->db->query("SELECT * FROM {$this->table} ORDER BY nomor_pengaduan DESC FOR UPDATE")->getRowArray();
    
        // Buat nomor baru
        $lastId = $lastPengaduan ? intval(substr($lastPengaduan['nomor_pengaduan'], 3)) : 0;
        $newNomor = 'WBS' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    
        // Selesaikan transaksi untuk membuka kunci tabel
        $this->db->transComplete();
    
        return $newNomor;
    }

    public function findByUserId($userId) {
        return $this->where('user_id', $userId);
    }

    public function filterByStatus($statuses) {
        return $this->whereIn('status', $statuses);
    }
}
