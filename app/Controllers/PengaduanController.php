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

    * FUNGSI GENERATE NOMOR PENGADUAN
    * Membuat nomor pengaduan baru menggunakan format WBS00000

    * FUNGSI SAVE PIHAK TERLIBAT
    * Menyimpan data pihak terlibat yang diunggah oleh user kedalam database

    * FUNGSI SAVE LAMPIRAN
    * Menyimpan data lampiran yang diunggah oleh user kedalam database

    * FUNGSI VALIDASI PENGADUAN
    * Memvalidasi data pengaduan+ pihak terlibat + lampiran yang dikirimkan melalui form
    * Validasi menggunakan Code igniter validation dan custom validation
    * Mengembalikan pesan error ke view apabila validasi gagal
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
        $statuses = PengaduanModel::$pelaporActiveStatuses;

        $data['pengaduan'] = $this->pengaduanModel
                                  ->findByUserId($userId)
                                  ->filterByStatus($statuses)
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }

    public function getPelaporInactivePengaduan($userId) {
        $statuses = PengaduanModel::$pelaporInactiveStatuses;

        $data['pengaduan'] = $this->pengaduanModel
                                  ->findByUserId($userId)
                                  ->filterByStatus($statuses)
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }
    public function getOperatorActivePengaduan() {
        $statuses = PengaduanModel::$operatorActiveStatuses;

        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }
    public function getOperatorInactivePengaduan() {
        $statuses = PengaduanModel::$operatorInactiveStatuses;

        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }

    public function getVerifikatorActivePengaduan() {
        $statuses = PengaduanModel::$verifikatorActiveStatuses;

        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }
    public function getVerifikatorInactivePengaduan() {
        $statuses = PengaduanModel::$verifikatorInactiveStatuses;

        $data['pengaduan'] = $this->pengaduanModel
                                  ->filterByStatus($statuses)
                                  ->findAll();

        return view('menu/pengaduan/index_pengaduan', $data);
    }


    public function getById($id) {
        //Mengambil semua data pengaduan berdasarkan id pengaduan 
        $data['pengaduan'] = $this->pengaduanModel->find($id);
        // Tampilkan data pengaduan 
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
        return view('menu/pengaduan/details_pengaduan', $data);
    }

    public function viewCreate() {
        // Tampilkan data create pengaduan
        return view('menu/pengaduan/create_pengaduan');
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
        $newNumber = $this->generateNomorPengaduan();

        // Proses simpan data pengaduan 
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

        // Proses simpan data pihak terlibat 
        $this->savePihakTerlibat($pengaduanId);

        // Proses simpan data lampiran
        $this->saveLampiran($pengaduanId);

        return redirect()->to('/pengaduan')->with('message', 'Pengaduan berhasil ditambahkan!');
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

        if (!$this->validatePengaduan()) {
            $sessError = [
                'errJudul' => $this->validation->getError('judul'),
                'errTanggal' => $this->validation->getError('tanggal'),
                'errNominal' => $this->validation->getError('nominal'),
                'errTempat' => $this->validation->getError('tempat'),
                'errDeskripsi' => $this->validation->getError('deskripsi'),
                'errNamaTerlapor' => $this->validation->getError('nama_terlapor[]'),
                'errJabatanTerlapor' => $this->validation->getError('jabatan_terlapor[]'),
                'errUnitKerja' => $this->validation->getError('unit_kerja[]'),
                'errFileLampiran' => $this->validation->getError('file_lampiran[]'),
                'errDeskripsiLampiran' => $this->validation->getError('deskripsi_lampiran[]')
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

    protected function generateNomorPengaduan() {
        // Mengambil nomor pengaduan terakhir
        $lastPengaduan = $this->pengaduanModel->orderBy('id', 'DESC')->first();
        // Mengambil digit akhir 
        $lastId = $lastPengaduan ? intval(substr($lastPengaduan['nomor_pengaduan'], 3)) : 0;
        // Mengembalikan nomor pengaduan baru
        return 'WBS' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
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
                $randomName = bin2hex(random_bytes(8)) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
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
                // Ensure the path is correct; it should match the upload path
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $data['filePath'];
    
                // Ensure the path is correct, and then delete the file
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
    
    // Check if the errors contain any for the specified array field name
    foreach ($errors as $key => $error) {
        // Matches the field name and captures the specific index if present
        if (preg_match('/' . preg_quote($fieldName) . '\.(\d+)/', $key, $matches)) {
            $index = $matches[1];
            $fieldErrors[$index] = $error; // Store the error message by index
        }
    }

    return $fieldErrors;
    }

    private function validatePengaduan() {
        
        return $this->validate([
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
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
            // 'file_lampiran.*' => [
            //     'label' => 'File lampiran',
            //     'rules' => 'uploaded[file_lampiran]|mime_in[file_lampiran,image/jpg,image/jpeg,image/png,application/pdf]|max_size[file_lampiran,10240]',
            //     'errors' => [
            //         'uploaded' => '{field} harus diunggah',
            //         'mime_in' => '{field} harus berupa file dengan format jpg, jpeg, png, atau pdf',
            //         'max_size' => '{field} tidak boleh lebih dari 10MB'
            //     ]
            // ], 
            // Validasi file lampiran dilakukan di frontend (create_pengaduan.js)
            'deskripsi_lampiran.*' => [
                'label' => 'Deskripsi lampiran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ]);
    }

}
