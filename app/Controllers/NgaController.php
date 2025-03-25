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
}

