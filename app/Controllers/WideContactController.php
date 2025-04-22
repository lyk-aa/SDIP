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
        $data['child_page'] = 'Wide Contacts';
        
        return view('directory/wide_contacts/index');
    }
}
