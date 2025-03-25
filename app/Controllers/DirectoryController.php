<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;
use App\Models\AcademesModel;


class DirectoryController extends BaseController
{
    public function index()
    {
        $stakeholderModel = new StakeholderModel();
        $stakeholders = $stakeholderModel->findAll();
        return view('/directory/home', ['stakeholders' => $stakeholders]);
    }

    // DIRECTORY //


    // public function regionalOfficesCreate()
    // {
    //     return view('directory/regional_offices/create');
    // }

    // NGA //
    public function nga()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                s.id AS office_id,
                s.name AS name_of_office,
                CONCAT(p.first_name, ' ', p.last_name) AS head_of_office,
                p.honorifics AS salutation,
                CONCAT_WS(', ', 
                    s.street, 
                    s.barangay, +5+
                    s.municipality, 
                    s.province, 
                    s.country, 
                    s.postal_code
                ) AS address,
                c.telephone_num AS telephone,
                c.fax_num AS fax,
                c.email_address AS email,
                c.mobile_num
            FROM stakeholder_members sm
            JOIN persons p ON sm.person_id = p.id
            JOIN stakeholders s ON sm.stakeholder_id = s.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.category = 'NGA'

        ");

        $data['ngas'] = $query->getResult();

        return view('directory/nga/index', $data);
    }

    // Academes //
    public function academes()
    {
        $stakeholdersModel = new StakeholderModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $membersModel = new StakeholderMembersModel();

        $academes = $stakeholdersModel
            ->where('category', 'Academe')
            ->findAll();

        foreach ($academes as &$academe) {
            $members = $membersModel->where('stakeholder_id', $academe['id'])->findAll();

            foreach ($members as &$member) {
                $person = $personsModel->find($member['person_id']);
                if ($person) {
                    $member['person'] = $person;

                    $contact = $contactModel->where('person_id', $person['id'])->first();
                    $member['contact'] = $contact;
                }
            }

            $academe['members'] = $members;
        }

        return view('directory/academes/index', ['academes' => $academes]);
    }

    public function academesStore()
    {
        helper(['form', 'url']);
        $db = \Config\Database::connect();
        $db->transStart();

        $stakeholderModel = new StakeholderModel();
        $personModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $stakeholderMemberModel = new StakeholderMembersModel();

        try {

            $stakeholderData = [
                'name' => $this->request->getPost('name'),
                'abbreviation' => $this->request->getPost('agency'),
                'address' => $this->request->getPost('address'),
                'type' => 'academe',
                'category' => 'academe',
            ];
            $stakeholderModel->insert($stakeholderData);
            $stakeholderId = $stakeholderModel->getInsertID();

            $personData = [
                'salutation' => '',
                'first_name' => $this->request->getPost('head_of_office'),
                'last_name' => '',
                'designation' => $this->request->getPost('designation'),
            ];
            $personModel->insert($personData);
            $personId = $personModel->getInsertID();

            $contactData = [
                'person_id' => $personId,
                'fax_num' => $this->request->getPost('fax'),
                'telephone_num' => $this->request->getPost('telephone'),
                'mobile_num' => $this->request->getPost('mobile'),
                'email_address' => $this->request->getPost('email'),
            ];
            $contactModel->insert($contactData);

            $stakeholderMemberData = [
                'stakeholder_id' => $stakeholderId,
                'person_id' => $personId,
                'role' => 'Head of Office',
            ];
            $stakeholderMemberModel->insert($stakeholderMemberData);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Failed to add academe');
            }

            return redirect()->to('directory/academes')->with('success', 'Academe added successfully');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Failed to add academe: ' . $e->getMessage());
        }
    }

    // LGU //
    public function lgu()
    {
        $stakeholdersModel = new StakeholderModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $membersModel = new StakeholderMembersModel();

        $lgus = $stakeholdersModel
            ->where('category', 'LGU')
            ->findAll();

        foreach ($lgus as &$lgu) {
            $members = $membersModel->where('stakeholder_id', $lgu['id'])->findAll();

            foreach ($members as &$member) {
                $person = $personsModel->find($member['person_id']);
                if ($person) {
                    $member['person'] = $person;

                    $contact = $contactModel->where('person_id', $person['id'])->first();
                    $member['contact'] = $contact;
                }
            }

            $lgu['members'] = $members;
        }

        // Debug output
        // echo '<pre>';
        // print_r($lgus);
        // echo '</pre>';
        // exit;


        return view('directory/lgus/index', ['lgus' => $lgus]);
    }

    public function lguStore()
    {
        $db = \Config\Database::connect();
        $request = service('request');

        $data = [
            'salutation' => $request->getPost('salutation'),
            'first_name' => $request->getPost('first_name'),
            'middle_name' => $request->getPost('middle_name'),
            'last_name' => $request->getPost('last_name'),
            'position' => $request->getPost('position'),
            'office_name' => $request->getPost('office_name'),
            'office_address' => $request->getPost('office_address'),
            'telephone_num' => $request->getPost('telephone_num'),
            'fax_num' => $request->getPost('fax_num'),
            'email_address' => $request->getPost('email_address')
        ];

        $db->transStart();
        $db->table('stakeholders')->insert([
            'category' => 'LGU',
            'name' => $data['office_name'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $stakeholderId = $db->insertID();

        $db->table('persons')->insert([
            'salutation' => $data['salutation'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'designation' => $data['position'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $personId = $db->insertID();

        $db->table('stakeholder_members')->insert([
            'person_id' => $personId,
            'stakeholder_id' => $stakeholderId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $db->table('contact_details')->insert([
            'person_id' => $personId,
            'telephone_num' => $data['telephone_num'],
            'fax_num' => $data['fax_num'],
            'email_address' => $data['email_address'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $db->transComplete();

        return $db->transStatus()
            ? redirect()->to('/directory/lgus')->with('success', 'LGU successfully added.')
            : redirect()->back()->with('error', 'Failed to save LGU data.');
    }

    // NGO //
    public function businessSector()
    {
        $stakeholdersModel = new StakeholderModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $membersModel = new StakeholderMembersModel();

        $ngos = $stakeholdersModel->where('category', 'NGO')->findAll();

        foreach ($ngos as &$ngo) {
            $members = $membersModel->where('stakeholder_id', $ngo['id'])->findAll();

            foreach ($members as &$member) {
                $person = $personsModel->find($member['person_id']);
                if ($person) {
                    $member['person'] = $person;

                    $contact = $contactModel->where('person_id', $person['id'])->first();
                    $member['contact'] = $contact;
                }
            }

            $ngo['members'] = $members;
        }

        return view('directory/business_sector/index', ['ngos' => $ngos]);
        // return view('directory/business_sector/index');
    }

    public function businessSectorStore()
    {
        $db = \Config\Database::connect();
        $request = service('request');

        $db->transStart();

        try {
            $stakeholderData = [
                'category' => 'NGO',
                'name' => $request->getPost('office_name'),
                'address' => trim($request->getPost('street') . ', ' .
                    $request->getPost('barangay') . ', ' .
                    $request->getPost('municipality') . ', ' .
                    $request->getPost('province') . ', ' .
                    $request->getPost('postal_code'), ', '),
                'classification' => $request->getPost('classification'),
                'source_agency' => $request->getPost('source_agency'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$db->table('stakeholders')->insert($stakeholderData)) {
                throw new \Exception("Failed to insert into stakeholders table.");
            }

            $stakeholderId = $db->insertID();
            if (!$stakeholderId) {
                throw new \Exception("Stakeholder ID retrieval failed.");
            }

            $personData = [
                'salutation' => $request->getPost('salutation'),
                'first_name' => $request->getPost('name'),
                'designation' => $request->getPost('designation'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$db->table('persons')->insert($personData)) {
                throw new \Exception("Failed to insert into persons table.");
            }

            $personId = $db->insertID();
            if (!$personId) {
                throw new \Exception("Person ID retrieval failed.");
            }

            $memberData = [
                'person_id' => $personId,
                'stakeholder_id' => $stakeholderId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$db->table('stakeholder_members')->insert($memberData)) {
                throw new \Exception("Failed to insert into stakeholder_members table.");
            }

            $contactData = [
                'person_id' => $personId,
                'telephone_num' => $request->getPost('telephone_fax'),
                'email_address' => $request->getPost('email'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$db->table('contact_details')->insert($contactData)) {
                throw new \Exception("Failed to insert into contact_details table.");
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Database transaction failed.");
            }

            return redirect()->to('/directory/business_sector')->with('success', 'NGO successfully added.');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Database Insert Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function wideContacts()
    {
        return view('directory/wide_contacts/index');
    }
    // public function balik_scientist()
    // {
    //     return view('directory/balik_scientist/index');
    // }

    public function suc()
    {
        return view('directory/sucs/index');
    }


}
