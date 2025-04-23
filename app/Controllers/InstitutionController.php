<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Controller;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;

class InstitutionController extends BaseController
{
    // Home - Display all active institutions
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('institutions');

        // Select required columns from institutions and stakeholders tables
        $builder->select('
        institutions.id, institutions.image, institutions.type, 
        stakeholders.name, stakeholders.abbreviation, 
        stakeholders.street, stakeholders.barangay, 
        stakeholders.municipality, stakeholders.province
        ');

        // Join the stakeholders table to get related information
        $builder->join('stakeholders', 'stakeholders.id = institutions.stakeholder_id');

        // Filter only active institutions
        $builder->where('institutions.status', 'active');

        // Sort institutions alphabetically by stakeholder (institution) name
        $builder->orderBy('stakeholders.name', 'ASC');

        // Execute the query and pass the result to the view
        $data['institutions'] = $builder->get()->getResultArray();

        return view('institution/home', $data);
    }

    // Show form for creating a new institution
    public function create_institution()
    {
        $db = \Config\Database::connect();
        // Get stakeholders from the "Academe" category for selection
        $stakeholders = $db->table('stakeholders')
            ->where('category', 'Academe')
            ->get()
            ->getResultArray();

        // Return the view with the stakeholders for selection
        return view('institution/create', ['stakeholders' => $stakeholders]);
    }

    // Check if the institution already exists based on the stakeholder ID
    public function checkInstitutionExists($stakeholder_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('institutions');
        $builder->where('stakeholder_id', $stakeholder_id);

        // Check if an institution with this stakeholder ID already exists
        $query = $builder->get();
        $exists = $query->getNumRows() > 0;

        // Return appropriate message based on the result
        if ($exists) {
            return ['exists' => true, 'message' => 'This institution is already stored.'];
        }
        return ['exists' => false, 'message' => ''];
    }

    // Fetch details of a specific stakeholder
    public function getStakeholderDetails($stakeholderId)
    {
        $db = \Config\Database::connect();

        // Get the stakeholder information
        $stakeholder = $db->table('stakeholders')
            ->where('id', $stakeholderId)
            ->get()
            ->getRowArray();

        // If the stakeholder does not exist, return empty JSON
        if (!$stakeholder) {
            return $this->response->setJSON([]);
        }

        // Get the associated person for the stakeholder
        $person = $db->table('persons')
            ->select('persons.id as person_id, persons.honorifics, persons.first_name, persons.middle_name, persons.last_name, persons.designation')
            ->join('stakeholder_members', 'stakeholder_members.person_id = persons.id')
            ->where('stakeholder_members.stakeholder_id', $stakeholderId)
            ->get()
            ->getRowArray();

        // If no person is associated, return empty JSON
        if (!$person) {
            return $this->response->setJSON([]);
        }

        // Get contact details for the person
        $contactDetails = $db->table('contact_details')
            ->select('telephone_num, email_address')
            ->where('person_id', $person['person_id'])
            ->get()
            ->getRowArray();

        // Merge and return stakeholder, person, and contact details
        return $this->response->setJSON(array_merge($stakeholder, $person, $contactDetails ?? []));
    }

    // Store a new institution (including image upload)
    public function storeInstitution()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Get stakeholder ID from the form submission
        $stakeholderId = $this->request->getPost('stakeholder_id');

        // Check if the institution already exists for the given stakeholder
        $existingInstitution = $db->table('institutions')
            ->where('stakeholder_id', $stakeholderId)
            ->get()
            ->getRowArray();

        // If the institution exists, reactivate or return an error
        if ($existingInstitution) {
            if ($existingInstitution['status'] === 'inactive') {
                $updateData = [
                    'status' => 'active',
                    'updated_at' => $timestamp,
                ];
                $db->table('institutions')
                    ->where('stakeholder_id', $stakeholderId)
                    ->update($updateData);

                return redirect()->to('/institution/home')->with('institution-success', 'Institution added successfully!');
            } else {
                return redirect()->to('/institution/home')->with('institution-error', 'Institution already exists!');
            }
        }

        // Handle image upload if a file is provided
        $image = $this->request->getFile('image');
        $imagePath = null;

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/institutions', $newName);
            $imagePath = 'uploads/institutions/' . $newName;
        }

        // Insert the new institution record
        $institutionData = [
            'type' => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'stakeholder_id' => $stakeholderId,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'image' => $imagePath,
            'status' => 'active' // Set the institution as active by default
        ];
        $db->table('institutions')->insert($institutionData);

        return redirect()->to('/institution/home')->with('institution-success', 'Institution added successfully!');
    }

    // Show form for editing an existing institution
    public function edit($id)
    {
        $db = \Config\Database::connect();

        // Fetch the institution's details from the database
        $institution = $db->table('institutions as i')
            ->select('i.id as institution_id, i.type, i.image, i.description,
                  s.id as stakeholder_id, s.name')
            ->join('stakeholders as s', 's.id = i.stakeholder_id', 'left')
            ->where('i.id', $id)
            ->get()
            ->getRowArray();

        // If no institution found, redirect with an error message
        if (!$institution) {
            return redirect()->to('/institution/home')->with('institution-error', 'Institution not found.');
        }

        // Return the view with the institution's data
        return view('institution/edit', ['institution' => $institution]);
    }

    // Update institution details
    public function update($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Fetch the institution's current details
        $institution = $db->table('institutions')->where('id', $id)->get()->getRowArray();
        if (!$institution) {
            return redirect()->to('/institution/home')->with('institution-error', 'Institution not found!');
        }

        // Handle image update if a new image is provided
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete the old image if it exists
            $oldImage = $institution['image'];
            if (!empty($oldImage) && file_exists($oldImage)) {
                unlink($oldImage);
            }

            // Upload the new image
            $newName = $image->getRandomName();
            $image->move('uploads/institutions', $newName);
            $imagePath = 'uploads/institutions/' . $newName;

            // Update image path in the database
            $db->table('institutions')->where('id', $id)->update(['image' => $imagePath]);
        }

        // Update the institution's other details
        $db->table('institutions')->where('id', $id)->update([
            'type' => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'updated_at' => $timestamp
        ]);

        return redirect()->to('/institution/home')->with('institution-success', 'Institution updated successfully!');
    }

    // Mark an institution as inactive (soft delete)
    public function delete($id)
    {
        $db = \Config\Database::connect();

        // Ensure the institution ID is numeric
        if (!is_numeric($id)) {
            return redirect()->to('/institution/home')->with('institution-error', 'Invalid Institution ID');
        }

        // Fetch the institution to confirm its existence
        $institution = $db->table('institutions')->where('id', $id)->get()->getRowArray();

        // If no institution found, return an error message
        if (!$institution) {
            return redirect()->to('/institution/home')->with('institution-error', 'Institution not found!');
        }

        // Mark the institution as inactive (soft delete)
        $db->table('institutions')->where('id', $id)->update(['status' => 'inactive']);

        return redirect()->to('/institution/home')->with('institution-success', 'Institution succesfully deleted!');
    }

    // View detailed information for a specific institution
    public function view($id)
    {
        $db = \Config\Database::connect();

        // Fetch detailed information for the institution
        $institution = $db->table('institutions as i')
            ->select('i.id as institution_id, i.type, i.image, 
              s.id as stakeholder_id, s.name, s.abbreviation, 
              s.street, s.barangay, s.municipality, s.province, s.country,
              p.id as person_id, CONCAT(p.honorifics, " ", p.first_name, " ", p.middle_name, " ", p.last_name) as person_name, p.designation,
              c.id as contact_id, c.telephone_num, c.email_address')
            ->join('stakeholders as s', 's.id = i.stakeholder_id', 'left')
            ->join('stakeholder_members as sm', 'sm.stakeholder_id = s.id', 'left')
            ->join('persons as p', 'p.id = sm.person_id', 'left')
            ->join('contact_details as c', 'c.person_id = p.id', 'left')
            ->where('i.id', $id)
            ->get()
            ->getRowArray();

        // Fetch associated NRC members, Balik Scientists, consortiums, and research projects
        $nrcp_members = $db->table('nrcp_members as nrcp')
            ->select('p.id, p.honorifics, p.first_name, p.middle_name, p.last_name')
            ->join('persons as p', 'p.id = nrcp.person_id', 'left')
            ->where('nrcp.institution_id', $id)
            ->get()
            ->getResultArray();

        $balik_scientists = $db->table('balik_scientist_engaged as bse')
            ->select('p.id, p.honorifics, p.first_name, p.middle_name, p.last_name')
            ->join('persons as p', 'p.id = bse.person_id', 'left')
            ->where('bse.institution_id', $id)
            ->get()
            ->getResultArray();

        $consortiums = $db->table('consortium_members as cm')
            ->select('con.name as consortium_name')
            ->join('consortiums as con', 'con.id = cm.consortium_id', 'left')
            ->where('cm.institution_id', $id)
            ->get()
            ->getResultArray();

        // Fetch completed and ongoing research projects
        $completed_research_projects = $db->table('research_projects as rp')
            ->select('rp.name as research_project_name, rp.description, rp.status, rp.sector, rp.project_objectives, rp.duration, rp.project_leader, rp.approved_amount')
            ->where('rp.institution_id', $id)
            ->where('rp.status', 'Completed')
            ->get()
            ->getResultArray();

        $ongoing_research_projects = $db->table('research_projects as rp')
            ->select('rp.name as research_project_name, rp.description, rp.status, rp.sector, rp.project_objectives, rp.duration, rp.project_leader, rp.approved_amount')
            ->where('rp.institution_id', $id)
            ->where('rp.status', 'Ongoing')
            ->get()
            ->getResultArray();

        // If the institution does not exist, return an error
        if (!$institution) {
            return redirect()->to('/institution/home')->with('institution-error', 'Institution not found.');
        }

        // Return the view with all the institution's details
        return view('institution/details', [
            'institution' => $institution,
            'nrcp_members' => $nrcp_members,
            'balik_scientists' => $balik_scientists,
            'consortiums' => $consortiums,
            'completed_research_projects' => $completed_research_projects,
            'ongoing_research_projects' => $ongoing_research_projects
        ]);
    }

    // Search institutions based on a query
    public function search()
    {
        $query = $this->request->getGet('query');

        // If no query, return empty JSON
        if (!$query) {
            return $this->response->setJSON([]);
        }

        $db = \Config\Database::connect();

        $builder = $db->table('institutions as i');
        $builder->select('i.id, s.name, s.abbreviation, s.street, s.barangay, s.municipality, s.province, i.image');
        $builder->join('stakeholders as s', 's.id = i.stakeholder_id', 'left');
        $builder->groupStart()
            ->like('s.name', $query)
            ->orLike('s.abbreviation', $query)
            ->orLike('s.street', $query)
            ->orLike('s.barangay', $query)
            ->orLike('s.municipality', $query)
            ->orLike('s.province', $query)
            ->groupEnd();
        $builder->where('i.status', 'active');
        $builder->orderBy('s.name', 'ASC');

        // Execute the query and return results
        return $this->response->setJSON($builder->get()->getResultArray());
    }
}
