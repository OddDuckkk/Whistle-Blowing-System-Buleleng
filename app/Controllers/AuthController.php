<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoleModel;

class AuthController extends BaseController
{

    public function index() {
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
            // Buat header Authorization menggunakan Basic Auth
            $headers = [
                'Authorization: Basic ' . base64_encode($apiUser . ':' . $apiPass)
            ];

            // Data yang akan dikirim via POST
            $post_fields = [
                'username' => $nipuser,
                'password' => $password
            ];

            // Initialize cURL
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

            // Execute the request
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                session()->setFlashdata('error', 'Error: ' . curl_error($ch));
                return redirect()->to(site_url('login/index'));
            } else {
                $responseData = json_decode($response, true);

                if (isset($responseData['data']['nip'], $responseData['data']['level'])) {
                    // Reset jumlah percobaan login setelah berhasil
                    session()->remove('login_attempt');
                    session()->remove('lockout_time');

                    session()->set([
                        'logged_in' => true,
                        'nip' => $responseData['data']['nip'],
                        'level' => [$responseData['data']['level']],
                    ]);

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