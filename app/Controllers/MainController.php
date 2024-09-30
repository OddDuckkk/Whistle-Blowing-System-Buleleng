<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MainController extends BaseController
{
    public function index()
    {
        return view('main/layout');
    }

    public function viewDashboard()
    {
        return view('menu/dashboard/dashboard');
    }
}
