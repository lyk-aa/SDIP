<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;

class RegionalOfficeController extends BaseController
{

    public function regionalOffices()
    {
        $data['child_page'] = 'Regional Offices';
        
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                s.id AS stakeholder_id,  -- Ensure this is included
                s.name AS regional_office,
                p.honorifics AS hon,
                p.first_name,
                p.last_name,
                p.designation,
                p.role AS position,
                CONCAT_WS(', ', 
                    s.street, 
                    s.barangay, 
                    s.municipality, 
                    s.province, 
                    s.country, 
                    s.postal_code
                ) AS office_address,
                c.telephone_num,
                c.email_address
            FROM stakeholder_members sm
            JOIN persons p ON sm.person_id = p.id
            JOIN stakeholders s ON sm.stakeholder_id = s.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.category = 'Regional Office'
        ");

        $data['regional_offices'] = $query->getResult();

        return view('directory/regional_offices/index', $data);
    }
    public function regionalOfficesCreate()
    {
        return view('directory/regional_offices/create');
    }
    public function regionalOfficesStore()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'name' => $this->request->getPost('regional_office'),
            'street' => $this->request->getPost('street'),
            'barangay' => $this->request->getPost('barangay'),
            'municipality' => $this->request->getPost('municipality'),
            'province' => $this->request->getPost('province'),
            'country' => $this->request->getPost('country'),
            'postal_code' => $this->request->getPost('postal_code'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('stakeholders')->insert($data);
        $stakeholderId = $db->insertID();

        $personData = [
            'honorifics' => $this->request->getPost('hon'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'designation' => $this->request->getPost('designation'),
            'role' => $this->request->getPost('position'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('persons')->insert($personData);
        $personId = $db->insertID();

        $db->table('stakeholder_members')->insert([
            'stakeholder_id' => $stakeholderId,
            'person_id' => $personId,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ]);

        $contactData = [
            'person_id' => $personId,
            'telephone_num' => $this->request->getPost('telephone_num'),
            'email_address' => $this->request->getPost('email_address'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('contact_details')->insert($contactData);

        return redirect()->to('/directory/regional_offices')->with('success', 'Regional Office added successfully!');
    }
    public function deleteRegionalOffice($id)
    {
        $db = \Config\Database::connect();

        $db->table('stakeholder_members')->where('stakeholder_id', $id)->delete();
        $db->table('stakeholders')->where('id', $id)->delete();

        return redirect()->to('/directory/regional_offices')->with('success', 'Regional Office deleted successfully!');
    }

    public function regionalOfficesEdit($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                s.id AS stakeholder_id,
                s.name AS regional_office,
                s.street, s.barangay, s.municipality, s.province, s.country, s.postal_code,
                p.id AS person_id,
                p.honorifics, p.first_name, p.last_name, p.designation, p.role AS position,
                c.telephone_num, c.email_address
            FROM stakeholders s
            LEFT JOIN stakeholder_members sm ON s.id = sm.stakeholder_id
            LEFT JOIN persons p ON sm.person_id = p.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.id = ?", [$id]);

        $regionalOffice = $query->getRow();

        if (!$regionalOffice) {
            return redirect()->to('/directory/regional_offices')->with('error', 'Regional Office not found.');
        }

        return view('directory/regional_offices/edit', ['regionalOffice' => $regionalOffice]);
    }
    public function regionalOfficesUpdate($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'name' => $this->request->getPost('regional_office'),
            'street' => $this->request->getPost('street'),
            'barangay' => $this->request->getPost('barangay'),
            'municipality' => $this->request->getPost('municipality'),
            'province' => $this->request->getPost('province'),
            'country' => $this->request->getPost('country'),
            'postal_code' => $this->request->getPost('postal_code'),
            'updated_at' => $timestamp
        ];
        $db->table('stakeholders')->update($data, ['id' => $id]);

        $personData = [
            'honorifics' => $this->request->getPost('honorifics'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'designation' => $this->request->getPost('designation'),
            'role' => $this->request->getPost('position'),
            'updated_at' => $timestamp
        ];
        $db->table('persons')->update($personData, ['id' => $this->request->getPost('person_id')]);

        $contactData = [
            'telephone_num' => $this->request->getPost('telephone_num'),
            'email_address' => $this->request->getPost('email_address'),
            'updated_at' => $timestamp
        ];
        $db->table('contact_details')->update($contactData, ['person_id' => $this->request->getPost('person_id')]);

        return redirect()->to('/directory/regional_offices')->with('success', 'Regional Office updated successfully.');
    }
}

