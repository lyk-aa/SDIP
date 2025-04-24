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
    public function create()
    {
        return view('directory/lgus/create');
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
            'street' => $request->getPost('street'),
            'barangay' => $request->getPost('barangay'),
            'municipality' => $request->getPost('municipality'),
            'province' => $request->getPost('province'),
            'country' => $request->getPost('country'),
            'postal_code' => $request->getPost('postal_code'),
            'telephone_num' => $request->getPost('telephone_num'),
            'fax_num' => $request->getPost('fax_num'),
            'email_address' => $request->getPost('email_address')
        ];

        $db->transStart();
        $db->table('stakeholders')->insert([
            'category' => 'LGU',
            'name' => $data['office_name'],
            'street' => $data['street'],
            'barangay' => $data['barangay'],
            'municipality' => $data['municipality'],
            'province' => $data['province'],
            'country' => $data['country'],
            'postal_code' => $data['postal_code'],
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

    public function edit($id)
    {
        $stakeholdersModel = new StakeholderModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $membersModel = new StakeholderMembersModel();

        $lgu = $stakeholdersModel->find($id);
        if (!$lgu) {
            return redirect()->to('/directory/lgus')->with('error', 'LGU not found.');
        }

        $members = $membersModel->where('stakeholder_id', $id)->findAll();
        foreach ($members as &$member) {
            $person = $personsModel->find($member['person_id']);
            if ($person) {
                $member['person'] = $person;
                $contact = $contactModel->where('person_id', $person['id'])->first();
                $member['contact'] = $contact ?: ['telephone_num' => '', 'fax_num' => '', 'email_address' => ''];
            } else {
                $member['person'] = [
                    'salutation' => '',
                    'first_name' => '',
                    'middle_name' => '',
                    'last_name' => '',
                    'designation' => ''
                ];
                $member['contact'] = ['telephone_num' => '', 'fax_num' => '', 'email_address' => ''];
            }
        }

        return view('directory/lgus/edit', ['lgu' => $lgu, 'members' => $members]);
    }


    public function update($id)
    {
        $stakeholdersModel = new StakeholderModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();
        $membersModel = new StakeholderMembersModel();
        $request = service('request');

        $stakeholdersModel->update($id, [
            'name' => $request->getPost('office_name'),
            'office_address' => $request->getPost('office_address'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $memberIds = $request->getPost('member_ids');
        if (!empty($memberIds)) {
            foreach ($memberIds as $index => $memberId) {
                $personData = [
                    'salutation' => $request->getPost("salutation")[$index],
                    'first_name' => $request->getPost("first_name")[$index],
                    'middle_name' => $request->getPost("middle_name")[$index],
                    'last_name' => $request->getPost("last_name")[$index],
                    'designation' => $request->getPost("position")[$index],
                ];
                $personsModel->update($memberId, $personData);

                $contactData = [
                    'telephone_num' => $request->getPost("telephone_num")[$index],
                    'fax_num' => $request->getPost("fax_num")[$index],
                    'email_address' => $request->getPost("email_address")[$index]
                ];
                $contactModel->where('person_id', $memberId)->set($contactData)->update();
            }
        }

        return redirect()->to('/directory/lgus')->with('success', 'LGU successfully updated.');
    }


    public function delete($id)
    {
        $db = \Config\Database::connect();

        $personIds = $db->table('stakeholder_members')
            ->select('person_id')
            ->where('stakeholder_id', $id)
            ->get()
            ->getResultArray();

        if (!empty($personIds)) {
            $personIds = array_column($personIds, 'person_id');

            $db->table('contact_details')->whereIn('person_id', $personIds)->delete();

            $db->table('persons')->whereIn('id', $personIds)->delete();
        }

        $db->table('stakeholder_members')->where('stakeholder_id', $id)->delete();

        $db->table('stakeholders')->where('id', $id)->delete();

        $db->transComplete();

        return redirect()->to('/directory/lgus')->with('success', 'LGU successfully deleted.');
    }
    public function export()
    {
        $stakeholdersModel = new StakeholderModel();
        $membersModel = new StakeholderMembersModel();
        $personsModel = new PersonModel();
        $contactModel = new ContactDetailsModel();

        $lgus = $stakeholdersModel->where('category', 'LGU')->findAll();

        $filename = 'lgus_' . date('Ymd_His') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv;");

        $file = fopen('php://output', 'w');

        // Update header to have separate columns for first_name and last_name
        $header = [
            'Office Name',
            'Street',
            'Barangay',
            'Municipality',
            'Province',
            'Country',
            'Postal Code',
            'First Name',
            'Last Name',
            'Position',
            'Telephone',
            'Fax',
            'Email'
        ];
        fputcsv($file, $header);

        foreach ($lgus as $lgu) {
            $members = $membersModel->where('stakeholder_id', $lgu['id'])->findAll();

            foreach ($members as $member) {
                $person = $personsModel->find($member['person_id']);
                $contact = $contactModel->where('person_id', $member['person_id'])->first();

                fputcsv($file, [
                    $lgu['name'],
                    $lgu['street'],
                    $lgu['barangay'],
                    $lgu['municipality'],
                    $lgu['province'],
                    $lgu['country'],
                    $lgu['postal_code'],
                    $person['first_name'] ?? '',
                    $person['last_name'] ?? '',
                    $person['designation'] ?? '',
                    $contact['telephone_num'] ?? '',
                    $contact['fax_num'] ?? '',
                    $contact['email_address'] ?? ''
                ]);
            }
        }

        fclose($file);
        exit;
    }

    public function view($id)
    {
        $stakeholdersModel = new StakeholderModel();
        $membersModel = new StakeholderMembersModel();
        $personModel = new PersonModel();
        $contactModel = new ContactDetailsModel();

        $lgu = $stakeholdersModel->find($id);

        if (!$lgu) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("LGU with ID $id not found.");
        }

        $members = $membersModel->where('stakeholder_id', $id)->findAll();

        foreach ($members as &$member) {
            $person = $personModel->find($member['person_id']);
            $contact = $contactModel->where('person_id', $member['person_id'])->first();

            $member['person'] = $person;
            $member['contact'] = $contact;
        }

        $lgu['members'] = $members;

        return view('directory/lgus/view', ['lgu' => $lgu]);
    }



}
