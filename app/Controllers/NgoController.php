<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;



class NgoController extends BaseController
{
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
}
