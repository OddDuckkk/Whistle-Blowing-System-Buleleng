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
        $nipuser = $this->request->getPost('nip');
        $password = $this->request->getPost('password');

        // Validasi field NIP dan password
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
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

        // Jika validasi gagal, kembali ke halaman login dengan pesan error
        if (!$valid) {
            $sessError = [
                'errNip' => $validation->getError('nip'),
                'errPassword' => $validation->getError('password')
            ];

            session()->setFlashdata($sessError);
            return redirect()->to(site_url('login/index'));
        }

        // Jika validasi berhasil, cek NIP dan password dari database
        $userModel = new \App\Models\UserModel(); // Pastikan Anda sudah membuat model User
        $user = $userModel->where('nip', $nipuser)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Get user roles from userRoles table
            $db = \Config\Database::connect();
            $builder = $db->table('user_roles');
            $roles = $builder->select('role_id')
                             ->where('user_id', $user['id'])
                             ->get()
                             ->getResultArray();

            // Extract role IDs into an array
            $roleIds = array_column($roles, 'role_id');
            
            // Set session data with all roles and default current role (role_id = 2)
            session()->set([
                'logged_in'    => true,
                'user_id'      => $user['id'],
                'user_roles'   => $roleIds, // Store all roles in an array
                'current_role' => 2 // Set default current role to 2
            ]);

            return redirect()->to('/pengaduan'); 
        } else {
            // Handle login failure
            session()->setFlashdata('error', 'Invalid NIP or password.');
            return redirect()->to(site_url('login/index'));
        }
    }

    public function logout()
    {
        // Hapus semua session
        session()->destroy();
        return redirect()->to(site_url('login/index'));
    }

    // Method to change role within the application
    public function changeRole($roleId)
{
    // Check if the user has the role
    $userRoles = session()->get('user_roles');
    if (in_array($roleId, $userRoles)) {
        // Set the new role in session
        session()->set('current_role', $roleId);
        return redirect()->to('/dashboard'); // Redirect to the desired page
    }

    return redirect()->back()->with('error', 'Role tidak valid');
}

    public function test()
    {
        return view('main/testing');
    }
}
