<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BalikScientistController extends BaseController
{
    public function balik_scientist()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('balik_scientist_engaged bse');
        $builder->select('
            bse.id, 
            bse.description, 
            bse.image, 
            i.id as institution_id, 
            s.name as institution_name, 
            p.id as person_id, 
            p.honorifics, 
            p.first_name, 
            p.middle_name, 
            p.last_name, 
            p.role
        ');
        $builder->join('institutions i', 'i.id = bse.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');
        $builder->join('persons p', 'p.id = bse.person_id', 'left');
        
        $data['balik_scientists'] = $builder->get()->getResultArray();
    
        return view('institution/balik_scientist/index', $data);
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

        return view('institution/balik_scientist/create', [
            'institutions' => $institutions
        ]);
    }

    public function store()
{
    $db = \Config\Database::connect();
    $timestamp = date('Y-m-d H:i:s');

    // Insert new person record
    $personData = [
        'honorifics' => $this->request->getPost('honorifics'),
        'first_name' => $this->request->getPost('first_name'),
        'middle_name' => $this->request->getPost('middle_name'),
        'last_name' => $this->request->getPost('last_name'),
        'role' => $this->request->getPost('role'),
        'created_at' => $timestamp,
        'updated_at' => $timestamp
    ];

    $db->table('persons')->insert($personData);
    $person_id = $db->insertID(); // Get the last inserted person_id

    // Handle file upload for image
    $imageFile = $this->request->getFile('image');
    $imagePath = null;

    if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
        $newName = $imageFile->getRandomName();
        $imageFile->move('uploads/balik_scientists', $newName);
        $imagePath = 'uploads/balik_scientists/' . $newName;
    }

    // Get selected memberships
    $selectedMemberships = $this->request->getPost('dynamic_choice');

    if (!empty($selectedMemberships)) {
        foreach ($selectedMemberships as $membership) {
            $institutionField = "institution_" . str_replace(' ', '_', $membership); // Matching input name
            $institutionId = $this->request->getPost($institutionField);

            if ($membership === "Balik Scientist") {
                $scientistData = [
                    'institution_id' => $institutionId,
                    'person_id' => $person_id,
                    'description' => $this->request->getPost('description'),
                    'image' => $imagePath,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];
                $db->table('balik_scientist_engaged')->insert($scientistData);
            } elseif ($membership === "NRCP") {
                $ncrpData = [
                    'institution_id' => $institutionId,
                    'person_id' => $person_id,
                    'description' => $this->request->getPost('description'),
                    'image' => $imagePath,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];
                $db->table('nrcp_members')->insert($ncrpData); // Assuming you have a table for NCRP members
            }
        }
    }

    return redirect()->to('/institution/balik_scientist/index')->with('success', 'Scientist added successfully!');
}

    public function edit($id)
    {
        $db = \Config\Database::connect();

        $scientist = $db->table('balik_scientist_engaged bse')
            ->select('bse.id, bse.description, bse.image, 
                      i.id as institution_id, s.name as institution_name, 
                      p.id as person_id, p.honorifics, p.first_name, p.middle_name, p.last_name, p.role')
            ->join('institutions i', 'i.id = bse.institution_id', 'left')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->join('persons p', 'p.id = bse.person_id', 'left')
            ->where('bse.id', $id)
            ->get()
            ->getRowArray();

        if (!$scientist) {
            return redirect()->to('/institution/balik_scientist')->with('error', 'Scientist not found.');
        }

        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->get()
            ->getResult();

        return view('institution/balik_scientist/edit', [
            'scientist' => $scientist, 
            'institutions' => $institutions
        ]);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Fetch existing scientist data
        $existingScientist = $db->table('balik_scientist_engaged')->where('id', $id)->get()->getRowArray();
        if (!$existingScientist) {
            return redirect()->to('/institution/balik_scientist')->with('error', 'Scientist not found.');
        }

        // Update persons table
        $personData = [
            'honorifics' => $this->request->getPost('honorifics'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'role' => $this->request->getPost('role'),
            'updated_at' => $timestamp
        ];
        $db->table('persons')->where('id', $existingScientist['person_id'])->update($personData);

        // Handle file upload
        $imageFile = $this->request->getFile('image');
        $imagePath = $existingScientist['image']; // Keep existing image if not changed

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move('uploads/balik_scientists', $newName);
            $imagePath = 'uploads/balik_scientists/' . $newName;
        }

        // Update scientist record
        $scientistData = [
            'institution_id' => $this->request->getPost('institution'),
            'description' => $this->request->getPost('description'),
            'image' => $imagePath,
            'updated_at' => $timestamp
        ];
        $db->table('balik_scientist_engaged')->where('id', $id)->update($scientistData);

        return redirect()->to('/institution/balik_scientist/index')->with('success', 'Scientist updated successfully.');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();

        $scientist = $db->table('balik_scientist_engaged')->where('id', $id)->get()->getRowArray();
        if (!$scientist) {
            return redirect()->to('/institution/balik_scientist')->with('error', 'Scientist not found.');
        }

        $db->table('balik_scientist_engaged')->where('id', $id)->delete();
        return redirect()->to('/institution/balik_scientist/index')->with('success', 'Scientist deleted successfully.');
    }

    public function view($id)
    {
        $db = \Config\Database::connect();

        $scientist = $db->table('balik_scientist_engaged bse')
            ->select('bse.id, bse.description, bse.image, 
                      i.id as institution_id, s.name as institution_name, i.image as institution_image,
                      p.honorifics, p.first_name, p.middle_name, p.last_name, p.role')
            ->join('institutions i', 'i.id = bse.institution_id', 'left')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->join('persons p', 'p.id = bse.person_id', 'left')
            ->where('bse.id', $id)
            ->get()
            ->getRowArray();

        return view('institution/balik_scientist/view', ['scientist' => $scientist]);
    }
}
