<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicinesMasterModel extends Model
{
    protected $table         = 'medicines_master';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'medicine_name',
        'mrp'  // if you store a default MRP or price
    ];

    // If needed, enable automatic timestamps:
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    /**
     * Get all medicines for dropdown or listing.
     */
    public function getAllMedicines()
    {
        return $this->findAll();
    }

    /**
     * Find a single medicine record by ID.
     */
    public function getMedicineById($id)
    {
        return $this->find($id);
    }
}
