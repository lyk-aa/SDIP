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
}

