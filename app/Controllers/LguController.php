<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;

class LguController extends BaseController
{
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
}
