<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSessionModel extends Model
{
    protected $table = 'user_sessions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['phone', 'state', 'session_data', 'created_at', 'updated_at'];

    public function getSessionByPhone($phone)
    {
        return $this->where('phone', $phone)->first();
    }

    public function createSession($phone, $state = 'INITIAL_CONTACT', $sessionData = [])
    {
        $data = [
            'phone'        => $phone,
            'state'        => $state,
            'session_data' => json_encode($sessionData),
        ];
        return $this->insert($data);
    }

    public function updateSession($id, $state, $sessionData = [])
    {
        $data = [
            'state'        => $state,
            'session_data' => json_encode($sessionData),
        ];
        return $this->update($id, $data);
    }
}
