<?php

namespace App\Models;

use CodeIgniter\Model;

class PartnersModel extends Model
{
    protected $table = 'partners';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'logo', 'website_url',
        'display_order', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
}
