<?php

// namespace App\Controllers;

// use App\Models\RoleModel;
// use App\Controllers\BaseController;
// use CodeIgniter\HTTP\ResponseInterface;

// class RoleController extends BaseController
// {
//     public function index()
//     {
//         $model = new RoleModel();
//         $data['roles'] = $model->findAll();
//         return view('roles/index', $data);
//     }

//     public function create()
//     {
//         return view('roles/create');
//     }

//     public function store()
//     {
//         $model = new RoleModel();
//         $data = [
//             'name' => $this->request->getPost('name'),
//         ];
//         $model->save($data);
//         return redirect()->to('/roles');
//     }
// }
