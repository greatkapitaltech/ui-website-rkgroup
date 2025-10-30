<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model {
    protected $table      = 'admin';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['userid', 'password', 'type'];

    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
