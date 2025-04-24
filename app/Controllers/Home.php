<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function home(): string
    {
        $db = \Config\Database::connect();
        $builder = $db->table('rd_innovation_centers');
        $query = $builder->select('name, latitude, longitude')->get();
        $centers = $query->getResult();

        return view('home', ['centers' => $centers]);
    }


}
