<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PengaduanModel;
use App\Models\LampiranModel;
use App\Models\PihakTerlibatModel;

/** PENGADUAN CONTROLLER
 * Menangani berbagai fungsi terkait pengaduan 

    * ====TIDAK DIGUNAKAN====
    * FUNGSI GET ALL
    * Mencari dan mengembalikan semua pengaduan yang ada
    * Menuju View Index Pengaduan 

    * ====TIDAK DIGUNAKAN====
    * FUNGSI GET BY USER ID
    * Mencari dan mengembalikan semua pengaduan yang memiliki user id yang diberikan
    * Menuju View Index Pengaduan 

    * FUNGSI GET PELAPOR ACTIVE PENGADUAN
    * Mencari dan mengembalikan data pengaduan berdasarkan aturan khusus berikut: 
    * user_id pengaduan == id pengguna (session -> id_user)
    * status == baru / dikirim / diproses operator / diproses verifikator / dikembalikan
    * Menuju View Index Pengaduan
    
    * FUNGSI GET PELAPOR INACTIVE PENGADUAN
    * Mencari dan mengembalikan data pengaduan berdasarkan aturan khusus berikut: 
    * user_id pengaduan == id pengguna (session -> id_user)
    * status == ditolak / selesai
    * Menuju View Index Pengaduan

    * FUNGSI GET OPERATOR ACTIVE PENGADUAN
    * Mencari dan mengembalikan data pengaduan berdasarkan aturan khusus berikut: 
    * status == dikirim / diproses operator / dikembalikan
    * Menuju View Index Pengaduan

    * FUNGSI GET OPERATOR INACTIVE PENGADUAN
    * Mencari dan mengembalikan data pengaduan berdasarkan aturan khusus berikut: 
    * status == ditolak / selesai
    * Menuju View Index Pengaduan

    * FUNGSI GET VERIFIKATOR ACTIVE PENGADUAN
    * Mencari dan mengembalikan data pengaduan berdasarkan aturan khusus berikut: 
    * status == diproses verifikator
    * Menuju View Index Pengaduan

    * FUNGSI GET VERIFIKATOR INACTIVE PENGADUAN
    * Mencari dan mengembalikan data pengaduan berdasarkan aturan khusus berikut: 
    * status == ditolak / selesai
    * Menuju View Index Pengaduan

    * FUNGSI VIEW DETAILS
    * Mencari data detil dari pengaduan berdasarkan id dan mengembalikannya
    * Menuju View Details Pengaduan 

    * FUNGSI VIEW CREATE
    * Meneruskan user ke view formulir membuat pengaduan 

    * FUNGSI VIEW STATISTICS
    * Mengambil data statistik pengaduan
    * Menuju View Statistik Pengaduan

    * FUNGSI STORE
    * Menyimpan data pengaduan yang dikirim oleh user kedalam database 

    * FUNGSI VIEW EDIT
     * Mengambil data pengaduan dan meneruskan user ke view edit pengaduan 

    * FUNGSI UPDATE
    * Menyimpan data pengaduan yang di perbaharui oleh user kedalam database 

    * FUNGSI DELETE
    * Menghapus data pengaduan berdasarkan id pengaduan 

    * FUNGSI GENERATE NOMOR PENGADUAN
    * Membuat nomor pengaduan baru menggunakan format WBS00000

    * FUNGSI SAVE PIHAK TERLIBAT
    * Menyimpan data pihak terlibat yang diunggah oleh user kedalam database

    * FUNGSI SAVE LAMPIRAN
    * Menyimpan data lampiran yang diunggah oleh user kedalam database

    * FUNGSI UPLOAD FILE
    * Menyimpan file lampiran ke server pada directory public/uploads

    * FUNGSI DELETE FILE
    * Menghapus file lampiran dari server pada directory public/uploads

    * FUNGSI EXTRACT ARRAY ERRORS
    * Fungsi bantuan untuk mengekstrak array

    * FUNGSI VALIDASI PENGADUAN
    * Memvalidasi data pengaduan + pihak terlibat + lampiran yang dikirimkan melalui form
    * Validasi menggunakan Code igniter validation dan custom validation
    * Mengembalikan pesan error ke view apabila validasi gagal

    * FUNGSI CHANGE STATUS
    * Mengganti status pada pengaduan
    * Input = pengaduan id, status baru
    * proses = mengganti status pengaduan menjadi status yang baru
    * output = -
*/

class PengaduanController extends BaseController {

    public function getAll() {
        // Mengambil semua data pengaduan 
        $data['pengaduan'] = $this->pengaduanModel->findAll();
        // Kirim data ke view index pengaduan
        return view('menu/pengaduan/index_pengaduan', $data);
    }

    public function getByUserId($userId) {
        // Mengambil semua data pengaduan berdasarkan user_id
        return $this->pengaduanModel->findByUserId($userId);
    }

    public function getPelaporActivePengaduan($userId) {
        // Mengambil data status
        $statuses = PengaduanModel::$pelaporActiveStatuses;

        // Query data pengaduan
        $data['pengaduan'] = $this->pengaduanModel
                                  ->findByUserId($userId)
                                  ->filterByStatus($statuses)
                                  ->orderBy('nomor_pengaduan', 'DESC')
                                  ->findAll();
        
        $data['bookmarkedIds'] = $this->bookmarkModel->getUserBookmarks($userId) ?? [];

        return view('menu/pengaduan/index_pengaduan', $data);
    }

    public function getPelaporInactivePengaduan($userId) {
        // Mengambil data status
        $statuses = PengaduanModel::$pelaporInactiveStatuses;

        // Query data pengaduan
        $data['pengaduan'] = $this->pengaduanModel
                                  ->findByUserId($userId)
                                  ->filterByStatus($statuses)
                                  ->orderBy('nomor_pengaduan', 'DESC')
                                  ->findAll();

        $data['bookmarkedIds'] = $this->bookmarkModel->getUserBookmarks($userId) ?? [];

        return view('menu/pengaduan/index_pengaduan', $data);
    }
    public function getOperatorActivePengaduan() {
        // Mengambil data status
        $statuses = PengaduanModel::$operatorActiveStatuses;

        // Query data pengaduan
        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->orderBy('nomor_pengaduan', 'DESC')
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }
    public function getOperatorInactivePengaduan() {
        // Mengambil data status
        $statuses = PengaduanModel::$operatorInactiveStatuses;

        // Query data pengaduan
        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->orderBy('nomor_pengaduan', 'DESC')
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }

    public function getVerifikatorActivePengaduan() {
        // Mengambil data status
        $statuses = PengaduanModel::$verifikatorActiveStatuses;

        // Query data pengaduan
        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->orderBy('nomor_pengaduan', 'DESC')
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }
    public function getVerifikatorInactivePengaduan() {
        // Mengambil data status
        $statuses = PengaduanModel::$verifikatorInactiveStatuses;

        // Query data pengaduan
        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->orderBy('nomor_pengaduan', 'DESC')
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }

    public function getPeninjauInactivePengaduan() {
        // Mengambil data status
        $statuses = PengaduanModel::$peninjauInactiveStatuses;

        // Query data pengaduan
        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->orderBy('nomor_pengaduan', 'DESC')
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }

    public function viewDetails($id) {
        // Mencari data pengaduan, data pihak terlibat, dan data lampiran berdasarkan id pengaduan
        $data['pengaduan'] = $this->pengaduanModel->find($id);
        if ($data['pengaduan']) {
            $data['pihak_terlibat'] = $this->pihakTerlibatModel->findByPengaduanId($id);
            $data['lampiran'] = $this->lampiranModel->findByPengaduanId($id);
            $data['comment'] = $this->commentModel->findByPengaduanId($id);
        } else {
            return redirect()->to('/not-found');
        }
        // Kirim data ke view details pengaduan
        return view('menu/pengaduan/details_pengaduan', $data);
    }

    public function viewCreate() {
        // Tampilkan data create pengaduan
        return view('menu/pengaduan/create_pengaduan');
    }

    public function viewStatistics() {
        // Query data pengaduan
        $totalPengaduan = $this->pengaduanModel->where('status !=', 'baru')
                                             ->where('status !=', 'dikembalikan')
                                             ->countAllResults();
    
        //Hitung jumlah pengaduan                                     
        $completedPengaduan = $this->pengaduanModel->where('status', 'selesai')->countAllResults();
        $rejectedPengaduan = $this->pengaduanModel->where('status', 'ditolak')->countAllResults();
        $inProgressPengaduan = $this->pengaduanModel->whereIn('status', ['dikirim', 'diproses operator', 'diproses verifikator'])
                                                  ->countAllResults();
    
        // Kalkulasi persentase
        $completedPercentage = $totalPengaduan > 0 ? ($completedPengaduan / $totalPengaduan) * 100 : 0;
        $rejectedPercentage = $totalPengaduan > 0 ? ($rejectedPengaduan / $totalPengaduan) * 100 : 0;
        $inProgressPercentage = $totalPengaduan > 0 ? ($inProgressPengaduan / $totalPengaduan) * 100 : 0;
    
        // Hitung jumlah pengaduan per waktu
        $pengaduanToday = $this->pengaduanModel->where('DATE(created_at)', date('Y-m-d'))
                                                ->where('status !=', 'baru')
                                                ->where('status !=', 'dikembalikan')
                                                ->countAllResults();
        $pengaduanThisMonth = $this->pengaduanModel->where('MONTH(created_at)', date('m'))
                                                  ->where('YEAR(created_at)', date('Y'))
                                                  ->where('status !=', 'baru')
                                                ->where('status !=', 'dikembalikan')
                                                ->countAllResults();
        $pengaduanThisYear = $this->pengaduanModel->where('YEAR(created_at)', date('Y'))
                                                ->where('status !=', 'baru')
                                                ->where('status !=', 'dikembalikan')
                                                ->countAllResults();
    
        // Hitung jumlah pengaduan tiap bulannya
        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[$month] = $this->pengaduanModel->where('MONTH(created_at)', $month)
                                                        ->where('YEAR(created_at)', date('Y'))
                                                        ->where('status !=', 'baru')
                                                        ->where('status !=', 'dikembalikan')
                                                        ->countAllResults();
        }
    
        // siapkan data untuk view
        $data = [
            'totalPengaduan' => $totalPengaduan,
            'completedPengaduan' => $completedPengaduan,
            'rejectedPengaduan' => $rejectedPengaduan,
            'inProgressPengaduan' => $inProgressPengaduan,
            'completedPercentage' => $completedPercentage,
            'rejectedPercentage' => $rejectedPercentage,
            'inProgressPercentage' => $inProgressPercentage,
            'pengaduanToday' => $pengaduanToday,
            'pengaduanThisMonth' => $pengaduanThisMonth,
            'pengaduanThisYear' => $pengaduanThisYear,
            'monthlyData' => $monthlyData, // Pass monthly data to the view
        ];
    
        return view('menu/pengaduan/statistik_pengaduan', $data);
    }    

    public function store() {
        // ID User diambil dari session 
        $userId = $this->session->get('id_user'); 

        // Validasi data yang diinput dari form-CreatePengaduan 
        // Menggunakan fungsi validatePengaduan
        if (!$this->validatePengaduan()) {
            $sessError = [
                'errJudul' => $this->validation->getError('judul'),
                'errTanggal' => $this->validation->getError('tanggal'),
                'errNominal' => $this->validation->getError('nominal'),
                'errTempat' => $this->validation->getError('tempat'),
                'errDeskripsi' => $this->validation->getError('deskripsi'),
                'errNipTerlapor' => $this->extractArrayErrors($this->validation->getErrors(), 'nip_terlapor'),
                'errNamaTerlapor' => $this->extractArrayErrors($this->validation->getErrors(), 'nama_terlapor'),
                'errJabatanTerlapor' => $this->extractArrayErrors($this->validation->getErrors(), 'jabatan_terlapor'),
                'errUnitKerja' => $this->extractArrayErrors($this->validation->getErrors(), 'unit_kerja'),
                'errDeskripsiLampiran' => $this->extractArrayErrors($this->validation->getErrors(), 'deskripsi_lampiran'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(site_url("/pengaduan/create"))->withInput();
        }

        // Generate nomor pengaduan 
        $newNumber = $this->pengaduanModel->generateNomorPengaduan();

        // Proses simpan data pengaduan 
        $data = [
            'judul' => $this->request->getPost('judul'),
            'tanggal' => $this->request->getPost('tanggal'),
            'tempat' => $this->request->getPost('tempat'),
            'nominal' => $this->request->getPost('nominal'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => 'baru',
            'nomor_pengaduan' => $newNumber,
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Simpan data pengaduan ke model
        $pengaduanId = $this->pengaduanModel->insert($data);

        // Proses simpan data pihak terlibat 
        $this->savePihakTerlibat($pengaduanId);

        // Proses simpan data lampiran
        $this->saveLampiran($pengaduanId);

        session()->setFlashdata('info_message', 'Pengaduan berhasil disimpan sebagai draf. Jika sudah final, klik kirim untuk mulai mengajukan pengaduan. Atau klik edit untuk merubah apabila terdapat kesalahan.');
        return redirect()->to("/pengaduan/details/$pengaduanId");
    }

    public function viewEdit($id) {
        // Mengambil data pengaduan 
        $data['pengaduan'] = $this->pengaduanModel->find($id);
        $data['pihak_terlibat'] = $this->pihakTerlibatModel->findByPengaduanId($id);
        $data['lampiran'] = $this->lampiranModel->findByPengaduanId($id);
        // Mengembalikan data ke view edit 
        return view('menu/pengaduan/edit_pengaduan', $data);
    }

    public function update($id) {

        // Validasi data yang diinput dari form-CreatePengaduan 
        // Menggunakan fungsi validatePengaduan
        if (!$this->validatePengaduan()) {
            $sessError = [
                'errJudul' => $this->validation->getError('judul'),
                'errTanggal' => $this->validation->getError('tanggal'),
                'errNominal' => $this->validation->getError('nominal'),
                'errTempat' => $this->validation->getError('tempat'),
                'errDeskripsi' => $this->validation->getError('deskripsi'),
                'errNipTerlapor' => $this->extractArrayErrors($this->validation->getErrors(), 'nip_terlapor'),
                'errNamaTerlapor' => $this->extractArrayErrors($this->validation->getErrors(), 'nama_terlapor'),
                'errJabatanTerlapor' => $this->extractArrayErrors($this->validation->getErrors(), 'jabatan_terlapor'),
                'errUnitKerja' => $this->extractArrayErrors($this->validation->getErrors(), 'unit_kerja'),
                'errDeskripsiLampiran' => $this->extractArrayErrors($this->validation->getErrors(), 'deskripsi_lampiran'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(site_url("/pengaduan/edit/$id"))->withInput();
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
    
        // Simpan data pihak terlibat baru
        $this->savePihakTerlibat($id);

        // Hapus lampiran dari 'uploads' directory
        $oldFiles = $this->lampiranModel->where('pengaduan_id', $id)->findAll();
        foreach ($oldFiles as $file) {
            $filePath = WRITEPATH . 'uploads/' . $file['file_lampiran'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus lampiran dari database
        $this->lampiranModel->where('pengaduan_id', $id)->delete();
    
        // Simpan data lampiran baru
        $this->saveLampiran($id);
    
        session()->setFlashdata('info_message', 'Pengaduan berhasil diperbaharui! Klik kirim untuk untuk mulai mengajukan pengaduan.');
        return redirect()->to("/pengaduan/details/$id");
    }
    

    public function delete($id) {
        // Ambil id user
        $userId = $this->session->get('id_user'); 
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

            session()->setFlashdata('success_message', 'Pengaduan berhasil dihapus!');
            return redirect()->to("/pengaduan/user/$userId");
        } else {
            session()->setFlashdata('failure_message', 'Pengaduan tidak ditemukan!');
            return redirect()->to("/pengaduan/user/$userId");
        }
    }

    protected function savePihakTerlibat($pengaduanId) {
        // Ambil data dari post (array)
        $nipTerlapor = $this->request->getPost('nip_terlapor[]');
        $namaTerlapor = $this->request->getPost('nama_terlapor[]');
        $jabatanTerlapor = $this->request->getPost('jabatan_terlapor[]');
        $unitKerja = $this->request->getPost('unit_kerja[]');

        // Loop untuk setiap inputan pihak terlibat
        for ($i = 0; $i < count($nipTerlapor); $i++) {
            // Proses menyimpan data
            $this->pihakTerlibatModel->insert([
                'pengaduan_id' => $pengaduanId,
                'nip_terlapor' => $nipTerlapor[$i],
                'nama_terlapor' => $namaTerlapor[$i],
                'jabatan_terlapor' => $jabatanTerlapor[$i],
                'unit_kerja' => $unitKerja[$i],
            ]);
        }
    }

    public function uploadFile() {
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['file'];

            // Penamaan file
            $randomString = bin2hex(random_bytes(8)); // random string  
            $fileName = pathinfo($file['name'], PATHINFO_FILENAME);  // nama file asli
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);  // ekstensi file
            $shortFileName = substr($fileName, 0, 40); // ambil 40 karakter pertama dari nama file  
            $randomName = $randomString . '-' . $shortFileName . '.' . $extension; //hasil gabungan nama unik

            // $randomName = bin2hex(random_bytes(8)) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
            $uploadPath = $uploadDirectory . $randomName;
            $urlPath = '/uploads/' . $randomName;
    
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $response = ['filePath' => $urlPath];
                echo json_encode($response);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to move uploaded file.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Upload error']);
        }
    }
    public function deleteFile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (isset($data['filePath'])) {
                
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $data['filePath'];
    
                if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        echo json_encode(['success' => true, 'message' => 'File deleted successfully.']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['success' => false, 'error' => 'Failed to delete the file.']);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'error' => 'File not found.']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid file path.']);
            }
        }
    }
    
    
    protected function saveLampiran($pengaduanId) {
        // ambil data lampiran
        $filePaths = $this->request->getPost('file_lampiran[]');
        $deskripsiLampiran = $this->request->getPost('deskripsi_lampiran[]');

        // loop each file
        for ($i = 0; $i < count($filePaths); $i++) {
            $filePath = $filePaths[$i];
            $description = isset($deskripsiLampiran[$i]) ? $deskripsiLampiran[$i] : '';
            // Simpan ke database
            $this->lampiranModel->insert([
                'pengaduan_id' => $pengaduanId,
                'file_lampiran' => $filePath,
                'deskripsi' => $description,
            ]);
        }
    }

    protected function extractArrayErrors(array $errors, string $fieldName) {
    $fieldErrors = [];
    foreach ($errors as $key => $error) {
        if (preg_match('/' . preg_quote($fieldName) . '\.(\d+)/', $key, $matches)) {
            $index = $matches[1];
            $fieldErrors[$index] = $error; 
        }
    }
    return $fieldErrors;
    }

    private function validatePengaduan() {
        // Validasi file lampiran dilakukan di javaScript (create_pengaduan.js)

        // Fungsi validasi input
        return $this->validate([
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari {param} karakter'
                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required|valid_date|custom_valid_date',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_date' => '{field} harus berupa tanggal yang valid',
                    'custom_valid_date' => '{field} tidak boleh terlalu jauh di masa lalu atau masa depan'
                ]
            ],
            'nominal' => [
                'label' => 'Nominal',
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => '{field} hanya boleh berisi angka',
                ]
            ],
            'tempat' => [
                'label' => 'Tempat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'nip_terlapor.*' => [
                'label' => 'Nip terlapor',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'nama_terlapor.*' => [
                'label' => 'Nama terlapor',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'jabatan_terlapor.*' => [
                'label' => 'Jabatan terlapor',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'unit_kerja.*' => [
                'label' => 'Unit kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'deskripsi_lampiran.*' => [
                'label' => 'Deskripsi lampiran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ]);
    }

    public function changeStatus() {
        // Ambil data dari request body
        $pengaduanId = $this->request->getPost('pengaduan_id'); 
        $newStatus = $this->request->getPost('status');
        $comment = $this->request->getPost('comment');
        $userId = session()->get('id_user'); 

        // simpan komentar jika ada
        if ($comment) {
            $commentData = [
                'pengaduan_id' => $pengaduanId,
                'new_status' => $newStatus,
                'created_by' => $userId,
                'comment' => $comment,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->commentModel->insert($commentData);
        }

        $allowedStatuses = ['baru', 'dikirim', 'diproses operator', 'diproses verifikator', 'selesai', 'ditolak', 'dikembalikan'];

        // cek apakah status valid
        if (!in_array($newStatus, $allowedStatuses)) {
            session()->setFlashdata('failure_message', 'Status yang diberikan tidak valid!');
            return redirect()->back()->withInput();
        }

        $pengaduan = $this->pengaduanModel->find($pengaduanId);

        // Cek apakah pengaduan valid
        if (!$pengaduan) {
            session()->setFlashdata('failure_message', 'Pengaduan tidak ditemukan!');
            return redirect()->back()->withInput();
        } else {
            // proses simpan
            $data = [
                'status' => $newStatus,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            // Handle message 
            if ($newStatus == "dikirim") {
                $message = "Pengaduan berhasil dikirim!";
            } elseif ($newStatus == "diproses operator") {
                $message = null;
            } elseif ($newStatus == "diproses verifikator") {
                $message = "Pengaduan berhasil diteruskan ke verifikator!";
            } elseif ($newStatus == "ditolak") {
                $message = "Pengaduan telah ditolak!";
            } elseif ($newStatus == "dikembalikan") {
                $message = "Pengaduan telah dikembalikan!";
            } elseif ($newStatus == "selesai") {
                $message = "Pengaduan telah diselesaikan!";
            }
            $this->pengaduanModel->update($pengaduanId, $data);
            session()->setFlashdata('success_message', $message);
            if ($newStatus == "diproses operator") {
                return redirect()->to(site_url("/pengaduan/details/$pengaduanId"));
            } else {
                return redirect()->back()->withInput();
            }
        }
    }


}
