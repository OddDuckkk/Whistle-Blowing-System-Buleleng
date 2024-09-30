<?php

// namespace App\Controllers;

// use App\Controllers\BaseController;
// use CodeIgniter\HTTP\ResponseInterface;

// class UserRolesController extends BaseController
// {
//     public function index()
//     {
//         // Ambil data user_id dari session
//         $userId = session()->get('user_id');

//         // Ambil data roles berdasarkan user_id
//         $roleModel = new \App\Models\RoleModel(); // Buat model untuk akses data roles
//         $roles = $roleModel->table('userRoles')
//         ->join('roles', 'roles.id = userRoles.role_id')
//         ->where('userRoles.user_id', $userId)
//         ->findAll();
        
//         // Kirim data roles ke view
//         return view('user_profile', ['roles' => $roles]);
//     }
// }
