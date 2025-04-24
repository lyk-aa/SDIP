<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Controller;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;
use App\Models\InstitutionModel;




class InstitutionController extends BaseController
{

    // home
    public function index()
    {
        $stakeholderModel = new StakeholderModel();
        $stakeholders = $stakeholderModel->where('category', 'Academe')->findAll();

        return view('/institution/home', compact('stakeholders'));
    }

    public function store()
    {
        $institutionModel = new InstitutionModel();

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $image = $this->request->getFile('image');

        $data = [
            'stakeholder_id' => $title,
            'description' => $description,
        ];

        // Handle file upload
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/institutions/', $newName);
            $data['image'] = $newName;
        }

        $institutionModel->save($data);

        return redirect()->back()->with('success', 'Institution added successfully');
    }

    // public function balik_scientist()
    // {
    //     return view('/institution/balik_scientist/index');
    // }
    // public function consortium()
    // {
    //     return view('/institution/consortium/index');
    // }
    // public function ncrp_members()
    // {
    //     return view('/institution/ncrp_members/index');
    // }
    // public function projects()
    // {
    //     return view('/institution/projects/index');
    // }
    // public function research_centers()
    // {
    //     return view('/institution/research_centers/index');
    // }
}
