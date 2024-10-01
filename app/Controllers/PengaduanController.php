<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PengaduanModel;
use App\Models\LampiranModel;
use App\Models\PihakTerlibatModel;

/** PENGADUAN CONTROLLER
 * Menangani berbagai fungsi terkait pengaduan 

    * FUNGSI GET ALL
    * Mencari dan mengembalikan semua pengaduan yang ada
    * Menuju View Index Pengaduan 

    * FUNGSI GET BY USER ID
    * Mencari dan mengembalikan semua pengaduan yang memiliki user id yang diberikan
    * Menuju View Index Pengaduan 

    * FUNGSI GET BY ID
    * Mencari dan mengembalikan semua pengaduan yang memiliki id yang diberikan
    * Menuju View Index Pengaduan 

    * FUNGSI VIEW DETAILS
    * Mencari data detil dari pengaduan berdasarkan id dan mengembalikannya
    * Menuju View Details Pengaduan 

    * FUNGSI VIEW CREATE
    * Meneruskan user ke view formulir membuat pengaduan 

    * FUNGSI STORE
    * Menyimpan data pengaduan yang dikirim oleh user kedalam database 

    * FUNGSI VIEW EDIT
     * Mengambil data pengaduan dan meneruskan user ke view edit pengaduan 

    * FUNGSI UPDATE
    * Menyimpan data pengaduan yang di perbaharui oleh user kedalam database 

    * FUNGSI DELETE
    * Menghapus data pengaduan berdasarkan id pengaduan 
*/

class PengaduanController extends BaseController {

    public function getAll() {
        /** Mengambil semua data pengaduan */
        $data['pengaduan'] = $this->pengaduanModel->findAll();
        /** Kirim data ke view index pengaduan */
        return view('menu/pengaduan/IndexPengaduan', $data);
    }

    public function getByUserId($userId) {
        // Mengambil semua data pengaduan berdasarkan user_id
        $data['pengaduan'] = $this->pengaduanModel->findByUserId($userId);
        // Tampilkan data pengaduan
        return view('menu/pengaduan/IndexPengaduan', $data);
    }

    public function getById($id) {
        /** Mengambil semua data pengaduan berdasarkan id pengaduan */
        $data['pengaduan'] = $this->pengaduanModel->find($id);
        /** Tampilkan data pengaduan */
        return $data;
    }

    public function viewDetails($id) {
        // Mencari data pengaduan, data pihak terlibat, dan data lampiran berdasarkan id pengaduan
        $data['pengaduan'] = $this->pengaduanModel->find($id);
        if ($data['pengaduan']) {
            $data['pihak_terlibat'] = $this->pihakTerlibatModel->findByPengaduanId($id);
            $data['lampiran'] = $this->lampiranModel->findByPengaduanId($id);
        } else {
            // TO DO: HANDLE JIKA DATA DETAIL TIDAK DITEMUKAN
        }
        // Kirim data ke view details pengaduan
        return view('menu/pengaduan/DetailsPengaduan', $data);
    }

    public function viewCreate() {
        return view('menu/pengaduan/CreatePengaduan');
    }

    public function store() {
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

        /** Generate nomor pengaduan */
        $newNumber = $this->generateNomorPengaduan();

        /** Proses simpan data pengaduan */
        $data = [
            'judul' => $this->request->getPost('judul'),
            'tanggal' => $this->request->getPost('tanggal'),
            'tempat' => $this->request->getPost('tempat'),
            'nominal' => $this->request->getPost('nominal'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => 'diproses operator',
            'nomor_pengaduan' => $newNumber,
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Simpan data pengaduan ke model
        $pengaduanId = $this->pengaduanModel->insert($data);

        /** Proses simpan data pihak terlibat */
        $this->savePihakTerlibat($pengaduanId);

        /** Proses simpan data lampiran */
        $this->saveLampiran($pengaduanId);

        return redirect()->to('/pengaduan')->with('message', 'Pengaduan berhasil ditambahkan!');
    }

    protected function generateNomorPengaduan()
    {
        $lastPengaduan = $this->pengaduanModel->orderBy('id', 'DESC')->first();
        $lastId = $lastPengaduan ? intval(substr($lastPengaduan['nomor_pengaduan'], 3)) : 0;
        return 'WBS' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    }

    protected function savePihakTerlibat($pengaduanId)
    {
        $nama_terlapor = $this->request->getPost('nama_terlapor');
        $jabatan_terlapor = $this->request->getPost('jabatan_terlapor');
        $unit_kerja = $this->request->getPost('unit_kerja');

        for ($i = 0; $i < count($nama_terlapor); $i++) {
            $this->pihakTerlibatModel->insert([
                'pengaduan_id' => $pengaduanId,
                'nama_terlapor' => $nama_terlapor[$i],
                'jabatan_terlapor' => $jabatan_terlapor[$i],
                'unit_kerja' => $unit_kerja[$i],
            ]);
        }
    }

    protected function saveLampiran($pengaduanId)
    {
        $fileLampiran = $this->request->getFileMultiple('file_lampiran');
        $deskripsiLampiran = $this->request->getPost('deskripsi_lampiran');

        for ($i = 0; $i < count($fileLampiran); $i++) {
            if ($fileLampiran[$i]->isValid() && !$fileLampiran[$i]->hasMoved()) {
                $fileName = $fileLampiran[$i]->getRandomName();
                $fileLampiran[$i]->move('uploads', $fileName);

                $this->lampiranModel->insert([
                    'pengaduan_id' => $pengaduanId,
                    'file_lampiran' => 'uploads/' . $fileName,
                    'deskripsi' => $deskripsiLampiran[$i],
                ]);
            }
        }
    }

    public function viewEdit($id) {
        // Mengambil data pengaduan 
        $data['pengaduan'] = $this->pengaduanModel->find($id);
        $data['pihak_terlibat'] = $this->pihakTerlibatModel->findByPengaduanId($id);
        $data['lampiran'] = $this->lampiranModel->findByPengaduanId($id);
        // Mengembalikan data ke view edit 
        return view('menu/pengaduan/EditPengaduan', $data);
    }

    public function update($id)
    {
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

        // Update data pengaduan
        $this->pengaduanModel->update($id, $data);

        // Hapus pihak terlibat lama
        $this->pihakTerlibatModel->where('pengaduan_id', $id)->delete();
        /** Update data pihak terlibat */
        $this->savePihakTerlibat($id);
        // Hapus lampiran lama
        $this->lampiranModel->where('pengaduan_id', $id)->delete();
        /** Update data lampiran  */
        $this->saveLampiran($id);

        return redirect()->to('/pengaduan')->with('message', 'Pengaduan berhasil diperbarui!');
    }

    public function delete($id) {
        // Temukan pengaduan berdasarkan ID
        $pengaduan = $this->pengaduanModel->find($id);
        if ($pengaduan) {
            // Hapus pihak terlibat yang terkait dengan pengaduan
            $this->pihakTerlibatModel->deleteByPengaduanId($id);
            // Hapus lampiran terkait pengaduan
            $lampiran = $this->lampiranModel->findByPengaduanId($id);
            foreach ($lampiran as $lmp) {
                // Hapus file lampiran dari folder (opsional, jika ada file yang di-upload)
                if (file_exists($lmp['file_lampiran'])) {
                    unlink($lmp['file_lampiran']);
                }
            }
            $this->lampiranModel->deleteByPengaduanId($id);
            // Hapus pengaduan
            $this->pengaduanModel->delete($id);
            return redirect()->to('/pengaduan')->with('message', 'Pengaduan berhasil dihapus!');
        } else {
            return redirect()->to('/pengaduan')->with('error', 'Pengaduan tidak ditemukan!');
        }
    }
}
