<?php

namespace App\Models;

use CodeIgniter\Model;

class InstitutionModel extends Model
{
    protected $table = 'institutions';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'stakeholder_id',
        'image',
        'type',
        'file',
        'created_at',
        'updated_at'
    ];
}
