<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;


class AcademeController extends BaseController
{
    public function academes()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                s.id AS stakeholder_id,
                s.abbreviation,
                s.name AS academe_name,
                p.first_name,
                p.middle_name,
                p.last_name,
                p.designation,
                CONCAT_WS(', ', 
                    s.street, 
                    s.barangay, 
                    s.municipality, 
                    s.province, 
                    s.country, 
                    s.postal_code
                ) AS address,
                c.fax_num,
                c.telephone_num,
                c.mobile_num,
                c.email_address
            FROM stakeholder_members sm
            JOIN persons p ON sm.person_id = p.id
            JOIN stakeholders s ON sm.stakeholder_id = s.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.category = 'Academe'
        ");

        $data['academes'] = $query->getResult();

        return view('directory/academes/index', $data);
    }
    public function create()
    {
        return view('directory/academes/create');
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'abbreviation' => $this->request->getPost('abbreviation'),
            'name' => $this->request->getPost('name'),
            'category' => 'Academe',
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
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'designation' => $this->request->getPost('designation'),
            'position' => $this->request->getPost('position'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];

        if (empty($personData['first_name']) || empty($personData['last_name'])) {
            return redirect()->back()->withInput()->with('error', 'Head of Office details are required.');
        }

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
            'fax_num' => $this->request->getPost('fax_num'),
            'mobile_num' => $this->request->getPost('mobile_num'),
            'email_address' => $this->request->getPost('email_address'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('contact_details')->insert($contactData);

        return redirect()->to('/directory/academes')->with('success', 'Academe added successfully.');
    }


    public function edit($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                s.id AS stakeholder_id,  -- Ensure ID is selected
                s.abbreviation,
                s.name AS academe_name,
                s.street,
                s.barangay,
                s.municipality,
                s.province,
                s.country,
                s.postal_code,
                p.id AS person_id,  -- Ensure ID is selected from persons table
                p.first_name,
                p.middle_name,
                p.last_name,
                p.designation,
                c.fax_num,
                c.telephone_num,
                c.mobile_num,
                c.email_address
            FROM stakeholders s
            LEFT JOIN stakeholder_members sm ON sm.stakeholder_id = s.id
            LEFT JOIN persons p ON sm.person_id = p.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.id = ?", [$id]);

        $data['academe'] = $query->getRow();

        if (!$data['academe']) {
            return redirect()->to('/directory/academes')->with('error', 'Academe not found.');
        }

        return view('directory/academes/edit', $data);
    }


    public function update($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('stakeholders');

        $data = [
            'abbreviation' => $this->request->getPost('abbreviation'),
            'name' => $this->request->getPost('name'),
            'street' => $this->request->getPost('street'),
            'barangay' => $this->request->getPost('barangay'),
            'municipality' => $this->request->getPost('municipality'),
            'province' => $this->request->getPost('province'),
            'country' => $this->request->getPost('country'),
            'postal_code' => $this->request->getPost('postal_code'),
        ];

        $builder->where('id', $id)->update($data);

        return redirect()->to('/directory/academes')->with('success', 'Academe updated successfully.');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('stakeholders');

        $builder->where('id', $id)->delete();

        return redirect()->to('/directory/academes')->with('success', 'Academe deleted successfully.');
    }
    public function view($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
        SELECT 
            s.id AS stakeholder_id,
            s.abbreviation,
            s.name AS academe_name,
            s.street,
            s.barangay,
            s.municipality,
            s.province,
            s.country,
            s.postal_code,
            p.honorifics,
            p.first_name,
            p.middle_name,
            p.last_name,
            p.designation,
            p.position,
            c.fax_num,
            c.telephone_num,
            c.mobile_num,
            c.email_address
        FROM stakeholders s
        LEFT JOIN stakeholder_members sm ON sm.stakeholder_id = s.id
        LEFT JOIN persons p ON sm.person_id = p.id
        LEFT JOIN contact_details c ON c.person_id = p.id
        WHERE s.id = ?", [$id]);

        $data['academe'] = $query->getRow();

        if (!$data['academe']) {
            return redirect()->to('/directory/academes')->with('error', 'Academe not found.');
        }

        return view('directory/academes/view', $data);
    }
    public function export()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
    SELECT 
        s.abbreviation,
        s.name AS academe_name,
        p.designation,
        p.first_name,
        p.middle_name,
        p.last_name,
        CONCAT_WS(', ', 
            s.street, 
            s.barangay, 
            s.municipality, 
            s.province, 
            s.country, 
            s.postal_code
        ) AS address,
        c.fax_num,
        c.telephone_num,
        c.mobile_num,
        c.email_address
    FROM stakeholder_members sm
    JOIN persons p ON sm.person_id = p.id
    JOIN stakeholders s ON sm.stakeholder_id = s.id
    LEFT JOIN contact_details c ON c.person_id = p.id
    WHERE s.category = 'Academe'
    ");

        $academes = $query->getResultArray();

        $filename = 'academes_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        fputcsv($output, [
            'Abbreviation',
            'Name',
            'Designation',
            'First Name',
            'Middle Name',
            'Last Name',
            'Address',
            'Fax',
            'Telephone',
            'Mobile',
            'Email'
        ]);

        foreach ($academes as $row) {
            fputcsv($output, [
                $row['abbreviation'] ?? 'N/A',
                $row['academe_name'] ?? 'N/A',
                $row['designation'] ?? 'N/A',
                $row['first_name'] ?? 'N/A',
                $row['middle_name'] ?? 'N/A',
                $row['last_name'] ?? 'N/A',
                $row['address'] ?? 'N/A',
                $row['fax_num'] ?? 'N/A',
                $row['telephone_num'] ?? 'N/A',
                $row['mobile_num'] ?? 'N/A',
                $row['email_address'] ?? 'N/A'
            ]);
        }

        fclose($output);
        exit;
    }



}

