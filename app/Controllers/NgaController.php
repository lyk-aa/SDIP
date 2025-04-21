<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class NgaController extends BaseController
{
    public function nga()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
        SELECT 
            s.id AS office_id,
            s.name AS name_of_office,
            p.salutation AS salutation,
            p.honorifics AS honorifics,
            p.first_name,
            p.last_name,
            CONCAT(p.first_name, ' ', p.last_name) AS head_of_office,
            CONCAT_WS(', ', 
                s.street, 
                s.barangay, 
                s.municipality, 
                s.province, 
                s.country, 
                s.postal_code
            ) AS address,
            c.telephone_num AS telephone,
            c.fax_num AS fax,
            c.email_address AS email,
            c.mobile_num AS mobile_num
        FROM stakeholders s
        JOIN stakeholder_members sm ON s.id = sm.stakeholder_id
        JOIN persons p ON sm.person_id = p.id
        LEFT JOIN contact_details c ON c.person_id = p.id
        WHERE s.category = 'NGA'
    ");

        $data['ngas'] = $query->getResult();

        return view('directory/nga/index', $data);
    }

    public function ngaCreate()
    {
        return view('directory/nga/create');
    }
    
    public function ngaStore()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Insert NGA Office
        $data = [
            'name' => $this->request->getPost('name_of_office'),
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
        $db->table('stakeholders')->insert($data);
        $stakeholderId = $db->insertID();

        // Insert Person (Head of Office)
        $personData = [
            'salutation' => $this->request->getPost('salutation'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('persons')->insert($personData);
        $personId = $db->insertID();

        // Link Office to Head Person
        $db->table('stakeholder_members')->insert([
            'stakeholder_id' => $stakeholderId,
            'person_id' => $personId,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ]);

        // Insert Contact Details
        $contactData = [
            'person_id' => $personId,
            'telephone_num' => $this->request->getPost('telephone'),
            'fax_num' => $this->request->getPost('fax'),
            'email_address' => $this->request->getPost('email_address'),
            'mobile_num' => $this->request->getPost('mobile_number'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('contact_details')->insert($contactData);

        return redirect()->to('/directory/nga')->with('success', 'NGA Office added successfully!');
    }
}

