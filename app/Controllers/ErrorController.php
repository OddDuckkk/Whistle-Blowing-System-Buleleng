<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ErrorController extends BaseController
{
    public function viewForbidden() {
        return view('errors_page/403');
    }

    public function viewNotFound() {
        return view('errors_page/404');
    }
}
