<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BalikScientistController extends BaseController
{
    public function balik_scientist()
    {
        return view('/institution/balik_scientist/index');
    }

}
