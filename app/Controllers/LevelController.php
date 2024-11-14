<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

/** LEVEL CONTROLLER
 * Menangani berbagai fungsi terkait level khusus user 

    * Level default (user/pelapor) secara default dimiliki oleh semua user yang dapat login ke dalam aplikasi
    * Level khusus seperti superadmin, operator, verifikator ditangani pada controller ini

    * FUNGSI GET ALL USER LEVELS
    * Mencari dan mengembalikan semua user yang memiliki level khusus 
    * Menuju View Index Level 

    * FUNGSI VIEW ASSIGN
    * Meneruskan user ke view formulir menambah user level

    * FUNGSI STORE
    * Menyimpan data user level yang dikirim oleh user kedalam database 

    * FUNGSI VIEW EDIT
    * Meneruskan user ke view formulir edit user level

    * FUNGSI UPDATE
    * Memperbaharui data user level yang dikirim oleh user

    * FUNGSI DELETE
    * Menghapus data user level berdasarkan nip

    * FUNGSI VALIDATE USER LEVEL ASSIGNMENT
    * Memvalidasi data User level yang dikirimkan melalui form
    * Validasi menggunakan Code igniter validation dan custom validation
    * Mengembalikan pesan error ke view apabila validasi gagal
*/

class LevelController extends BaseController
{
    public function getAllUserLevels() {
    // Mengambil semua user yang memiliki level khusus
    $usersWithLevels = $this->levelModel->getUsersWithRoles();
        
    // Mengirimkan data kembali ke view IndexUserLevel
    return view('menu/userlevel/index_user_level', ['userLevels' => $usersWithLevels]);
    }

    public function viewAssign() {
        // Menampilkan view untuk mengatur level user
        return view('menu/userlevel/assign_user_level');
    }

    public function store() {

        // Validasi data yang diinput dari form-CreatePengaduan 
        // Menggunakan fungsi validateUserLevel
        if (!$this->validateUserLevelAssignment()) {
            $sessError = [
                'errNipPegawai' => $this->validation->getError('nip_pegawai'),
                'errNamaPegawai' => $this->validation->getError('nama_pegawai'),
                'errJabatanPegawai' => $this->validation->getError('jabatan_pegawai'),
                'errUnitKerja' => $this->validation->getError('unit_kerja'),
                'errLevelPegawai' => $this->validation->getError('level_pegawai'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(site_url("/user-level/assign"))->withInput();
        }

        // ambil data dari form  submission
        $nip = $this->request->getPost('nip_pegawai');
        $nama_pegawai = $this->request->getPost('nama_pegawai');
        $jabatan_pegawai = $this->request->getPost('jabatan_pegawai');
        $unit_kerja = $this->request->getPost('unit_kerja');
        $level = $this->request->getPost('level_pegawai');

        $existingUser = $this->levelModel->where('nip', $nip)->first();

        // cek apakah nip tersebut sudah memiliki level khusus atau tidak
        if ($existingUser) {
            session()->setFlashdata('failure_message', 'Satu user hanya boleh memiliki satu level khusus! Silahkan update data yang sudah ada.');
            return redirect()->back()->withInput();
        } else {
            // simpan data baru
            $data = [
                'nip' => $nip,
                'level' => $level,
                'nama_pegawai' => $nama_pegawai,
                'jabatan_pegawai' => $jabatan_pegawai,
                'unit_kerja' => $unit_kerja,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'), 
            ];

            $this->levelModel->save($data);

            session()->setFlashdata('success_message', 'User level berhasil ditambahkan!');
            return redirect()->to('/user-level');
        }
    }

    public function viewEdit($nip) {
        $data['userLevel'] = $this->levelModel->find($nip);

        // Mengembalikan data ke view edit 
        return view('menu/userlevel/edit_user_level', $data);
    }

    public function update($id)
    {
        // Validasi data
        if (!$this->validateUserLevelAssignment()) {
            $sessError = [
                'errNipPegawai' => $this->validation->getError('nip_pegawai'),
                'errNamaPegawai' => $this->validation->getError('nama_pegawai'),
                'errJabatanPegawai' => $this->validation->getError('jabatan_pegawai'),
                'errUnitKerja' => $this->validation->getError('unit_kerja'),
                'errLevelPegawai' => $this->validation->getError('level_pegawai'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(site_url("/user-level/edit/$id"))->withInput();
        }

        // ambil dara dari submission
        $nip = $this->request->getPost('nip_pegawai');
        $nama_pegawai = $this->request->getPost('nama_pegawai');
        $jabatan_pegawai = $this->request->getPost('jabatan_pegawai');
        $unit_kerja = $this->request->getPost('unit_kerja');
        $level = $this->request->getPost('level_pegawai');

        // cek apakah user level ada
        $existingUser = $this->levelModel->find($id);

        if (!$existingUser) {
            session()->setFlashdata('failure_message', 'Pegawai tidak ditemukan!');
            return redirect()->to('/user-level');
        }

        // Update data
        $data = [
            'nip' => $nip,
            'nama_pegawai' => $nama_pegawai,
            'jabatan_pegawai' => $jabatan_pegawai,
            'unit_kerja' => $unit_kerja,
            'level' => $level,
            'updated_at' => date('Y-m-d H:i:s'), // Update the timestamp
        ];

        $this->levelModel->update($id, $data);

        // Redirect 
        session()->setFlashdata('success_message', 'User level berhasil diperbaharui!');
        return redirect()->to('/user-level');
    }


    public function delete($nip) {
        // Temukan data user level berdasarkan nip
        $userLevel = $this->levelModel->find($nip);
        if ($userLevel) {
            // Hapus data user level
            $this->levelModel->delete($nip);
            session()->setFlashdata('success_message', 'User level berhasil dihapus!');
            return redirect()->to('/user-level');
        } else {
            session()->setFlashdata('failure_message', 'User level tidak ditemukan!');
            return redirect()->to('/user-level');
        }
    }

    private function validateUserLevelAssignment() {
        return $this->validate([
            'nip_pegawai' => [
                'label' => 'Nip pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'nama_pegawai' => [
                'label' => 'Nama pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'jabatan_pegawai' => [
                'label' => 'Jabatan pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'unit_kerja' => [
                'label' => 'Unit Kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'level_pegawai' => [
                'label' => 'Level pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
        ]);
    }
}
