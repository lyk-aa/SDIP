<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ConsortiumController extends BaseController
{
    public function consortium()
    {
        return view('/institution/consortium/index');
    }
}
