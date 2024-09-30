<?php

namespace App\Controllers;


use App\Models\UserModel;
use App\Models\RoleModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();
        return view('users/index', $data);
    }

    public function create()
    {
        $model = new RoleModel();
        $data['roles'] = $model->findAll();
        return view('users/create', $data);
    }

    public function store()
    {
        $model = new UserModel();
        $data = [
            'api_user_id' => $this->request->getPost('api_user_id'),
        ];
        $model->save($data);
        return redirect()->to('/users');
    }
}
