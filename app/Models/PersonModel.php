<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonModel extends Model
{
    protected $table = 'persons';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'first_name',
        'middle_name',
        'last_name',
        'designation',
        'salutation',
        'honorifics',
        'role',
        'description',
        'driver_num',
        'plate_number',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
