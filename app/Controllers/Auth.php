<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Models\UserOtpModel;

class Auth extends ResourceController
{
    // Use JSON format for responses.
    protected $format = 'json';

    // Load the User model (adjust the namespace if needed)
    protected $modelName = 'App\Models\UserModel';
    private $gupshupapi = 'sk_81e432833f0b492586a196465721219d';
    private $source = '917249426487';
    
    public function initController($request, $response, $logger)
    {
        // Do not edit this line
        parent::initController($request, $response, $logger);
        
        // Manually set the Access-Control-Allow-Origin header for all responses.
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
    }

    /**
     * POST /auth/check-phone
     * Checks if a phone number exists in the database.
     * Expects a POST variable "phone".
     */
    public function checkPhone()
    {
        $phone = $this->request->getPost('phone');
        
        if (empty($phone)) {
            return $this->fail('Phone number is required', 400);
        }

        // Assuming getUserByPhoneNumber is a custom method in your UserModel
        $user = $this->model->getUserByPhoneNumber($phone);

        if ($user) {
            return $this->respond([
                'exists'  => true,
                'user_id' => $user['id'],
                'message' => 'Phone number exists'
            ]);
        } else {
            return $this->respond([
                'exists'  => false,
                'message' => 'Phone number does not exist'
            ]);
        }
    }

    /**
     * POST /auth/send-otp
     * Generates and "sends" an OTP to the given phone number.
     * Expects a POST variable "phone".
     */
    public function sendOTP()
    {
        $phone = $this->request->getPost('phone');
    
        if (empty($phone)) {
            return $this->fail('Phone number is required', 400);
        }
    
        $otp = strval(rand(100000, 999999));
        //$otp = 123456;
        $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));
    
        // Save to DB via model
        $otpModel = new UserOtpModel();
        $otpModel->upsertOTP($phone, $otp, $expiry);
    
        // Send the OTP via WhatsApp (Gupshup)
        $this->sendTemplateMessage($phone, "c60721f8-97d1-4b91-8897-efa6f1ced897", $otp);
    
        return $this->respond([
            'sent'    => true,
            'message' => 'OTP sent successfully'
        ]);
    }

    /**
     * POST /auth/verify-otp
     * Verifies the OTP sent to the phone number.
     * Expects POST variables "phone" and "otp".
     *
     * If the OTP is valid:
     *   - Checks if the user exists in the database.
     *   - If yes, returns the user id and indicates that the user exists.
     *   - If no, instructs the frontend that a new user must be created.
     */
    public function verifyOTP()
    {
        $phone       = $this->request->getPost('phone');
        $otpReceived = $this->request->getPost('otp');
    
        if (empty($phone) || empty($otpReceived)) {
            return $this->fail('Phone number and OTP are required', 400);
        }
    
        $otpModel = new UserOtpModel();
        $record = $otpModel->getOTPRecord($phone);
    
        if ($record && $record['otp'] === $otpReceived && strtotime($record['expires_at']) > time()) {
            // OTP is valid → mark verified + optionally delete it
            $otpModel->markVerified($phone);
            $otpModel->deleteOTP($phone);
    
            // Check if user exists
            $user = $this->model->getUserByPhoneNumber($phone);
            if ($user) {
                return $this->respond([
                    'verified'    => true,
                    'user_exists' => true,
                    'user_id'     => $user['id'],
                    'name'        => $user['name'],
                    'message'     => 'OTP verified successfully'
                ]);
            } else {
                return $this->respond([
                    'verified'    => true,
                    'user_exists' => false,
                    'message'     => 'OTP verified. New user, please provide name'
                ]);
            }
        }
    
        return $this->fail('Invalid or expired OTP', 400);
    }


    /**
     * POST /auth/create-user
     * Creates a new user using phone and name.
     * Expects POST variables "phone" and "name".
     *
     * After creating the user, returns the new user id.
     */
    public function createUser()
    {
        $phone = $this->request->getPost('phone');
        $name  = $this->request->getPost('name');
    
        if (empty($phone) || empty($name)) {
            return $this->fail('Phone number and name are required', 400);
        }
    
        // FIX: use $phone, not $fullPhone
        $newUserId = $this->model->createUser($phone, $name);
    
        if (!$newUserId) {
            return $this->fail('Failed to create user', 500);
        }
    
        return $this->respond([
            'created' => true,
            'name'    => $name,
            'user_id' => $newUserId,
            'message' => 'User created successfully'
        ]);
    }
    
    private function sendFileMessage($phone, $fileUrl, $caption = '')
    {
        $url    = 'https://api.gupshup.io/wa/api/v1/msg';
        $apiKey = $this->gupshupapi;
        $source = $this->source;
    
        $payload = [
            'type'      => 'file',
            'url'       => $fileUrl,
            'filename'  => basename($fileUrl),
            'caption'   => $caption
        ];
    
        $data = [
            'channel'     => 'whatsapp',
            'source'      => $source,
            'destination' => $phone,
            'message'     => json_encode($payload),
            'src.name'    => 'MediSoldierNew'
        ];
    
        $ch = curl_init($url); // INIT CURL
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded',
            'apikey: ' . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    
        return $response;
    }
    
    private function sendTemplateMessage($phone, $templateId, $otp = "")
    {
        $url    = 'https://api.gupshup.io/wa/api/v1/template/msg';
        $apiKey = $this->gupshupapi;
        $source = $this->source;
    
        $data = [
            'channel'     => 'whatsapp',
            'source'      => $source,
            'destination' => $phone,
            'src.name'    => 'MediSoldierNew',
            'template'    => json_encode([
                'id'     => $templateId,
                'params' => [$otp]
            ])
        ];
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Cache-Control: no-cache",
            "Content-Type: application/x-www-form-urlencoded",
            "apikey: $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    
        return $response;
    }
}