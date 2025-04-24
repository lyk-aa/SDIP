<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class ResearchCentersController extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        $builder = $db->table('rd_innovation_centers rd');
        
        $builder->select('
            rd.id,
            rd.name as research_center_name,
            i.id as institution_id,
            s.name as institution_name
        ');
        
        $builder->join('institutions i', 'i.id = rd.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');
        $builder->where('i.status', 'active');
        $builder->orderBy('s.name', 'ASC');
        
        $data['research_centers'] = $builder->get()->getResult();
        
        return view('institution/research_centers/index', $data);
    }
    


    public function create()
    {
        $db = \Config\Database::connect();

        // Fetch active institutions and their stakeholder names
        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        // Pass institutions data to the create view
        return view('institution/research_centers/create', [
            'institutions' => $institutions
        ]);
    }

    // Store a newly created research center
    public function store()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Prepare the data to insert into the rd_innovation_centers table
        $data = [
            'name' => $this->request->getPost('name'),
            'institution_id' => $this->request->getPost('institution'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        // Insert research center data
        $db->table('rd_innovation_centers')->insert($data);

        // Redirect to the research centers list with a success message
        return redirect()->to('/institution/research_centers/index')->with('centers-success', 'Research Center added successfully!');
    }
// Edit an existing research center
public function edit($id)
{
    $db = \Config\Database::connect();

    // Fetch the research center data
    $research_center = $db->table('rd_innovation_centers')
        ->select('id, name, institution_id')
        ->where('id', $id)
        ->get()
        ->getRow();

    // Fetch active institutions and their stakeholder names
    $institutions = $db->table('institutions i')
        ->select('i.id, s.name')
        ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
        ->where('i.status', 'active')
        ->get()
        ->getResult();

    // Pass research center data and institutions data to the edit view
    return view('institution/research_centers/edit', [
        'research_center' => $research_center,
        'institutions' => $institutions
    ]);
}

// Update an existing research center
public function update($id)
{
    $db = \Config\Database::connect();
    $timestamp = date('Y-m-d H:i:s');

    // Get the institution_id from the form input
    $institution_id = $this->request->getPost('institution');

    // Check if the institution exists and is active
    $institution = $db->table('institutions')
                      ->where('id', $institution_id)
                      ->where('status', 'active')
                      ->get()
                      ->getRow();

    if (!$institution) {
        // Redirect with error message if institution is invalid
        return redirect()->back()->with('error', 'Invalid or inactive institution selected.');
    }

    // Prepare the data to update the rd_innovation_centers table
    $data = [
        'name' => $this->request->getPost('name'),
        'institution_id' => $institution_id,
        'updated_at' => $timestamp
    ];

    // Update the research center record
    $db->table('rd_innovation_centers')->update($data, ['id' => $id]);

    // Redirect to the research centers list with a success message
    return redirect()->to('/institution/research_centers/index')->with('centers-success', 'Research Center updated successfully!');
}

// Delete an existing research center
public function delete($id)
{
    $db = \Config\Database::connect();

    // Delete the research center data
    $db->table('rd_innovation_centers')->delete(['id' => $id]);

    // Redirect to the research centers list with a success message
    return redirect()->to('/institution/research_centers/index')->with('centers-success', 'Research Center deleted successfully!');
}
}

