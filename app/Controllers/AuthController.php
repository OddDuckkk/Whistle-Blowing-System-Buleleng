<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoleModel;

class AuthController extends BaseController
{

    public function index()
    {
        return view('login/LoginIndex');
    }
    
    public function login()
    {
        // Mengambil nip dan password dari input
        $nipuser = $this->request->getPost('nip');
        $password = $this->request->getPost('password');

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
        // Conditional apabila data tidak valid
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
        $apiEndpoint = getenv('API_ENDPOINT');; 

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
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Mengembalikan respons sebagai string
            curl_setopt($ch, CURLOPT_POST, true); // Metode POST
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set header Authorization
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); // Set data POST
        
            // Execute the request
            $response = curl_exec($ch);
        
            // Check for errors during execution
            if (curl_errno($ch)) {
                // Jika terjadi error, tangani disini
                $error_msg = curl_error($ch);
                session()->setFlashdata('error', 'Error: ' . $error_msg);
                return redirect()->to(site_url('login/index'));
            } else {
                // Debug: tampilkan respons mentah dari API;
                // echo $response; // Uncomment untuk debugging
                // Jika tidak ada error, proses respons dari server
                $responseData = json_decode($response, true);
        
                // Pastikan status dari API adalah 200 dan data nip & level ada
                if (isset($responseData['data']['nip'], $responseData['data']['level'])) {
                    // Set session dengan NIP dan level
                    $nip = $responseData['data']['nip'];
                    $level = $responseData['data']['level'];
                    // echo "NIP: " . $nip . "<br>";
                    // echo "Level: " . $level;
                    session()->set([
                        'logged_in' => true,
                        'nip' => $nip,
                        'level' => $level,
                    ]);
        
                    // Redirect ke halaman dashboard
                    return redirect()->to('/dashboard');
                } else {
                    // Handle jika NIP dan level tidak ditemukan
                    session()->setFlashdata('error', $responseData['message'] ?? 'Invalid NIP or password.');
                    return redirect()->to(site_url('login/index'));
                }
            }
        
            // Close the cURL session
            curl_close($ch);
        } catch (\Exception $e) {
            // Handle error exception
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