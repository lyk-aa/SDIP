<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;
class NgaController extends BaseController
{
    public function nga()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT 
            s.id AS stakeholder_id,
            s.name AS office_name,
            p.honorifics AS salutation,
            CONCAT(COALESCE(p.first_name, ''), ' ', COALESCE(p.middle_name, ''), ' ', COALESCE(p.last_name, '')) AS full_name,
            CONCAT_WS(', ', COALESCE(s.street, ''), COALESCE(s.barangay, ''), COALESCE(s.municipality, ''), COALESCE(s.province, ''), COALESCE(s.country, ''), COALESCE(s.postal_code, '')) AS office_address,
            COALESCE(c.telephone_num, '') AS telephone_num,
            COALESCE(c.fax_num, '') AS fax_num,
            COALESCE(c.email_address, '') AS email_address
            FROM stakeholder_members sm
            JOIN persons p ON sm.person_id = p.id
            JOIN stakeholders s ON sm.stakeholder_id = s.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.category = 'NGA'");

        $result = $query->getResult();

        if (!$result) {
            $data['ngas'] = [];
        } else {
            $data['ngas'] = $result;
        }

        return view('directory/nga/index', $data);
    }

    public function ngaCreate()
    {
        return view('directory/nga/create');
    }

    public function ngaStore()
    {
        $db = \Config\Database::connect();
        $db->transStart();
        $timestamp = date('Y-m-d H:i:s');

        $stakeholderData = [
            'name' => $this->request->getPost('office_name'),
            'street' => $this->request->getPost('street'),
            'barangay' => $this->request->getPost('barangay'),
            'municipality' => $this->request->getPost('municipality'),
            'province' => $this->request->getPost('province'),
            'country' => $this->request->getPost('country'),
            'postal_code' => $this->request->getPost('postal_code'),
            'category' => 'NGA',
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('stakeholders')->insert($stakeholderData);
        $stakeholderId = $db->insertID();

        $personData = [
            'honorifics' => $this->request->getPost('salutation'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
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
            'fax_num' => $this->request->getPost('fax_num'),
            'email_address' => $this->request->getPost('email_address'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('contact_details')->insert($contactData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Failed to add NGA.');
        }

        return redirect()->to('/directory/nga')->with('success', 'NGA added successfully!');
    }

    public function ngaEdit($id)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT 
        s.id AS stakeholder_id,
        s.name AS office_name,
        p.id AS person_id,
        p.honorifics AS salutation,
        COALESCE(p.first_name, '') AS first_name,
        COALESCE(p.middle_name, '') AS middle_name,
        COALESCE(p.last_name, '') AS last_name,
        s.street, s.barangay, s.municipality, s.province, s.country, s.postal_code,
        COALESCE(c.telephone_num, '') AS telephone_num,
        COALESCE(c.fax_num, '') AS fax_num,
        COALESCE(c.email_address, '') AS email_address
        FROM stakeholders s
        LEFT JOIN stakeholder_members sm ON sm.stakeholder_id = s.id
        LEFT JOIN persons p ON sm.person_id = p.id
        LEFT JOIN contact_details c ON c.person_id = p.id
        WHERE s.id = ?", [$id]);

        $data['nga'] = $query->getRow();

        if (!$data['nga']) {
            return redirect()->back()->with('error', 'NGA not found.');
        }

        return view('directory/nga/edit', $data);
    }


    public function ngaUpdate($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        $timestamp = date('Y-m-d H:i:s');

        $db->table('stakeholders')->where('id', $id)->update([
            'name' => $this->request->getPost('office_name'),
            'street' => $this->request->getPost('street'),
            'barangay' => $this->request->getPost('barangay'),
            'municipality' => $this->request->getPost('municipality'),
            'province' => $this->request->getPost('province'),
            'country' => $this->request->getPost('country'),
            'postal_code' => $this->request->getPost('postal_code'),
            'updated_at' => $timestamp
        ]);

        $db->table('persons')->where('id', $this->request->getPost('person_id'))->update([
            'salutation' => $this->request->getPost('salutation'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'updated_at' => $timestamp
        ]);

        $db->table('contact_details')->where('person_id', $this->request->getPost('person_id'))->update([
            'telephone_num' => $this->request->getPost('telephone_num'),
            'fax_num' => $this->request->getPost('fax_num'),
            'email_address' => $this->request->getPost('email_address'),
            'updated_at' => $timestamp
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Failed to update NGA.');
        }

        return redirect()->to('/directory/nga')->with('success', 'NGA updated successfully!');
    }

    public function ngaDelete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $db->table('stakeholder_members')->where('stakeholder_id', $id)->delete();
        $db->table('persons')->where('id', function ($builder) use ($id) {
            $builder->select('person_id')->from('stakeholder_members')->where('stakeholder_id', $id);
        })->delete();
        $db->table('stakeholders')->where('id', $id)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Failed to delete NGA.');
        }

        return redirect()->to('/directory/nga')->with('success', 'NGA deleted successfully!');
    }

    public function view($id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
        SELECT 
            s.id AS stakeholder_id,
            s.name AS office_name,
            p.honorifics AS salutation,
             CONCAT_WS(' ', 
                COALESCE(p.first_name, ''), 
                COALESCE(p.middle_name, ''), 
                COALESCE(p.last_name, '')
            ) AS full_name,
            CONCAT_WS(', ', 
                COALESCE(s.street, ''), 
                COALESCE(s.barangay, ''), 
                COALESCE(s.municipality, ''), 
                COALESCE(s.province, ''), 
                COALESCE(s.country, ''), 
                COALESCE(s.postal_code, '')
            ) AS office_address,
            COALESCE(c.telephone_num, '') AS telephone_num,
            COALESCE(c.fax_num, '') AS fax_num,
            COALESCE(c.email_address, '') AS email_address,
            s.updated_at
        FROM stakeholder_members sm
        JOIN persons p ON sm.person_id = p.id
        JOIN stakeholders s ON sm.stakeholder_id = s.id
        LEFT JOIN contact_details c ON c.person_id = p.id
        WHERE s.id = ?
    ", [$id]);

        $data['nga'] = $query->getRow();

        if (!$data['nga']) {
            return redirect()->to('/directory/nga')->with('error', 'National Government Agency not found.');
        }

        return view('directory/nga/view', $data);
    }
    public function exportCSV()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT 
            s.name AS office_name,
            p.honorifics AS salutation,
            p.first_name,
            p.middle_name,
            p.last_name,
            CONCAT_WS(', ', s.street, s.barangay, s.municipality, s.province, s.country, s.postal_code) AS office_address,
            COALESCE(c.telephone_num, '') AS telephone_num,
            COALESCE(c.fax_num, '') AS fax_num,
            COALESCE(c.email_address, '') AS email_address,
            s.updated_at
            FROM stakeholder_members sm
            JOIN persons p ON sm.person_id = p.id
            JOIN stakeholders s ON sm.stakeholder_id = s.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.category = 'NGA'");

        $filename = "nga_directory_" . date('Ymd_His') . ".csv";
        $filepath = WRITEPATH . "exports/" . $filename;

        helper('filesystem');
        if (!is_dir(WRITEPATH . 'exports')) {
            mkdir(WRITEPATH . 'exports', 0777, true);
        }

        $file = fopen($filepath, 'w');
        fputcsv($file, ['Office Name', 'Salutation', 'First Name', 'Middle Name', 'Last Name', 'Address', 'Telephone', 'Fax', 'Email', 'Last Updated']);

        foreach ($query->getResultArray() as $row) {
            fputcsv($file, [
                $row['office_name'],
                $row['salutation'],
                $row['first_name'],
                $row['middle_name'],
                $row['last_name'],
                $row['office_address'],
                $row['telephone_num'],
                $row['fax_num'],
                $row['email_address'],
                $row['updated_at']
            ]);
        }

        fclose($file);

        return $this->response->download($filepath, null)->setFileName($filename);
    }



}

