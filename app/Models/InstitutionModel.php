<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ResearchCentersController extends BaseController
{
    // List all research centers
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('rd_innovation_centers rc');
        $builder->select('rc.id, rc.name, rc.created_at, rc.updated_at, i.id as institution_id, s.name as institution_name');
        $builder->join('institutions i', 'i.id = rc.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');
        $data['research_centers'] = $builder->get()->getResult();

        return view('institution/research_centers/index', $data);
    }

    // Show the form to create a new research center
    public function create()
    {
        $db = \Config\Database::connect();
        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        return view('institution/research_centers/create', [
            'institutions' => $institutions
        ]);
    }

    // Store a newly created research center
    public function store()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');
        $institution_id = $this->request->getPost('institution');

        // Optional: validate institution exists
        $exists = $db->table('institutions')->where('id', $institution_id)->countAllResults();
        if (!$exists) {
            return redirect()->back()->with('error', 'Invalid institution selected.');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'institution_id' => $institution_id,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        $db->table('rd_innovation_centers')->insert($data);

        return redirect()->to('/institution/research_centers/index')
            ->with('research-center-success', 'Research Center added successfully!');
    }

    // Edit form for existing research center
    public function edit($id)
    {
        $db = \Config\Database::connect();

        $research_center = $db->table('rd_innovation_centers rc')
            ->select('rc.id, rc.name, rc.institution_id')
            ->where('rc.id', $id)
            ->get()
            ->getRow();

        if (!$research_center) {
            return redirect()->to('/institution/research_centers/index')->with('research-center-error', 'Research Center not found!');
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

    // Update research center
    public function update($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        $institution_id = $this->request->getPost('institution');
        $exists = $db->table('institutions')->where('id', $institution_id)->countAllResults();
        if (!$exists) {
            return redirect()->back()->with('error', 'Invalid institution selected.');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'institution_id' => $institution_id,
            'updated_at' => $timestamp
        ];

        $db->table('rd_innovation_centers')->update($data, ['id' => $id]);

        return redirect()->to('/institution/research_centers/index')
            ->with('research-center-success', 'Research Center updated successfully!');
    }

    // Delete a research center
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('rd_innovation_centers')->delete(['id' => $id]);

        return redirect()->to('/institution/research_centers/index')
            ->with('research-center-success', 'Research Center deleted successfully!');
    }

    // Search functionality
    public function search()
    {
        $searchTerm = $this->request->getVar('query');
        $db = \Config\Database::connect();

        $builder = $db->table('rd_innovation_centers rc');
        $builder->select('rc.id, rc.name as research_center_name, i.id as institution_id, s.name as institution_name');
        $builder->join('institutions i', 'i.id = rc.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');
        $builder->like('rc.name', $searchTerm)->orLike('s.name', $searchTerm);

        $results = $builder->get()->getResult();
        return $this->response->setJSON($results);
    }

    // Print view (optional)
    public function printResearchCenter()
    {
        return view('institution/research_centers/print_research_center');
    }
}
