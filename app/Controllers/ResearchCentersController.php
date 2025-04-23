<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class ResearchCentersController extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        $data['research_centers'] = $db->table('rd_innovation_centers')
            ->select('rd_innovation_centers.*, s.name as stakeholder_name')
            ->join('institutions i', 'i.id = rd_innovation_centers.institution_id', 'left')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->get()
            ->getResult();

        return view('institution/research_centers/index', $data);
    }

    public function create()
    {
        $db = Database::connect();
        $data['institutions'] = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        return view('institution/research_centers/create', $data);
    }
    public function store()
    {
        helper(['form']);
    
        $validationRules = [
            'institution' => 'required|integer',
            'name'        => 'required|string|max_length[255]',
            'description' => 'required|string',
            'longitude'   => 'permit_empty|decimal',
            'latitude'    => 'permit_empty|decimal',
        ];
    
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $db = Database::connect();
        $timestamp = date('Y-m-d H:i:s');
    
        $data = [
            'institution_id' => $this->request->getPost('institution'),
            'name'           => $this->request->getPost('name'),
            'description'    => $this->request->getPost('description'),
            'longitude'      => $this->request->getPost('longitude'),
            'latitude'       => $this->request->getPost('latitude'),
            'created_at'     => $timestamp,
            'updated_at'     => $timestamp
        ];
    
        $db->table('rd_innovation_centers')->insert($data);
    
        return redirect()->to('/institution/research_centers/index')
            ->with('success', 'Research Center added successfully!');
    }
    
    public function edit($id)
    {
        $db = Database::connect();

        $research_center = $db->table('rd_innovation_centers')->where('id', $id)->get()->getRow();

        if (!$research_center) {
            return redirect()->to('/institution/research_centers/index')->with('error', 'Research Center not found!');
        }

        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        return view('institution/research_centers/edit', [
            'research_center' => $research_center,
            'institutions' => $institutions
        ]);
    }

    public function delete($id)
    {
        $db = Database::connect();
        $db->table('rd_innovation_centers')->where('id', $id)->delete();

        return redirect()->to('/institution/research_centers/index')
            ->with('success', 'Research Center deleted successfully!');
    }

    public function search()
    {
        $searchTerm = $this->request->getVar('query');
        $db = Database::connect();

        $results = $db->table('rd_innovation_centers rc')
            ->select('rc.*, s.name as institution_name')
            ->join('institutions i', 'i.id = rc.institution_id', 'left')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->groupStart()
                ->like('rc.name', $searchTerm)
                ->orLike('s.name', $searchTerm)
            ->groupEnd()
            ->get()
            ->getResult();

        return $this->response->setJSON($results);
    }
}
