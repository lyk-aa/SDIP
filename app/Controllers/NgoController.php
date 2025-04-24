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
    }
    public function store()
    {
        $stakeholdersModel = new StakeholderModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $membersModel = new StakeholderMembersModel();

        $personData = [
            'salutation' => $this->request->getPost('salutation'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'designation' => $this->request->getPost('designation'),
        ];
        $personId = $personsModel->insert($personData);

        $contactData = [
            'person_id' => $personId,
            'telephone_num' => $this->request->getPost('telephone_num'),
            'fax_num' => $this->request->getPost('fax_num'),
            'email_address' => $this->request->getPost('email'),
        ];
        $contactModel->insert($contactData);

        $stakeholderData = [
            'name' => $this->request->getPost('office_name'),
            'street' => $this->request->getPost('street'),
            'barangay' => $this->request->getPost('barangay'),
            'municipality' => $this->request->getPost('municipality'),
            'province' => $this->request->getPost('province'),
            'country' => $this->request->getPost('country'),
            'postal_code' => $this->request->getPost('postal_code'),
            'classification' => $this->request->getPost('classification'),
            'source_agency' => $this->request->getPost('source_agency'),
            'category' => 'NGO',
        ];
        $stakeholderId = $stakeholdersModel->insert($stakeholderData);

        $memberData = [
            'stakeholder_id' => $stakeholderId,
            'person_id' => $personId,
        ];
        $membersModel->insert($memberData);

        return redirect()->to('directory/business_sector');
    }

    public function edit($id)
    {
        $personModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $stakeholderMembersModel = new StakeholderMembersModel();
        $stakeholderModel = new StakeholderModel();

        $person = $personModel->find($id);
        if (!$person) {
            return redirect()->to('/directory/business_sector')->with('error', 'Record not found.');
        }

        $contact = $contactModel->where('person_id', $id)->first();
        $member = $stakeholderMembersModel->where('person_id', $id)->first();
        $stakeholder = $stakeholderModel->find($member['stakeholder_id']);

        $ngo = [
            'id' => $stakeholder['id'],
            'name' => $stakeholder['name'],
            'classification' => $stakeholder['classification'],
            'source_agency' => $stakeholder['source_agency'],
            'address' => [
                'street' => $stakeholder['street'],
                'barangay' => $stakeholder['barangay'],
                'municipality' => $stakeholder['municipality'],
                'province' => $stakeholder['province'],
                'postal_code' => $stakeholder['postal_code'],
            ],
            'members' => [
                [
                    'person' => $person,
                    'contact' => $contact
                ]
            ]
        ];

        return view('directory/business_sector/edit', ['ngo' => $ngo]);
    }


    public function update($id)
    {
        $personModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $stakeholderModel = new StakeholderModel();
        $stakeholderMembersModel = new StakeholderMembersModel();

        $personData = [
            'salutation' => $this->request->getPost('salutation'),
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'designation' => $this->request->getPost('designation'),
        ];
        $personModel->update($id, $personData);

        $contactData = [
            'telephone_num' => $this->request->getPost('telephone_num'),
            'fax_num' => $this->request->getPost('fax_num'),
            'email_address' => $this->request->getPost('email'),
        ];
        $contactModel->where('person_id', $id)->set($contactData)->update();

        $member = $stakeholderMembersModel->where('person_id', $id)->first();

        if (!$member) {
            return redirect()->to('/directory/business_sector')->with('error', 'Member not found for the person.');
        }

        $stakeholderId = $member['stakeholder_id'];

        $stakeholderData = [
            'name' => $this->request->getPost('office_name'),
            'street' => $this->request->getPost('street'),
            'barangay' => $this->request->getPost('barangay'),
            'municipality' => $this->request->getPost('municipality'),
            'province' => $this->request->getPost('province'),
            'postal_code' => $this->request->getPost('postal_code'),
            'classification' => $this->request->getPost('classification'),
            'source_agency' => $this->request->getPost('source_agency'),
        ];
        $stakeholderModel->update($stakeholderId, $stakeholderData);

        return redirect()->to('/directory/business_sector')->with('success', 'Record updated successfully.');
    }



    public function delete($id)
    {
        $personModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $stakeholderMembersModel = new StakeholderMembersModel();

        $contactModel->where('person_id', $id)->delete();
        $stakeholderMembersModel->where('person_id', $id)->delete();
        $personModel->delete($id);

        return redirect()->to('/directory/business_sector')->with('success', 'Record deleted successfully.');
    }
    public function export()
    {
        $stakeholdersModel = new StakeholderModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $membersModel = new StakeholderMembersModel();

        $ngos = $stakeholdersModel->where('category', 'NGO')->findAll();

        $filename = 'ngo_list_' . date('YmdHis') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $output = fopen('php://output', 'w');
        ob_start();

        fputcsv($output, ['Salutation', 'First Name', 'Middle Name', 'Last Name', 'Designation', 'Office Name', 'Street', 'Barangay', 'Municipality', 'Province', 'Country', 'Postal Code', 'Classification', 'Source Agency', 'Telephone', 'Fax', 'Email']);

        foreach ($ngos as $ngo) {
            $members = $membersModel->where('stakeholder_id', $ngo['id'])->findAll();

            foreach ($members as $member) {
                $person = $personsModel->find($member['person_id']);
                $contact = $contactModel->where('person_id', $person['id'])->first();

                fputcsv($output, [
                    $person['salutation'] ?? '',
                    $person['first_name'] ?? '',
                    $person['middle_name'] ?? '',
                    $person['last_name'] ?? '',
                    $person['designation'] ?? '',
                    $ngo['name'] ?? '',
                    $ngo['street'] ?? '',
                    $ngo['barangay'] ?? '',
                    $ngo['municipality'] ?? '',
                    $ngo['province'] ?? '',
                    $ngo['country'] ?? '',
                    $ngo['postal_code'] ?? '',
                    $ngo['classification'] ?? '',
                    $ngo['source_agency'] ?? '',
                    $contact['telephone_num'] ?? '',
                    $contact['fax_num'] ?? '',
                    $contact['email_address'] ?? ''
                ]);
            }
        }

        fclose($output);
        $csv = ob_get_clean();

        return $this->response->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($csv);
    }
    public function view($id)
    {
        $stakeholdersModel = new StakeholderModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $membersModel = new StakeholderMembersModel();

        $ngo = $stakeholdersModel->find($id);
        if (!$ngo) {
            return redirect()->back()->with('error', 'NGO not found.');
        }

        $members = $membersModel->where('stakeholder_id', $ngo['id'])->findAll();

        foreach ($members as &$member) {
            $person = $personsModel->find($member['person_id']);
            $member['person'] = $person ?? [];

            $contact = $contactModel->where('person_id', $member['person_id'])->first();
            $member['contact'] = $contact ?? [];
        }

        $ngo['members'] = $members;

        return view('directory/business_sector/view', ['ngo' => $ngo]);
    }


}
