<?php

namespace App\Models;

use CodeIgniter\Model;

class PinCodeModel extends Model
{
    protected $table = 'pincodes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pincode', 'is_available'];

    public function isAvailable($pincode)
    {
        $row = $this->where('pincode', $pincode)->first();
        if ($row && $row['is_available'] === 'available') {
            return true;
        }
        return false;
    }
}
