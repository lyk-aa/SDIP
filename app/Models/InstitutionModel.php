<?php

namespace App\Models;

use CodeIgniter\Model;

class InstitutionModel extends Model
{
    protected $table = 'institutions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'stakeholder_id',
        'image',
        'abbreviation',
        'name',
        'type',
        'address',
        'created_at',
        'updated_at',
    ];

    // Optional: Use timestamps if your table has them
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
