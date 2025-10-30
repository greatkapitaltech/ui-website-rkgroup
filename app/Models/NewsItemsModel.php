<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsItemsModel extends Model
{
    protected $table = 'news_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'content', 'embed_url', 'embed_type', 'image',
        'external_link', 'category', 'display_order',
        'is_featured', 'is_active', 'published_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
}
