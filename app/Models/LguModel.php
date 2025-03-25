<?php

namespace App\Models;

use CodeIgniter\Model;

class LguModel extends Model
{
    protected $table = 'lgus';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'category',
        'image',
        'position',
        'first_name',
        'middle_name',
        'last_name',
        'telephone_num',
        'fax_num',
        'mobile_num',
        'email_address',
        'plate_number',
        'driver_num',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
