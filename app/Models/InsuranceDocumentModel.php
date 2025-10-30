<?php namespace App\Models;

use CodeIgniter\Model;

class InsuranceDocumentModel extends Model
{
    protected $table            = 'insurance_documents';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'user_id', 'document_path', 'type', 'risk_score', 'risk_text', 'uploaded_at'
    ];

    protected $useTimestamps    = false; // using DB default timestamp
}