<?php

namespace App\Models;

use CodeIgniter\Model;

class StakeholderModel extends Model
{
    protected $table = 'stakeholders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'abbreviation',
        'name',
        'category',
        'municipality',
        'province',
        'street',
        'barangay',
        'country',
        'postal_code',
        'classification',
        'source_agency',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}