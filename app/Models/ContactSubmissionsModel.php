<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactSubmissionsModel extends Model
{
    protected $table = 'contact_submissions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email', 'phone', 'interest', 'subject',
        'message', 'ip_address', 'status', 'admin_notes'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
}
