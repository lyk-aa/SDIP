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
        $db = \Config\Database::connect();
        $builder = $db->table('consortium_members cm');

        $builder->select('
            cm.id, 
            c.id as consortium_id,
            c.name as consortium_name, 
            i.id as institution_id, 
            s.name as institution_name
        ');

        $builder->join('consortiums c', 'c.id = cm.consortium_id', 'left');
        $builder->join('institutions i', 'i.id = cm.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');

        $builder->where('i.status', 'active');
        $builder->orderBy('s.name', 'ASC');

        $data['consortiums'] = $builder->get()->getResult();

        return view('/institution/consortium/index', $data);
    }

    // Show the form to create a new consortium
    public function create()
    {
        $db = \Config\Database::connect();

        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        return view('institution/consortium/create', [
            'institutions' => $institutions
        ]);
    }

    // Store a newly created consortium
    public function store()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'name' => $this->request->getPost('name'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        $db->table('consortiums')->insert($data);
        $consortium_id = $db->insertID();

        $db->table('consortium_members')->insert([
            'institution_id' => $this->request->getPost('institution'),
            'consortium_id' => $consortium_id,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ]);

        return redirect()->to('/institution/consortium/index')->with('cons-success', 'Consortium added successfully!');
    }

    // Show the form to edit an existing consortium
    public function edit($id)
    {
        $db = \Config\Database::connect();

        $consortium = $db->table('consortiums cons')
            ->select('cons.id, cons.name, cm.institution_id')
            ->join('consortium_members cm', 'cm.consortium_id = cons.id', 'left')
            ->where('cons.id', $id)
            ->get()
            ->getRow();

        if (!$consortium) {
            return redirect()->to('/institution/consortium/index')->with('cons-error', 'Consortium not found!');
        }

        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

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

        $data = [
            'name' => $this->request->getPost('name'),
            'updated_at' => $timestamp
        ];

        $db->table('consortiums')->update($data, ['id' => $id]);

        $db->table('consortium_members')
            ->where('consortium_id', $id)
            ->update([
                'institution_id' => $this->request->getPost('institution'),
                'updated_at' => $timestamp
            ]);

        return redirect()->to('/institution/consortium/index')->with('cons-success', 'Consortium updated successfully!');
    }

    // Delete a consortium and its members
    public function delete($id)
    {
        $db = \Config\Database::connect();

        $db->table('consortium_members')->where('consortium_id', $id)->delete();
        $db->table('consortiums')->delete(['id' => $id]);

        return redirect()->to('/institution/consortium/index')->with('cons-success', 'Consortium deleted successfully!');
    }

    // Search for consortiums by name or institution name
    public function search()
    {
        $searchTerm = $this->request->getVar('query');

        $db = \Config\Database::connect();
        $builder = $db->table('consortium_members cm');
        $builder->select('
            cm.id, 
            c.id as consortium_id,
            c.name as consortium_name, 
            i.id as institution_id, 
            s.name as institution_name
        ');

        $builder->join('consortiums c', 'c.id = cm.consortium_id', 'left');
        $builder->join('institutions i', 'i.id = cm.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');

        $builder->like('c.name', $searchTerm);
        $builder->orLike('s.name', $searchTerm);

        $consortiums = $builder->get()->getResult();

        return $this->response->setJSON($consortiums);
    }

    // Print Consortium
    public function printConsortium()
{
    $db = \Config\Database::connect();
    $builder = $db->table('consortium_members cm');

    $builder->select('
        c.name as consortium_name,
        s.name as institution_name
    ');

    $builder->join('consortiums c', 'c.id = cm.consortium_id', 'left');
    $builder->join('institutions i', 'i.id = cm.institution_id', 'left');
    $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');
    $builder->where('i.status', 'active');
    $builder->orderBy('c.name, s.name', 'ASC');

    $results = $builder->get()->getResult();

    // Group institutions by consortium
    $grouped = [];
    foreach ($results as $row) {
        $grouped[$row->consortium_name][] = $row->institution_name;
    }

    $consortiumDetails = [];
    foreach ($grouped as $consortium => $institutions) {
        $consortiumDetails[] = [
            'consortium_name' => $consortium,
            'institutions' => $institutions,
        ];
    }

    return view('institution/consortium/print_consortium', [
        'consortiumDetails' => $consortiumDetails
    ]);
    }
}
