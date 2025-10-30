<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Pager\Pager;

class WebhookController extends BaseController {
    public function index() {
        // Read incoming request
        $input = json_decode(file_get_contents('php://input'), true);

        if (isset($input['type']) && $input['type'] == 'message') {
            $phone = $input['payload']['sender']['phone'];
            $message = strtolower(trim($input['payload']['text']));

            // Check user in database
            $db = \Config\Database::connect();
            $userModel = $db->table('users');

            $user = $userModel->where('phone_number', $phone)->get()->getRow();

            if (!$user) {
                // No user found, ask for the name
                if ($message === 'hi') {
                    $this->sendMessage($phone, "Hi! We don't have your details. Please provide your name.");
                } else {
                    // Save the user name and phone number in the database
                    $userModel->insert([
                        'phone_number' => $phone,
                        'name' => ucfirst($message)
                    ]);
                    $this->sendMessage($phone, "Thank you, " . ucfirst($message) . "! Please provide your delivery pincode.");
                }
            } else {
                // User exists, greet with name
                if ($message === 'hi') {
                    $this->sendMessage($phone, "Hi " . $user->name . "! Please tell me your delivery pincode.");
                } elseif (is_numeric($message)) {
                    // Process pincode (you can add validation logic here)
                    $this->sendMessage($phone, "Thank you! We're checking service availability for pincode: $message.");
                } else {
                    $this->sendMessage($phone, "Sorry, I didn't understand that. Please provide your pincode.");
                }
            }
        }

        // Send success response to GupShup
        return $this->response->setJSON(['status' => 'success']);
    }

    private function sendMessage($phone, $message) {
        $url = 'https://api.gupshup.io/wa/api/v1/msg';
        $apiKey = 'r7ubhaitbcv49zgrm6pjboruoqukyjh6';
        $source = '917834811114';
        $data = [
            'channel' => 'whatsapp',
            'source' => $source,
            'destination' => $phone,
            'message' => json_encode(['type' => 'text', 'text' => $message]),
            'src.name' => 'MediSoldier'
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
?>