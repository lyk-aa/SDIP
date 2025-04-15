<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ConsortiumController extends BaseController
{
    public function consortium()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('consortium_members cm');
        $builder->select('
        cm.id, 
        c.id as consortium_id,
        c.name as consortium_name, 
        i.id as institution_id, 
        s.name as institution_name
    '); // Removed extra comma
        $builder->join('consortiums c', 'c.id = cm.consortium_id', 'left');
        $builder->join('institutions i', 'i.id = cm.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');

        $data['consortiums'] = $builder->get()->getResult(); // 🔥 Use getResult() to return objects

        return view('/institution/consortium/index', $data);
    }


    public function create()
    {
        $db = \Config\Database::connect();

        // Fetch institutions from stakeholders via institutions table
        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->get()
            ->getResult();

        return view('institution/consortium/create', [
            'institutions' => $institutions
        ]);
    }

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



        return redirect()->to('/institution/consortium/index')->with('success', 'Scientist added successfully!');
    }

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
            return redirect()->to('/institution/consortium/index')->with('error', 'Consortium not found!');
        }

        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->get()
            ->getResult();

        return view('institution/consortium/edit', [
            'consortium' => $consortium,
            'institutions' => $institutions
        ]);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Get the input data
        $data = [
            'name' => $this->request->getPost('name'),
            'updated_at' => $timestamp
        ];

        // Update the consortium
        $db->table('consortiums')->update($data, ['id' => $id]);

        // Update the consortium members (if necessary)
        $db->table('consortium_members')
            ->where('consortium_id', $id)
            ->update([
                'institution_id' => $this->request->getPost('institution'),
                'updated_at' => $timestamp
            ]);

        return redirect()->to('/institution/consortium/index')->with('success', 'Consortium updated successfully!');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();

        // Delete consortium members
        $db->table('consortium_members')->where('consortium_id', $id)->delete();

        // Delete the consortium
        $db->table('consortiums')->delete(['id' => $id]);

        return redirect()->to('/institution/consortium/index')->with('success', 'Consortium deleted successfully!');
    }

    public function search()
    {
        $searchTerm = $this->request->getVar('query');

        // Use the search term to filter consortiums
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

        // Apply search filter on consortium name and institution name
        $builder->like('c.name', $searchTerm);
        $builder->orLike('s.name', $searchTerm);

        // Fetch results
        $consortiums = $builder->get()->getResult();

        // Return the results as JSON
        return $this->response->setJSON($consortiums);
    }
}
