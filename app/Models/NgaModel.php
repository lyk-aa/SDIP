<?php

namespace App\Models;

use CodeIgniter\Model;

class NgaModel extends Model
{
    protected $table = 'ngas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'category',
        'image',
        'abbreviation',
        'name',
        'salutation',
        'first_name',
        'middle_name',
        'last_name',
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
