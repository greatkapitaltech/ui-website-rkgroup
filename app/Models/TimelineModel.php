<?php

namespace App\Models;

use CodeIgniter\Model;

class TimelineModel extends Model
{
    protected $table = 'timeline_events';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'year', 'title', 'description', 'image_url',
        'alignment', 'display_order', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
}
