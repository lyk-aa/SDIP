<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ConsortiumController extends BaseController
{
    // Display all consortiums with their associated institutions
    public function consortium()
    {
        $data['child_page'] = 'Consortium';
        // Connect to the database
        $db = \Config\Database::connect();
        $builder = $db->table('consortium_members cm');

        // Select columns from the consortiums and institutions tables
        $builder->select('
        cm.id, 
        c.id as consortium_id,
        c.name as consortium_name, 
        i.id as institution_id, 
        s.name as institution_name
    ');

        // Join related tables: consortiums, institutions, stakeholders
        $builder->join('consortiums c', 'c.id = cm.consortium_id', 'left');
        $builder->join('institutions i', 'i.id = cm.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');

        // Filter active institutions only
        $builder->where('i.status', 'active');

        // Sort results alphabetically by institution (stakeholder) name
        $builder->orderBy('s.name', 'ASC');

        // Execute query and pass the results to the view
        $data['consortiums'] = $builder->get()->getResult();

        return view('/institution/consortium/index', $data);
    }

    // Show the form to create a new consortium
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
        return view('institution/consortium/create', [
            'institutions' => $institutions
        ]);
    }

    // Store a newly created consortium
    public function store()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Prepare the data to insert into the consortiums table
        $data = [
            'name' => $this->request->getPost('name'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        // Insert consortium data and retrieve the last inserted ID
        $db->table('consortiums')->insert($data);
        $consortium_id = $db->insertID();

        // Insert a new member into the consortium_members table
        $db->table('consortium_members')->insert([
            'institution_id' => $this->request->getPost('institution'),
            'consortium_id' => $consortium_id,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ]);

        // Redirect to the consortium list with a success message
        return redirect()->to('/institution/consortium/index')->with('cons-success', 'Consortium added successfully!');
    }

    // Show the form to edit an existing consortium
    public function edit($id)
    {
        $db = \Config\Database::connect();

        // Fetch the consortium details along with the institution ID
        $consortium = $db->table('consortiums cons')
            ->select('cons.id, cons.name, cm.institution_id')
            ->join('consortium_members cm', 'cm.consortium_id = cons.id', 'left')
            ->where('cons.id', $id)
            ->get()
            ->getRow();

        // If consortium not found, redirect with an error message
        if (!$consortium) {
            return redirect()->to('/institution/consortium/index')->with('cons-error', 'Consortium not found!');
        }

        // Fetch active institutions and their stakeholder names
        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        // Pass consortium and institutions data to the edit view
        return view('institution/consortium/edit', [
            'consortium' => $consortium,
            'institutions' => $institutions
        ]);
    }

    // Update an existing consortium
    public function update($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Prepare the data to update the consortium
        $data = [
            'name' => $this->request->getPost('name'),
            'updated_at' => $timestamp
        ];

        // Update the consortium record
        $db->table('consortiums')->update($data, ['id' => $id]);

        // Update the consortium members (if necessary)
        $db->table('consortium_members')
            ->where('consortium_id', $id)
            ->update([
                'institution_id' => $this->request->getPost('institution'),
                'updated_at' => $timestamp
            ]);

        // Redirect to the consortium list with a success message
        return redirect()->to('/institution/consortium/index')->with('cons-success', 'Consortium updated successfully!');
    }

    // Delete a consortium and its members
    public function delete($id)
    {
        $db = \Config\Database::connect();

        // Delete all members associated with the consortium
        $db->table('consortium_members')->where('consortium_id', $id)->delete();

        // Delete the consortium record
        $db->table('consortiums')->delete(['id' => $id]);

        // Redirect to the consortium list with a success message
        return redirect()->to('/institution/consortium/index')->with('cons-success', 'Consortium deleted successfully!');
    }

    // Search for consortiums by name or institution name
    public function search()
    {
        // Get the search term from the request
        $searchTerm = $this->request->getVar('query');

        // Connect to the database
        $db = \Config\Database::connect();
        $builder = $db->table('consortium_members cm');
        $builder->select('
        cm.id, 
        c.id as consortium_id,
        c.name as consortium_name, 
        i.id as institution_id, 
        s.name as institution_name
    ');

        // Join related tables: consortiums, institutions, stakeholders
        $builder->join('consortiums c', 'c.id = cm.consortium_id', 'left');
        $builder->join('institutions i', 'i.id = cm.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');

        // Filter by consortium name or institution name based on the search term
        $builder->like('c.name', $searchTerm);
        $builder->orLike('s.name', $searchTerm);

        // Fetch the filtered results
        $consortiums = $builder->get()->getResult();

        // Return the search results as JSON
        return $this->response->setJSON($consortiums);
    }
}
