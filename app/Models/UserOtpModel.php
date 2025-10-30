<?php

namespace App\Models;

use CodeIgniter\Model;

class UserOtpModel extends Model
{
    protected $table            = 'user_otps';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['phone', 'otp', 'expires_at', 'verified_at', 'created_at'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // No auto-update field
    protected $useSoftDeletes   = false;

    /**
     * Inserts or updates OTP record for a phone.
     */
    public function upsertOTP(string $phone, string $otp, string $expiresAt): bool
    {
        $this->deleteOTP($phone);
        return $this->save([
            'phone'      => $phone,
            'otp'        => $otp,
            'expires_at' => $expiresAt,
        ]);
    }

    /**
     * Get OTP record for a phone number.
     */
    public function getOTPRecord(string $phone): ?array
    {
        return $this->where('phone', $phone)->first();
    }

    /**
     * Mark OTP as verified.
     */
    public function markVerified(string $phone): bool
    {
        return $this->where('phone', $phone)
                    ->set(['verified_at' => date('Y-m-d H:i:s')])
                    ->update();
    }

    /**
     * Delete OTP record.
     */
    public function deleteOTP(string $phone): bool
    {
        return $this->where('phone', $phone)->delete() !== false;
    }

    /**
     * Remove all expired OTPs.
     */
    public function deleteExpiredOTPs(): int
    {
        return $this->where('expires_at <', date('Y-m-d H:i:s'))->delete();
    }
}