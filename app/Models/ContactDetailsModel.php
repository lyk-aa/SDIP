<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactDetailsModel extends Model
{
    protected $table = 'contact_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['person_id', 'mobile_num', 'telephone_num', 'fax_num', 'email_address'];

    public function getContactByPerson($personId)
    {
        return $this->where('person_id', $personId)->first();
    }

    public function updateContactDetails($personId, $data)
    {
        return $this->where('person_id', $personId)->set($data)->update();
    }
}
