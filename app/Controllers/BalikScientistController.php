<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BalikScientistController extends BaseController
{
    // Display list of engaged Balik Scientists with related info
    public function balik_scientist()
    {
        $data['child_page'] = 'Balik Scientists';

        $db = \Config\Database::connect();
        $builder = $db->table('balik_scientist_engaged bse');

        // Select scientist and related institution and person details
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

        // Only show active institutions
        $builder->where('i.status', 'active');

        $data['balik_scientists'] = $builder->get()->getResultArray();

        return view('institution/balik_scientist/index', $data);
    }

    // Show form to create a new Balik Scientist
    public function create()
    {
        $db = \Config\Database::connect();

        // Get active institutions with stakeholder names
        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        return view('institution/balik_scientist/create', [
            'institutions' => $institutions
        ]);
    }

    // Save new Balik Scientist data
    public function store()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Get person data from form
        $personData = [
            'honorifics' => $this->request->getPost('honorifics'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'role' => $this->request->getPost('role'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        // Check if person already exists in the database
        $existingPerson = $db->table('persons')
            ->where('first_name', $personData['first_name'])
            ->where('middle_name', $personData['middle_name'])
            ->where('last_name', $personData['last_name'])
            ->get()
            ->getRow();

        if ($existingPerson) {
            return redirect()->back()->withInput()->with('bs-error', 'This person already exists in the system.');
        }

        // Insert new person into the persons table
        $db->table('persons')->insert($personData);
        $person_id = $db->insertID();

        // Handle image upload if available
        $imageFile = $this->request->getFile('image');
        $imagePath = null;

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move('uploads/balik_scientists', $newName);
            $imagePath = 'uploads/balik_scientists/' . $newName;
        }

        // Save memberships (Balik Scientist or NRCP)
        $selectedMemberships = $this->request->getPost('dynamic_choice');

        if (!empty($selectedMemberships)) {
            foreach ($selectedMemberships as $membership) {
                $institutionField = "institution_" . str_replace(' ', '_', $membership);
                $institutionId = $this->request->getPost($institutionField);

                $commonData = [
                    'institution_id' => $institutionId,
                    'person_id' => $person_id,
                    'description' => $this->request->getPost('description'),
                    'image' => $imagePath,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];

                // Insert into corresponding table
                if ($membership === "Balik Scientist") {
                    $db->table('balik_scientist_engaged')->insert($commonData);
                } elseif ($membership === "NRCP") {
                    $db->table('nrcp_members')->insert($commonData);
                }
            }
        }

        return redirect()->to('/institution/balik_scientist/index')->with('bs-success', 'Scientist added successfully!');
    }

    // Show form to edit an existing Balik Scientist
    public function edit($id)
    {
        $db = \Config\Database::connect();

        // Get existing scientist data
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
            return redirect()->to('/institution/balik_scientist')->with('bs-error', 'Scientist not found.');
        }

        // Get list of active institutions
        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        return view('institution/balik_scientist/edit', [
            'scientist' => $scientist,
            'institutions' => $institutions
        ]);
    }

    // Update Balik Scientist information
    public function update($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Get existing scientist record
        $existingScientist = $db->table('balik_scientist_engaged')->where('id', $id)->get()->getRowArray();
        if (!$existingScientist) {
            return redirect()->to('/institution/balik_scientist')->with('bs-error', 'Scientist not found.');
        }

        // Update person's data
        $personData = [
            'honorifics' => $this->request->getPost('honorifics'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'role' => $this->request->getPost('role'),
            'updated_at' => $timestamp
        ];
        $db->table('persons')->where('id', $existingScientist['person_id'])->update($personData);

        // Handle image update
        $imageFile = $this->request->getFile('image');
        $imagePath = $existingScientist['image'];

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move('uploads/balik_scientists', $newName);
            $imagePath = 'uploads/balik_scientists/' . $newName;
        }

        // Update scientist data
        $scientistData = [
            'institution_id' => $this->request->getPost('institution'),
            'description' => $this->request->getPost('description'),
            'image' => $imagePath,
            'updated_at' => $timestamp
        ];
        $db->table('balik_scientist_engaged')->where('id', $id)->update($scientistData);

        return redirect()->to('/institution/balik_scientist/index')->with('bs-success', 'Scientist updated successfully.');
    }

    // Delete a Balik Scientist
    public function delete($id)
    {
        $db = \Config\Database::connect();

        // Find scientist record
        $scientist = $db->table('balik_scientist_engaged')->where('id', $id)->get()->getRowArray();
        if (!$scientist) {
            return redirect()->to('/institution/balik_scientist')->with('bs-error', 'Scientist not found.');
        }

        // Delete record
        $db->table('balik_scientist_engaged')->where('id', $id)->delete();
        return redirect()->to('/institution/balik_scientist/index')->with('bs-success', 'Scientist deleted successfully.');
    }

    // View detailed information about a Balik Scientist
    public function view($id)
    {
        $db = \Config\Database::connect();

        // Get detailed scientist info including institution and stakeholder
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

    // Search Balik Scientists by name, role, description, or institution
    public function search()
    {
        $search = $this->request->getGet('search'); // Get search query

        $db = \Config\Database::connect();
        $builder = $db->table('balik_scientist_engaged bse');

        // Select scientist with institution and person details
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

        // Filter results based on search input
        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('p.first_name', $search);
            $builder->orLike('p.middle_name', $search);
            $builder->orLike('p.last_name', $search);
            $builder->orLike('s.name', $search);
            $builder->orLike('p.role', $search);
            $builder->orLike('bse.description', $search);
            $builder->groupEnd();
        }

        $data['balik_scientists'] = $builder->get()->getResultArray();

        return view('institution/balik_scientist/index', $data);
    }

    // Print Balik Scientist
    public function printBalikScientist()
    {
        return view('institution/balik_scientist/print_balik_scientist');
    }
}
