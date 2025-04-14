<?php

namespace App\Models;

use CodeIgniter\Model;

class ResearchCentersModel extends Model
{
    protected $table = 'rd_innovation_centers';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'institution_id', 
        'name', 
        'description', 
        'longitude', 
        'latitude', 
        'created_at', 
        'updated_at'];
}
