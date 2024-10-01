<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


/** PENGADUAN CONTROLLER
 * Menangani berbagai fungsi terkait pengaduan 

    * FUNGSI INDEX
    * Mengarahkan user ke halaman login

    * FUNGSI LOGIN
    * Mengambil input nip dan username user
    * Melakukan proses validasi data
    * Mengirimkan data ke API WBS
    * Menyimpan data response ke session 
    * Menghandle error dan mengembalikannya ke user 

    * FUNGSI LOGOUT
    * Menghapus data session
    * Mengarahkan user ke halaman login
*/

class AuthController extends BaseController
{

    public function index() {
        // Mengembalikan view login index
        return view('login/LoginIndex');
    }
    
    public function login() {
        // Ambil NIP dan password dari input
        $nipuser = $this->request->getPost('nip');
        $password = $this->request->getPost('password');
        
        // Ambil data session
        $attempt = session()->get('login_attempt') ?? 0;  // Percobaan login saat ini
        $lockTime = session()->get('lockout_time');       // Waktu lockout (jika ada)

        // Cek apakah pengguna dalam periode lockout
        if ($lockTime && time() < $lockTime) {
            $remaining = ($lockTime - time()) / 60;  // Hitung waktu tersisa dalam menit
            session()->setFlashdata('error', 'Anda terkunci. Coba lagi dalam ' . ceil($remaining) . ' menit.');
            return redirect()->to(site_url('login/index'));
        }

        // Validasi field NIP dan password
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} hanya boleh berisi angka'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ]
        ]);
        // Handle error validasi
        if (!$valid) {
            $sessError = [
                'errNip' => $validation->getError('nip'),
                'errPassword' => $validation->getError('password')
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(site_url('login/index'));
        }

        // Inisialisasi API credentials
        $apiUser = getenv('API_USER');
        $apiPass = getenv('API_PASS');
        $apiEndpoint = getenv('API_ENDPOINT');

        try {
            // Membuat header Authorization Basic Auth
            $headers = [
                'Authorization: Basic ' . base64_encode($apiUser . ':' . $apiPass)
            ];

            // Data yang akan dikirim via POST
            $post_fields = [
                'username' => $nipuser,
                'password' => $password
            ];

            // Initialisasi cURL
            $ch = curl_init();

            // Setting opsi cURL 
            curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

            // Jalankan request
            $response = curl_exec($ch);

            // Handle error API
            if (curl_errno($ch)) {
                session()->setFlashdata('error', 'Error: ' . curl_error($ch));
                return redirect()->to(site_url('login/index'));
            } 
            // Handle login jika berhasil
            else {
                $responseData = json_decode($response, true);

                if (isset($responseData['data']['nip'], $responseData['data']['level'])) {
                    // Reset jumlah percobaan login setelah berhasil
                    session()->remove('login_attempt');
                    session()->remove('lockout_time');
                    
                    // Simpan data dari response ke session
                    session()->set([
                        'logged_in' => true,
                        'nip' => $responseData['data']['nip'],
                        'level' => [$responseData['data']['level'], "operator", "verifikator"],
                    ]);
                    // Arahkan ke dashboard
                    return redirect()->to('/dashboard');
                } else {
                    // Jika login gagal, tambah percobaan
                    $attempt++;
                    session()->set('login_attempt', $attempt);

                    // Jika sudah lebih dari 3 kali percobaan, lakukan lockout
                    if ($attempt >= 3) {
                        session()->set('lockout_time', time() + 60 * 5);  // Kunci selama 5 menit
                        session()->setFlashdata('error', 'Anda terkunci. Coba lagi dalam 5 menit.');
                    } else {
                        session()->setFlashdata('error', 'NIP atau password salah. Percobaan ke-' . $attempt . ' dari 3.');
                    }

                    return redirect()->to(site_url('login/index'));
                }
            }
            curl_close($ch);
            // Handle jika tidak dapat terhubung ke API
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal menghubungi server API: ' . $e->getMessage());
            return redirect()->to(site_url('login/index'));
        }
    }

    public function logout() {
        // Hapus semua data session
        session()->destroy();
        // Redirect ke halaman login
        return redirect()->to(site_url('login/index'));
    }
}