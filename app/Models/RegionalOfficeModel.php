<?php

namespace App\Models;

use CodeIgniter\Model;

class RegionalOfficeModel extends Model
{
    protected $table = 'regionaloffices';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'category',
        'image',
        'abbreviation',
        'name',
        'honorifics',
        'first_name',
        'middle_name',
        'last_name',
        'designation',
        'position',
        'street',
        'barangay',
        'municipality',
        'province',
        'telephone_num',
        'fax_num',
        'mobile_num',
        'email_address',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
