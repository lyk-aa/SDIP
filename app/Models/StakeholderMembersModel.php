<?php

namespace App\Models;

use CodeIgniter\Model;

class StakeholderMembersModel extends Model
{
    protected $table = 'stakeholder_members';
    protected $primaryKey = 'id';
    protected $allowedFields = ['person_id', 'stakeholder_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function getMembersByStakeholder($stakeholderId)
    {
        return $this->where('stakeholder_id', $stakeholderId)->findAll();
    }

    public function getMembersWithDetails()
    {
        return $this->select([
            'stakeholder_members.*',
            'CONCAT(persons.first_name, " ", persons.last_name) AS person_name',
            'stakeholders.name AS stakeholder_name'
        ])
            ->join('persons', 'persons.id = stakeholder_members.person_id')
            ->join('stakeholders', 'stakeholders.id = stakeholder_members.stakeholder_id')
            ->asArray()
            ->findAll();
    }
}
