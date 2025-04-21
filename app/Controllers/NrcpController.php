<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class NrcpController extends BaseController
{
    // Display the list of NRCP members
    public function nrcp_members()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('nrcp_members nrcp');
        $builder->select('
            nrcp.id, 
            nrcp.description, 
            nrcp.image, 
            i.id as institution_id, 
            s.name as institution_name, 
            p.id as person_id, 
            p.honorifics, 
            p.first_name, 
            p.middle_name, 
            p.last_name, 
            p.role
        ');
        $builder->join('institutions i', 'i.id = nrcp.institution_id', 'left');
        $builder->join('stakeholders s', 's.id = i.stakeholder_id', 'left');
        $builder->join('persons p', 'p.id = nrcp.person_id', 'left');
        $builder->where('i.status', 'active');

        // Fetch and return the data to the view
        $data['nrcp_members'] = $builder->get()->getResultArray();
        
        return view('/institution/nrcp_members/index', $data);
    }

    // Show the form to create a new NRCP member
    public function create()
    {
        $db = \Config\Database::connect();

        // Fetch active institutions for selection
        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        // Pass institutions data to the view
        return view('institution/nrcp_members/create', [
            'institutions' => $institutions
        ]);
    }

    // Store a new NRCP member in the database
    public function store()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Collect person data from the request
        $personData = [
            'honorifics' => $this->request->getPost('honorifics'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'role' => $this->request->getPost('role'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        // Check if the person already exists
        $existingPerson = $db->table('persons')
            ->where('first_name', $personData['first_name'])
            ->where('middle_name', $personData['middle_name'])
            ->where('last_name', $personData['last_name'])
            ->get()
            ->getRow();

        if ($existingPerson) {
            return redirect()->back()->with('error', 'Person already exists.');
        }

        // Insert the new person
        $db->table('persons')->insert($personData);
        $person_id = $db->insertID(); // Get the last inserted person_id

        // Handle image upload if provided
        $imageFile = $this->request->getFile('image');
        $imagePath = null;

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move('uploads/balik_scientists', $newName);
            $imagePath = 'uploads/balik_scientists/' . $newName;
        }

        // Process the selected memberships
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

                // Insert data into the respective table based on membership type
                if ($membership === "Balik Scientist") {
                    $db->table('balik_scientist_engaged')->insert($commonData);
                } elseif ($membership === "NRCP") {
                    $db->table('nrcp_members')->insert($commonData);
                }
            }
        }

        return redirect()->to('/institution/nrcp_members/index')->with('success', 'NRCP added successfully!');
    }

    // Delete an NRCP member by their ID
    public function delete($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('nrcp_members');
        $builder->where('id', $id);
        $builder->delete();

        return redirect()->to('/institution/nrcp_members/index')->with('success', 'NRCP deleted successfully!');
    }

    // View details of an individual NRCP member
    public function view($id)
    {
        $db = \Config\Database::connect();

        $nrcp = $db->table('nrcp_members nrcp')
            ->select('nrcp.id, nrcp.description, nrcp.image, 
                  i.id as institution_id, s.name as institution_name, i.image as institution_image,
                  p.honorifics, p.first_name, p.middle_name, p.last_name, p.role')
            ->join('institutions i', 'i.id = nrcp.institution_id', 'left')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->join('persons p', 'p.id = nrcp.person_id', 'left')
            ->where('nrcp.id', $id)
            ->get()
            ->getRowArray();

        return view('institution/nrcp_members/view', ['nrcp' => $nrcp]);
    }

    // Show the form to edit an existing NRCP member
    public function edit($id)
    {
        $db = \Config\Database::connect();

        $nrcp = $db->table('nrcp_members nrcp')
            ->select('nrcp.id, nrcp.description, nrcp.image, 
                      i.id as institution_id, s.name as institution_name, 
                      p.id as person_id, p.honorifics, p.first_name, p.middle_name, p.last_name, p.role')
            ->join('institutions i', 'i.id = nrcp.institution_id', 'left')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->join('persons p', 'p.id = nrcp.person_id', 'left')
            ->where('nrcp.id', $id)
            ->get()
            ->getRowArray();

        if (!$nrcp) {
            return redirect()->to('/institution/nrcp_members')->with('error', 'NRCP not found.');
        }

        $institutions = $db->table('institutions i')
            ->select('i.id, s.name')
            ->join('stakeholders s', 's.id = i.stakeholder_id', 'left')
            ->where('i.status', 'active')
            ->get()
            ->getResult();

        return view('institution/nrcp_members/edit', [
            'nrcp' => $nrcp,
            'institutions' => $institutions
        ]);
    }

    // Update an existing NRCP member
    public function update($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Fetch the existing NRCP data
        $existingnrcp = $db->table('nrcp_members')->where('id', $id)->get()->getRowArray();
        if (!$existingnrcp) {
            return redirect()->to('/institution/nrcp')->with('error', 'NRCP not found.');
        }

        // Update the person data
        $personData = [
            'honorifics' => $this->request->getPost('honorifics'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'role' => $this->request->getPost('role'),
            'updated_at' => $timestamp
        ];
        $db->table('persons')->where('id', $existingnrcp['person_id'])->update($personData);

        // Handle image upload if provided
        $imageFile = $this->request->getFile('image');
        $imagePath = $existingnrcp['image']; // Keep existing image if not changed

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move('uploads/balik_scientists', $newName);
            $imagePath = 'uploads/balik_scientists/' . $newName;
        }

        // Update the NRCP member record
        $nrcpData = [
            'institution_id' => $this->request->getPost('institution'),
            'description' => $this->request->getPost('description'),
            'image' => $imagePath,
            'updated_at' => $timestamp
        ];
        $db->table('nrcp_members')->where('id', $id)->update($nrcpData);

        return redirect()->to('/institution/nrcp_members/index')->with('success', 'NRCP updated successfully.');
    }

    // Search for NRCP members based on query
    public function search()
    {
        $search = $this->request->getGet('search'); // Get the search query

        $db = \Config\Database::connect();
        $builder = $db->table('nrcp_members bse');
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

        // Apply search filter if query is provided
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

        $data['nrcp_members'] = $builder->get()->getResultArray();

        return view('institution/nrcp_members/index', $data);
    }
}
