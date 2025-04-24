<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;
use App\Models\RegionalOfficeModel;

class RegionalOfficeController extends BaseController
{

    public function regionalOffices()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                s.id AS stakeholder_id,  -- Ensure this is included
                s.name AS regional_office,
                p.honorifics AS hon,
                p.first_name,
                p.last_name,
                p.designation,
                p.position AS position,
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
            'position' => $this->request->getPost('position'),
            // 'role' => $this->request->getPost('position'),
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
    public function regionalOfficesCreate()
    {
        return view('directory/regional_offices/create');
    }

    public function regionalOfficesEdit($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                s.id AS stakeholder_id,
                s.name AS regional_office,
                s.street,
                s.barangay,
                s.municipality,
                s.province,
                s.country,
                s.postal_code,
                p.id AS person_id,
                p.honorifics AS hon,
                p.first_name,
                p.last_name,
                p.designation,
                p.position,
                c.telephone_num,
                c.email_address
            FROM stakeholders s
            JOIN stakeholder_members sm ON s.id = sm.stakeholder_id
            JOIN persons p ON sm.person_id = p.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.id = ?", [$id]);

        $regional_office = $query->getRow();

        if (!$regional_office) {
            return redirect()->to('/directory/regional_offices')->with('error', 'Regional Office not found.');
        }

        return view('directory/regional_offices/edit', ['regional_office' => $regional_office]);
    }

    public function regionalOfficesUpdate($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        $stakeholderData = [
            'name' => $this->request->getPost('regional_office'),
            'street' => $this->request->getPost('street'),
            'barangay' => $this->request->getPost('barangay'),
            'municipality' => $this->request->getPost('municipality'),
            'province' => $this->request->getPost('province'),
            'country' => $this->request->getPost('country'),
            'postal_code' => $this->request->getPost('postal_code'),
            'updated_at' => $timestamp
        ];
        $db->table('stakeholders')->where('id', $id)->update($stakeholderData);

        $personId = $this->request->getPost('person_id');
        $personData = [
            'honorifics' => $this->request->getPost('hon'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'designation' => $this->request->getPost('designation'),
            'position' => $this->request->getPost('position'),
            'updated_at' => $timestamp
        ];
        $db->table('persons')->where('id', $personId)->update($personData);

        $contactData = [
            'telephone_num' => $this->request->getPost('telephone_num'),
            'email_address' => $this->request->getPost('email_address'),
            'updated_at' => $timestamp
        ];
        $db->table('contact_details')->where('person_id', $personId)->update($contactData);

        return redirect()->to('/directory/regional_offices')->with('success', 'Regional Office updated successfully!');
    }

    public function regionalOfficesDelete($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
        SELECT p.id AS person_id 
        FROM stakeholders s
        JOIN stakeholder_members sm ON s.id = sm.stakeholder_id
        JOIN persons p ON sm.person_id = p.id
        WHERE s.id = ?", [$id]);

        $result = $query->getRow();

        if (!$result) {
            return redirect()->to('/directory/regional_offices')->with('error', 'Regional Office not found.');
        }

        $personId = $result->person_id;

        $db->transStart();

        $db->table('contact_details')->where('person_id', $personId)->delete();

        $db->table('stakeholder_members')->where('stakeholder_id', $id)->delete();

        $db->table('persons')->where('id', $personId)->delete();

        $db->table('stakeholders')->where('id', $id)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/directory/regional_offices')->with('error', 'Failed to delete Regional Office.');
        }

        return redirect()->to('/directory/regional_offices')->with('success', 'Regional Office deleted successfully!');
    }
    public function regionalOfficesView($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                s.id AS stakeholder_id,
                s.name AS regional_office,
                p.honorifics AS hon,
                p.first_name,
                p.last_name,
                p.designation,
                p.position AS position,
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
            WHERE s.id = ?
        ", [$id]);

        $data['office'] = $query->getRow();

        if (!$data['office']) {
            return redirect()->to('/directory/regional_offices')->with('error', 'Regional Office not found.');
        }

        return view('directory/regional_offices/view', $data);
    }

    public function save_contact()
    {
        $model = new RegionalOfficeModel();
        $request = service('request');

        $validationRules = [
            'stakeholder_id' => 'required|integer',
            'telephone_num' => 'required|min_length[7]',
            'email_address' => 'required|valid_email'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'stakeholder_id' => $request->getPost('stakeholder_id'),
            'telephone_num' => $request->getPost('telephone_num'),
            'email_address' => $request->getPost('email_address')
        ];

        $model->insert($data);

        return redirect()->to('/directory/regional_offices')->with('success', 'Contact details added successfully.');
    }
    public function export()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
        SELECT 
            s.name AS regional_office,
            p.honorifics AS hon,
            p.first_name,
            p.last_name,
            p.position AS position,
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

        // p.designation

        $regional_offices = $query->getResult();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="regional_offices.csv"');

        $output = fopen('php://output', 'w');

        fputcsv($output, [
            'Regional Office',
            'Honorifics',
            'First Name',
            'Last Name',
            // 'Designation',
            'Position',
            'Office Address',
            'Telephone Number',
            'Email Address'
        ]);

        foreach ($regional_offices as $office) {
            fputcsv($output, [
                $office->regional_office ?? '',
                $office->hon ?? '',
                $office->first_name ?? '',
                $office->last_name ?? '',
                // $office->designation ?? '',
                $office->position ?? '',
                $office->office_address ?? '',
                $office->telephone_num ?? '',
                $office->email_address ?? ''
            ]);
        }

        fclose($output);
        exit;
    }

}

