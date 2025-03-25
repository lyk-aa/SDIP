<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class NcrpController extends BaseController
{
    public function ncrp_members()
    {
        return view('/institution/ncrp_members/index');
    }
}
