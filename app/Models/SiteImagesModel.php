<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteImagesModel extends Model
{
    protected $table = 'site_images';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'image_key',
        'image_file',
        'image_url',
        'alt_text',
        'image_category',
        'description',
        'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
