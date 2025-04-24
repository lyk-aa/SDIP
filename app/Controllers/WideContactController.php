<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StakeholderModel;
use App\Models\PersonModel;
use App\Models\ContactDetailsModel;
use App\Models\StakeholderMembersModel;
class WideContactController extends BaseController
{
    public function wideContacts()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                p.id AS person_id,
                p.first_name,
                p.middle_name,
                p.last_name,
                p.position,
                c.email_address,
                c.fax_num,
                c.telephone_num,
                c.mobile_num,
                p.driver_num,
                p.plate_number
             
            FROM stakeholder_members sm
            JOIN persons p ON sm.person_id = p.id
            JOIN stakeholders s ON sm.stakeholder_id = s.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.category = 'Contacts'
        ");

        $data['contacts'] = $query->getResult();
        return view('directory/wide_contacts/index', $data);
    }
    public function store()
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        // Generate a new stakeholder entry for this contact
        $stakeholderName = $this->request->getPost('first_name') . ' ' . $this->request->getPost('last_name') . ' - Contact';

        $db->table('stakeholders')->insert([
            'name' => $stakeholderName,
            'category' => 'Contacts',
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ]);
        $stakeholderId = $db->insertID();

        // Insert into persons table
        $personData = [
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'position' => $this->request->getPost('position'),
            'driver_num' => $this->request->getPost('driver_number'),
            'plate_number' => $this->request->getPost('plate_number'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('persons')->insert($personData);
        $personId = $db->insertID();

        // Link the person to their unique stakeholder
        $db->table('stakeholder_members')->insert([
            'stakeholder_id' => $stakeholderId,
            'person_id' => $personId,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ]);

        // Insert contact details
        $contactData = [
            'person_id' => $personId,
            'email_address' => $this->request->getPost('email'),
            'mobile_num' => $this->request->getPost('contact_number'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
        $db->table('contact_details')->insert($contactData);

        return redirect()->to('/directory/wide_contacts')->with('success', 'Contact added successfully.');
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $contact = $db->table('persons p')
            ->select('p.*, c.email_address, c.mobile_num')
            ->join('contact_details c', 'c.person_id = p.id', 'left')
            ->where('p.id', $id)
            ->get()
            ->getRow();

        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found.');
        }

        return view('directory/wide_contacts/edit', ['contact' => $contact]);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $timestamp = date('Y-m-d H:i:s');

        $personData = [
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'position' => $this->request->getPost('position'),
            'driver_num' => $this->request->getPost('driver_number'),
            'plate_number' => $this->request->getPost('plate_number'),
            'updated_at' => $timestamp
        ];
        $db->table('persons')->where('id', $id)->update($personData);

        $contactData = [
            'email_address' => $this->request->getPost('email'),
            'mobile_num' => $this->request->getPost('contact_number'),
            'updated_at' => $timestamp
        ];

        $existingContact = $db->table('contact_details')->where('person_id', $id)->get()->getRow();
        if ($existingContact) {
            $db->table('contact_details')->where('person_id', $id)->update($contactData);
        } else {
            $contactData['person_id'] = $id;
            $contactData['created_at'] = $timestamp;
            $db->table('contact_details')->insert($contactData);
        }

        return redirect()->to('/directory/wide_contacts')->with('success', 'Contact updated successfully.');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();

        $db->table('contact_details')->where('person_id', $id)->delete();

        $db->table('stakeholder_members')->where('person_id', $id)->delete();

        $db->table('persons')->where('id', $id)->delete();

        return redirect()->to('/directory/wide_contacts')->with('success', 'Contact deleted successfully.');
    }
    public function export()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
        SELECT 
            first_name,
            middle_name,
            last_name,
            position,
            email_address,
            COALESCE(mobile_num, telephone_num, fax_num, 'N/A') AS contact_number,
            plate_number,
            driver_num
        FROM stakeholder_members sm
            JOIN persons p ON sm.person_id = p.id
            JOIN stakeholders s ON sm.stakeholder_id = s.id
            LEFT JOIN contact_details c ON c.person_id = p.id
            WHERE s.category = 'Contacts'
    ");

        $contacts = $query->getResult();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="dost_wide_contacts.csv"');

        $output = fopen('php://output', 'w');

        fputcsv($output, ['First Name', 'Middle Name', 'Last Name', 'Position', 'Email Address', 'Contact Number', 'Plate Number', 'Driver Number']);

        foreach ($contacts as $contact) {
            fputcsv($output, [
                $contact->first_name ?? '',
                $contact->middle_name ?? '',
                $contact->last_name ?? '',
                $contact->position ?? 'N/A',
                $contact->email_address ?? 'N/A',
                $contact->contact_number ?? 'N/A',
                $contact->plate_number ?? 'N/A',
                $contact->driver_num ?? 'N/A'
            ]);
        }

        fclose($output);
        exit;
    }
    public function view($id)
    {
        $db = \Config\Database::connect();

        $contact = $db->table('persons p')
            ->select('p.*, c.email_address, c.mobile_num, c.telephone_num, c.fax_num, p.position, p.driver_num, p.plate_number')
            ->join('contact_details c', 'c.person_id = p.id', 'left')
            ->where('p.id', $id)
            ->get()
            ->getRow();

        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found.');
        }

        $data['contact'] = $contact;

        return view('directory/wide_contacts/view', $data);
    }


}
