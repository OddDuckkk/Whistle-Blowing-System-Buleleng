<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PengaduanModel;
use App\Models\LampiranModel;
use App\Models\PihakTerlibatModel;

/** CLASS PENGADUAN CONTROLLER
 * Menangani berbagai fungsi terkait pengaduan
 * -Fungsi __construct
 * -Fungsi viewAll
 * -Fungsi viewDetails
 * -Fungsi viewCreate
 * -Fungsi store
 * -Fungsi viewEdit
 * -Fungsi update
 * -Fungsi delete
 */
class PengaduanController extends BaseController
{

    protected $pengaduanModel;

    /** FUNGSI CONSTRUCT
     * Mendeklarasikan konstruksi model pengaduan */
    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
    }

    /** FUNGSI VIEW ALL
     * Mencari dan mengembalikan semua pengaduan yang ada
     * Menuju View Index Pengaduan */
    public function viewAll()
    {
        /** Mengambil semua data pengaduan */
        $data['pengaduan'] = $this->pengaduanModel->findAll();

        /** Kirim data ke view index pengaduan */
        return view('menu/pengaduan/IndexPengaduan', $data);
    }

    public function getByUserId($userId)
    {
        $pengaduanModel = new PengaduanModel();
        
        // Mengambil semua data pengaduan berdasarkan user_id
        $data['pengaduan'] = $pengaduanModel->where('user_id', $userId)->findAll();

        // Tampilkan data pengaduan atau kirimkan ke view
        return view('menu/pengaduan/IndexPengaduan', $data);
    }

    public function findById($id)
    {
        /** Inisialisasi model */
        $pengaduanModel = new PengaduanModel();

        /** Mencari data pengaduan berdasarkan id */
        $data['pengaduan'] = $pengaduanModel->find($id);

        /** Mengembalikan data */
        return $data;
    }

    /** FUNGSI VIEW DETAILS
     * Mencari data detil dari pengaduan berdasarkan id dan mengembalikannya
     * Menuju View Details Pengaduan */
    public function viewDetails($id)
    {
        /** Inisialisasi model */
        $pengaduanModel = new PengaduanModel();
        $pihakTerlibatModel = new PihakTerlibatModel();
        $lampiranModel = new LampiranModel();

        /** Mencari data pengaduan, data pihak terlibat, data lampiran berdasarkan id pengaduan */
        $data['pengaduan'] = $pengaduanModel->find($id);
        $data['pihak_terlibat'] = $pihakTerlibatModel->where('pengaduan_id', $id)->findAll();
        $data['lampiran'] = $lampiranModel->where('pengaduan_id', $id)->findAll();
        
        /** Kirim data ke view details pengaduan */
        return view('menu/pengaduan/DetailsPengaduan', $data);
    }

    /** FUNGSI VIEW CREATE
     * Meneruskan user ke view formulir membuat pengaduan */
    public function viewCreate()
    {
        return view('menu/pengaduan/CreatePengaduan');
    }

    /** FUNGSI STORE
     * Menyimpan data pengaduan yang dikirim oleh user kedalam database */
    public function store()
    {
        /** Inisialisasi model */
        $pengaduanModel = new PengaduanModel();
        $pihakTerlibatModel = new PihakTerlibatModel();
        $lampiranModel = new LampiranModel();
        
        /** ID User Statis UNTUK TESTING HAPUS NANTI */
        $userId = 1; // Ganti sesuai dengan user ID yang digunakan

        /** Validasi data yang diinput dari form-CreatePengaduan */
        $validated = $this->validate([
            'judul' => 'required',
            'tanggal' => 'required|valid_date',
            'tempat' => 'required',
            'deskripsi' => 'required',
            'file_lampiran' => [
                'uploaded[file_lampiran]',
                'mime_in[file_lampiran,image/jpg,image/jpeg,image/png,application/pdf]',
                'max_size[file_lampiran,10240]', // Maksimal 10MB
                ],
            'nama_terlapor' => 'required',
            'jabatan_terlapor' => 'required',
            'unit_kerja' => 'required',
        ]);

        /** Generate nomor pengaduan
         * Nomor pengaduan unik untuk setiap pengaduan
         * Format penomoran adalah 'WBS' diikuti dengan 5 digit angka, dimulai dari 1
         * contoh WBS00001
         */
        $lastPengaduan = $pengaduanModel->orderBy('id', 'DESC')->first(); // Mencari data pengaduan paling terakhir
        if ($lastPengaduan == null) { // Logic apabila belum ada data sama sekali / tidak ada data pengaduan paling terakhir
            $lastId = '0';
        }
        else {
            $lastId = $lastPengaduan ? intval(substr($lastPengaduan['nomor_pengaduan'], 3)) : 0; //Mengambil angka dari nomor pengaduan terakhir
        }
        $newNumber = 'WBS' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT); //Menambahkan nomor pengaduan terakhir dengan 1 dan memberi padding angka 0 5 digit
    
        /** Proses simpan data pengaduan
         * Menyimpan data judul, tanggal, tempat, nominal, deskripsi, status, dan nomor_pengaduan ke tabel pengaduan
         */
        $data = [
            'judul'      => $this->request->getPost('judul'), //Mengambil data Post dari form
            'tanggal'    => $this->request->getPost('tanggal'),
            'tempat'     => $this->request->getPost('tempat'),
            'nominal'    => $this->request->getPost('nominal'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status' => 'diproses operator', // Status default 
            'nomor_pengaduan' => $newNumber, // Nomor laporan yang baru di-generate
            'user_id'       => $userId, // Menyimpan ID user
            'created_at'    => date('Y-m-d H:i:s'), // Waktu pembuatan
            'updated_at'    => date('Y-m-d H:i:s'), // Waktu update
        ];
        $pengaduanModel->insert($data);

        /** Mengambil data id pengaduan sebagai foreign key pada tabel pihakterlibat & lampiran */
        $pengaduanId = $pengaduanModel->insertID();

        /** Proses simpan data pihak terlibat
         * Menyimpan data pengaduan_id, nama_terlapor, jabatan_terlapor, unit_kerja ke tabel pihak terlibat
         */
        $nama_terlapor = $this->request->getPost('nama_terlapor');
        $jabatan_terlapor = $this->request->getPost('jabatan_terlapor');
        $unit_kerja = $this->request->getPost('unit_kerja');

        //Loop untuk multiple input pihak terlibat
        for ($i = 0; $i < count($nama_terlapor); $i++) {
            $pihakTerlibatModel->insert([
                'pengaduan_id' => $pengaduanId,
                'nama_terlapor' => $nama_terlapor[$i],
                'jabatan_terlapor' => $jabatan_terlapor[$i],
                'unit_kerja' => $unit_kerja[$i],
            ]);
        }
        
        /** Proses simpan data lampiran
         * Menyimpan data pengaduan_id, file_lampiran, deskripsi ke tabel lampiran */
        $fileLampiran = $this->request->getFileMultiple('file_lampiran');
        $deskripsiLampiran = $this->request->getPost('deskripsi_lampiran');

        // Loop upload file lampiran ke public/uploads dan ke database untuk multiple lampiran
        for ($i = 0; $i < count($fileLampiran); $i++) {
            if ($fileLampiran[$i]->isValid() && !$fileLampiran[$i]->hasMoved()) {
                $fileName = $fileLampiran[$i]->getRandomName();
                $fileLampiran[$i]->move('uploads', $fileName);

                $lampiranModel->insert([
                    'pengaduan_id' => $pengaduanId,
                    'file_lampiran' => 'uploads/' . $fileName,
                    'deskripsi' => $deskripsiLampiran[$i],
                ]);
            }
        }

        /** End of function */
        return redirect()->to('/pengaduan')->with('message', 'Pengaduan berhasil ditambahkan!');
    }

    public function viewEdit($id)
    {
        $pengaduanModel = new PengaduanModel();
        $pihakTerlibatModel = new PihakTerlibatModel();
        $lampiranModel = new LampiranModel();

        $data['pengaduan'] = $pengaduanModel->find($id);
        $data['pihak_terlibat'] = $pihakTerlibatModel->where('pengaduan_id', $id)->findAll();
        $data['lampiran'] = $lampiranModel->where('pengaduan_id', $id)->findAll();

        return view('menu/pengaduan/EditPengaduan', $data);
    }

    public function update($id)
    {
        $pengaduanModel = new PengaduanModel();
        $pihakTerlibatModel = new PihakTerlibatModel();
        $lampiranModel = new LampiranModel();

        // Validasi input
        $validated = $this->validate([
            'judul' => 'required',
            'tanggal' => 'required|valid_date',
            'tempat' => 'required',
            'deskripsi' => 'required',
            'file_lampiran' => [
                'mime_in[file_lampiran,image/jpg,image/jpeg,image/png,application/pdf]',
                'max_size[file_lampiran,10240]', // Maksimal 10MB
            ],
            'nama_terlapor' => 'required',
            'jabatan_terlapor' => 'required',
            'unit_kerja' => 'required',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses update data pengaduan
        $data = [
            'judul'      => $this->request->getPost('judul'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'tempat'     => $this->request->getPost('tempat'),
            'nominal'    => $this->request->getPost('nominal'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'updated_at' => date('Y-m-d H:i:s'), // Waktu update
        ];

        $pengaduanModel->update($id, $data);

        /** Update data pihak terlibat */
        $nama_terlapor = $this->request->getPost('nama_terlapor');
        $jabatan_terlapor = $this->request->getPost('jabatan_terlapor');
        $unit_kerja = $this->request->getPost('unit_kerja');

        // Hapus pihak terlibat lama
        $pihakTerlibatModel->where('pengaduan_id', $id)->delete();

        // Masukkan data pihak terlibat baru
        for ($i = 0; $i < count($nama_terlapor); $i++) {
            $pihakTerlibatModel->insert([
                'pengaduan_id'   => $id,
                'nama_terlapor'  => $nama_terlapor[$i],
                'jabatan_terlapor' => $jabatan_terlapor[$i],
                'unit_kerja'     => $unit_kerja[$i],
            ]);
        }

        /** Update data lampiran */
        $fileLampiran = $this->request->getFileMultiple('file_lampiran');
        $deskripsiLampiran = $this->request->getPost('deskripsi_lampiran');

        if ($fileLampiran) {
            // Hapus lampiran lama
            $lampiranModel->where('pengaduan_id', $id)->delete();

            // Upload file baru dan simpan ke database
            for ($i = 0; $i < count($fileLampiran); $i++) {
                if ($fileLampiran[$i]->isValid() && !$fileLampiran[$i]->hasMoved()) {
                    $fileName = $fileLampiran[$i]->getRandomName();
                    $fileLampiran[$i]->move('uploads', $fileName);

                    $lampiranModel->insert([
                        'pengaduan_id' => $id,
                        'file_lampiran' => 'uploads/' . $fileName,
                        'deskripsi' => $deskripsiLampiran[$i],
                    ]);
                }
            }
        }
        return redirect()->to('/pengaduan')->with('message', 'Pengaduan berhasil diperbarui!');
    }

    public function delete($id)
    {
    $pengaduanModel = new PengaduanModel();
    $pihakTerlibatModel = new PihakTerlibatModel();
    $lampiranModel = new LampiranModel();

    // Temukan pengaduan berdasarkan ID
    $pengaduan = $pengaduanModel->find($id);

    if ($pengaduan) {
        // Hapus pihak terlibat yang terkait dengan pengaduan
        $pihakTerlibatModel->where('pengaduan_id', $id)->delete();
        
        // Hapus lampiran terkait pengaduan
        $lampiran = $lampiranModel->where('pengaduan_id', $id)->findAll();
        foreach ($lampiran as $lmp) {
            // Hapus file lampiran dari folder (opsional, jika ada file yang di-upload)
            if (file_exists($lmp['file_lampiran'])) {
                unlink($lmp['file_lampiran']);
            }
        }
        $lampiranModel->where('pengaduan_id', $id)->delete();

        // Hapus pengaduan
        $pengaduanModel->delete($id);

        return redirect()->to('/pengaduan')->with('message', 'Pengaduan berhasil dihapus!');
    } else {
        return redirect()->to('/pengaduan')->with('error', 'Pengaduan tidak ditemukan!');
    }
    }
}
