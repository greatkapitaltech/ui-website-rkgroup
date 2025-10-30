<?php

namespace App\Models;

use CodeIgniter\Model;

class SubstitutionModel extends Model
{
    protected $table         = 'substitution';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'manufacturer',
        'composition',
        'packaging',
        'product_name',
        'mrp',
        'sd',
        'cost_per_unit',
        'unit_measurement',
        'category_manu',
        'prescription',
        'availability',
        'product_link'
    ];

    // Optional: add timestamps if your table uses created_at/updated_at automatically
    // protected $useTimestamps = true;
}