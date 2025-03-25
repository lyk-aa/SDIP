<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProjectsController extends BaseController
{
    public function projects()
    {
        return view('/institution/projects/index');
    }
}
