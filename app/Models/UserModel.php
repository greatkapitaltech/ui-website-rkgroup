<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Table name
    protected $primaryKey = 'id'; // Primary key column
    protected $allowedFields = ['phone', 'name', 'status', 'created_at']; // Columns that can be inserted or updated

    /**
     * Find a user by phone number.
     *
     * @param int $phone
     * @return array|null
     */
    public function getUserByPhoneNumber($phone)
    {
        return $this->where('phone', $phone)->first();
    }

    /**
     * Create a new user.
     *
     * @param int $phone
     * @param string $name
     * @return bool
     */
    public function createUser($phone, $name)
    {
        return $this->insert([
            'phone' => $phone,
            'name' => ucfirst($name),
            'status' => 'active',
        ]);
    }

}