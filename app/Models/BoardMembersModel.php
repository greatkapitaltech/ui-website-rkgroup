<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardMembersModel extends Model
{
    protected $table = 'board_members';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'position', 'photo', 'bio', 'education',
        'member_type', 'display_order', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
}
