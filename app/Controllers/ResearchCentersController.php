<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ResearchCentersController extends BaseController
{
    public function research_centers()
    {
        return view('/institution/research_centers/index');
    }
}
