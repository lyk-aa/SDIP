<?php

namespace App\Models;

use CodeIgniter\Model;

class AcademesModel extends Model
{
    protected $table = 'academes';
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
        'designation',
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
