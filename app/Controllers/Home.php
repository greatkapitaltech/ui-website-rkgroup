<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\UserSessionModel;
use App\Models\PinCodeModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\DeliveryAddressModel;
use App\Models\OrderSequenceModel;
use App\Models\OrderDetailsModel;

class Home extends BaseController
{
    protected $db;
    protected $userModel;
    protected $userSessionModel;
    protected $pinCodeModel;
    protected $orderModel, $orderDetailsModel;
    protected $paymentModel;
    protected $deliveryAddressModel;
    protected $orderSequenceModel;

    // Razorpay Credentials (Test keys)
    private $razorpayKeyId     = 'rzp_live_pMMRSRARs41Xyi';
    private $razorpayKeySecret = 'u5b5w6HfAgcphELUsepIUd7H';
    private $gupshupapi = 'sk_81e432833f0b492586a196465721219d';
    private $source = '917249426487';

    public function __construct()
    {
        $this->db                    = \Config\Database::connect();
        $this->userModel             = new UserModel();
        $this->userSessionModel      = new UserSessionModel();
        $this->pinCodeModel          = new PinCodeModel();
        $this->orderModel            = new OrderModel();
        $this->paymentModel          = new PaymentModel();
        $this->deliveryAddressModel  = new DeliveryAddressModel();
        $this->orderSequenceModel    = new OrderSequenceModel();
        $this->orderDetailsModel     = new OrderDetailsModel();
    }

    public function index()
    {
        if($this->request->getGet('razorpay_payment_link_reference_id')) {
            header('Location:https://medi-soldier-next-6sbf.vercel.app/application/orders/'.$this->request->getGet('razorpay_payment_link_reference_id')."?payment=success");
        }
        echo "Welcome to MediSoldier Chatbot";
    }

    /**
     * The main Gupshup WhatsApp webhook that handles user messages (text, file, location).
     */
    public function webhook()
    {
        // 1. Read raw JSON
        $rawData = file_get_contents('php://input');
        $input   = json_decode($rawData, true);

        // 2. Log incoming request for debugging
        $logFile = WRITEPATH . 'logs/gupshup_input.log';
        try {
            $fp = fopen($logFile, 'a');
            if ($fp) {
                fwrite($fp, '[' . date('Y-m-d H:i:s') . "] " . $rawData . "\n");
                fclose($fp);
            }
        } catch (\Exception $e) {
            // file-write error
        }

        // 3. Validate inbound
        if (!isset($input['type']) || $input['type'] !== 'message') {
            return $this->respondJSON('Invalid request type');
        }

        // Extract phone & msgType
        $phone   = $input['payload']['sender']['phone'] ?? null;
        $msgType = $input['payload']['type'] ?? ''; // "text", "file", "location", etc.

        if (empty($phone) || empty($msgType)) {
            return $this->respondJSON('No phone or message type found in payload');
        }

        // Prepare local variables
        $messageText  = '';
        $fileInfo     = [];
        $locationData = [];

        if ($msgType === 'text') {
            $messageText = trim($input['payload']['payload']['text'] ?? '');
        } elseif ($msgType === 'file' || $msgType === 'image') {
            $fileInfo = [
                'name'        => $input['payload']['payload']['name'] ?? '',
                'url'         => $input['payload']['payload']['url'] ?? '',
                'contentType' => $input['payload']['payload']['contentType'] ?? ''
            ];
        } elseif ($msgType === 'location') {
            $locationData = [
                'latitude'  => $input['payload']['payload']['latitude'] ?? '',
                'longitude' => $input['payload']['payload']['longitude'] ?? ''
            ];
        }

        // 4. Check user & session
        $user    = $this->userModel->getUserByPhoneNumber($phone);
        $session = $this->userSessionModel->getSessionByPhone($phone);

        // End session if user types 'bye'
        if ($msgType === 'text') {
            $lowerMsg = strtolower($messageText);
            if ($lowerMsg === 'bye') {
                $this->sendMessage($phone, "Goodbye! Feel free to reach out anytime. Take care!");
                if ($session) {
                    $this->userSessionModel->delete($session['id']);
                }
                return $this->respondJSON('Session ended by user');
            }
        }

        // If user not found...
        if (!$user) {
            if (!$session) {
                // New session -> ASK_NAME
                $this->userSessionModel->createSession($phone, 'ASK_NAME');
                $this->sendMessage($phone, "Hello! May I know your name?");
                return $this->respondJSON('Asking user for name');
            } else {
                // Existing session, handle states
                switch ($session['state']) {
                    case 'ASK_NAME':
                        if ($msgType === 'text' && $messageText !== '') {
                            $this->userModel->createUser($phone, $messageText);
                            $user = $this->userModel->getUserByPhoneNumber($phone);

                            $this->userSessionModel->updateSession($session['id'], 'INITIAL_CONTACT');
                            $this->sendMessage($phone, "Nice to meet you, $messageText!");
                            $this->sendMessage($phone, "Hi! Please provide your delivery pincode so that we can check service availability.");
                            return $this->respondJSON('Got user name, updated to INITIAL_CONTACT');
                        } else {
                            $this->sendMessage($phone, "Please provide a valid name, or type 'Hi' to start over.");
                        }
                        break;

                    default:
                        // fallback
                        $this->sendMessage($phone, "Sorry, let's start over. Please type 'Hi' again.");
                        $this->userSessionModel->delete($session['id']);
                        return $this->respondJSON('Reset session');
                }
            }
        }

        // If user exists but no session, create one.
        if (!$session) {
            $this->userSessionModel->createSession($phone, 'INITIAL_CONTACT');
            $this->sendMessage($phone, "Hello {$user['name']}! Please provide your delivery pincode so we can check service availability.");
            return $this->respondJSON('Created session in INITIAL_CONTACT');
        }

        // 5. Session-based conversation
        $sessionData = json_decode($session['session_data'], true) ?? [];

        switch ($session['state']) {

            case 'INITIAL_CONTACT':
                if ($msgType === 'text') {
                    $digitsOnly = preg_replace('/\D/', '', $messageText);
                    if ($digitsOnly !== '' && is_numeric($digitsOnly)) {
                        if (!$this->pinCodeModel->isAvailable($digitsOnly)) {
                            $this->sendMessage($phone, "Sorry, not yet available at $digitsOnly. We’re expanding soon!");
                            $this->sendMessage($phone, "Would you like to try another pincode or end this chat? Reply with:\n1. Try Another\n2. End Chat");
                            $sessionData['attempted_pincode'] = $digitsOnly;
                            $this->userSessionModel->updateSession($session['id'], 'PINCODE_UNAVAILABLE', $sessionData);
                        } else {
                            $this->sendMessage($phone, "Great! We can deliver to your area ($digitsOnly). Do you have a prescription? Reply with:\n1. I have a prescription\n2. I don't have a prescription");
                            $sessionData['pincode'] = $digitsOnly;
                            $this->userSessionModel->updateSession($session['id'], 'ASK_PRESCRIPTION', $sessionData);
                        }
                    } else {
                        $this->sendMessage($phone, "Please provide a valid numeric pincode to proceed.");
                    }
                } else {
                    $this->sendMessage($phone, "Please provide a valid numeric pincode to proceed.");
                }
                break;

            case 'PINCODE_UNAVAILABLE':
                if ($msgType === 'text') {
                    $lowerMsg = strtolower($messageText);
                    if ($lowerMsg === 'try another' || $lowerMsg === '1') {
                        $this->sendMessage($phone, "Please provide another pincode.");
                        $this->userSessionModel->updateSession($session['id'], 'INITIAL_CONTACT', $sessionData);
                    } elseif ($lowerMsg === 'end chat' || $lowerMsg === '2') {
                        $this->sendMessage($phone, "Session ended. Thank you for visiting!");
                        $this->userSessionModel->delete($session['id']);
                    } else {
                        $this->sendMessage($phone, "Invalid response. Please reply with:\n1. Try Another\n2. End Chat");
                    }
                } else {
                    $this->sendMessage($phone, "Invalid response. Please reply with:\n1. Try Another\n2. End Chat");
                }
                break;

            case 'ASK_PRESCRIPTION':
                if ($msgType === 'text') {
                    $lowerMsg = strtolower($messageText);
                    if ($lowerMsg === '1' || strpos($lowerMsg, 'have') !== false) {
                        $this->sendMessage($phone, "Please upload your prescription. Once received, we’ll create an order and review it.");
                        $this->userSessionModel->updateSession($session['id'], 'WAITING_FOR_PRESCRIPTION_UPLOAD', $sessionData);
                    } elseif ($lowerMsg === '2' || strpos($lowerMsg, "don't") !== false || strpos($lowerMsg, "dont") !== false) {
                        $this->sendMessage($phone, "Please choose from one:\n1. Pharmacy Support Center\n2. Doctor Consultation");
                        $this->userSessionModel->updateSession($session['id'], 'NO_PRESCRIPTION_OPTIONS', $sessionData);
                    } else {
                        $this->sendMessage($phone, "Please respond with:\n1. I have a prescription\n2. I don't have a prescription");
                    }
                } else {
                    $this->sendMessage($phone, "Please respond with:\n1. I have a prescription\n2. I don't have a prescription");
                }
                break;

            case 'NO_PRESCRIPTION_OPTIONS':
                if ($msgType === 'text') {
                    $lowerMsg = strtolower($messageText);
                    if ($lowerMsg === '1' || strpos($lowerMsg, 'pharmacy') !== false) {
                        $this->sendMessage($phone, "Your request has been submitted to our pharmacy team. We’ll connect with you shortly.");
                        $uniqueOrderId = $this->generateOrderId();
                        $orderDbId     = $this->orderModel->createOrder($user['id'], $uniqueOrderId);
                        $this->sendMessage($phone, "Your order ID is #$uniqueOrderId. Please wait as we connect you with our team. We are reviewing your request.");
                        $sessionData['order_id']    = $uniqueOrderId;
                        $sessionData['order_db_id'] = $orderDbId;
                        $this->userSessionModel->updateSession($session['id'], 'WAITING_FOR_ADMIN_ACTION', $sessionData);
                    } elseif ($lowerMsg === '2' || strpos($lowerMsg, 'doctor') !== false) {
                        $this->sendMessage($phone, "We’ll connect you with our medical team for a quick consultation. Please wait...");
                        $uniqueOrderId = $this->generateOrderId();
                        $orderDbId     = $this->orderModel->createOrder($user['id'], $uniqueOrderId);
                        $this->sendMessage($phone, "Your order ID is #$uniqueOrderId. Please wait as we connect you with our team. We are reviewing your request.");
                        $sessionData['order_id']    = $uniqueOrderId;
                        $sessionData['order_db_id'] = $orderDbId;
                        $this->userSessionModel->updateSession($session['id'], 'WAITING_FOR_ADMIN_ACTION', $sessionData);
                    } else {
                        $this->sendMessage($phone, "Please choose:\n1. Pharmacy Support Center\n2. Doctor Consultation");
                    }
                } else {
                    $this->sendMessage($phone, "Please choose:\n1. Pharmacy Support Center\n2. Doctor Consultation");
                }
                break;

            case 'WAITING_FOR_PRESCRIPTION_UPLOAD':
                if ($msgType === 'file' || $msgType === 'image') {
                    $prescriptionPath = $fileInfo['url'];
                    $uniqueOrderId = $this->generateOrderId();
                    $orderDbId     = $this->orderModel->createOrder($user['id'], $uniqueOrderId, $prescriptionPath);
                    $this->sendMessage($phone, "Your order ID is #$uniqueOrderId. Please wait while we review your prescription and check availability.");
                    $sessionData['order_id']    = $uniqueOrderId;
                    $sessionData['order_db_id'] = $orderDbId;
                    $this->userSessionModel->updateSession($session['id'], 'WAITING_FOR_ADMIN_ACTION', $sessionData);
                } elseif ($msgType === 'text') {
                    $lowerMsg = strtolower($messageText);
                    if (strpos($lowerMsg, 'upload') !== false) {
                        $this->sendMessage($phone, "Please attach the file or image of your prescription directly here.");
                    } else {
                        $this->sendMessage($phone, "We couldn’t detect a valid prescription file/image. Please send a clear PDF or JPG/PNG image.");
                    }
                } else {
                    $this->sendMessage($phone, "We only accept prescription images or files at this stage. Please upload a PDF or an image.");
                }
                break;

            case 'WAITING_FOR_ADMIN_ACTION':
                if ($msgType === 'text') {
                    $lowerMsg = strtolower($messageText);
                    if ($lowerMsg === 'adminupdate') {
                        if (!isset($sessionData['order_db_id'])) {
                            $this->sendMessage($phone, "No order ID found. Something went wrong.");
                            return $this->respondJSON('No order ID to update');
                        }
                        $orderDbId = $sessionData['order_db_id'];
                        $this->orderModel->update($orderDbId, ['status' => 'review']);
                        $orderRow   = $this->orderModel->find($orderDbId);
                        $finalTotal = (float) ($orderRow['total_amount'] ?? 0.00);
                        $rpayResp = $this->createRazorpayPaymentLink(
                            $orderRow['order_id'],
                            $finalTotal,
                            $user['name'],
                            substr($user['phone'], 2),
                            'testuser@example.com'
                        );
                        if ($rpayResp) {
                            $paymentLink = $rpayResp['short_url'] ?? $rpayResp['payment_link'] ?? '';
                            $linkId      = $rpayResp['id'] ?? '';
                            $this->paymentModel->createPaymentRecord($orderDbId, $paymentLink, $linkId);
                            $orderDetails = $this->orderDetailsModel->where('order_id', $orderDbId)->findAll();
                            $summaryLines = [];
                            foreach ($orderDetails as $od) {
                                $medicineName = $od['medicine_name'] ?? 'Unknown';
                                $qty          = $od['quantity'] ?? 1;
                                $summaryLines[] = "{$medicineName} x {$qty}";
                            }
                            $summaryText = implode("\n• ", $summaryLines);
                            $this->sendMessage(
                                $phone,
                                "Here is your order summary:\n• {$summaryText}\n\nTotal Amount: ₹{$finalTotal}\nPayment Link: {$paymentLink}\nOnce paid, type 'paid'."
                            );
                            $this->userSessionModel->updateSession($session['id'], 'WAITING_FOR_PAYMENT', $sessionData);
                        } else {
                            $this->sendMessage($phone, "Could not generate Razorpay link. Please try again.");
                        }
                    } else {
                        $this->sendMessage($phone, "We are still reviewing your request. Please wait...");
                    }
                } else {
                    $this->sendMessage($phone, "We are still reviewing your request. Please wait...");
                }
                break;

            case 'WAITING_FOR_PAYMENT':
                if ($msgType === 'text') {
                    $lowerMsg = strtolower($messageText);
                    if ($lowerMsg === 'paid') {
                        if (!isset($sessionData['order_db_id'])) {
                            $this->sendMessage($phone, "No order found in session. Something went wrong.");
                            return $this->respondJSON('No order ID in session');
                        }
                        $orderDbId = $sessionData['order_db_id'];
                        $paymentRow = $this->paymentModel
                                           ->where('order_id', $orderDbId)
                                           ->orderBy('id', 'desc')
                                           ->first();
                        if ($paymentRow && $paymentRow['payment_status'] === 'paid') {
                            $this->sendMessage($phone, "Great! We see your payment is confirmed.");
                            $this->sendMessage($phone, "Please select who the delivery is for:\n1. Myself\n2. Father\n3. Mother\n4. Daughter\n5. Son\n6. Others");
                            $this->userSessionModel->updateSession($session['id'], 'WAITING_FOR_RECIPIENT', $sessionData);
                        } else {
                            $this->sendMessage($phone, "We have not yet received confirmation from Razorpay. If you've just paid, please wait a moment and try again, or check the payment link.");
                        }
                    } else {
                        $this->sendMessage($phone, "Please type 'paid' once you've completed the payment.");
                    }
                } else {
                    $this->sendMessage($phone, "Please type 'paid' once you've completed the payment.");
                }
                break;

            case 'WAITING_FOR_RECIPIENT':
                if ($msgType === 'text') {
                    $lowerMsg = strtolower($messageText);
                    $recipient = '';
                    switch ($lowerMsg) {
                        case '1':
                        case 'myself':
                            $recipient = 'Myself';
                            break;
                        case '2':
                        case 'father':
                            $recipient = 'Father';
                            break;
                        case '3':
                        case 'mother':
                            $recipient = 'Mother';
                            break;
                        case '4':
                        case 'daughter':
                            $recipient = 'Daughter';
                            break;
                        case '5':
                        case 'son':
                            $recipient = 'Son';
                            break;
                        case '6':
                        case 'others':
                            $recipient = 'Others';
                            break;
                        default:
                            $this->sendMessage($phone, "Please select who the delivery is for:\n1. Myself\n2. Father\n3. Mother\n4. Daughter\n5. Son\n6. Others");
                            return $this->respondJSON('Invalid recipient choice');
                    }
                    $sessionData['recipient'] = $recipient;
                    $this->sendMessage($phone, "Now, please provide your delivery address.\nYou can:\n- Send your address manually.\n- Share your location.\n- Provide a Google Maps link.");
                    $this->userSessionModel->updateSession($session['id'], 'WAITING_FOR_ADDRESS', $sessionData);
                } else {
                    $this->sendMessage($phone, "Please select who the delivery is for (1-6).");
                }
                break;

            case 'WAITING_FOR_ADDRESS':
                if (!isset($sessionData['order_db_id'])) {
                    $this->sendMessage($phone, "No order found in session.");
                    return $this->respondJSON('No order ID in session for address');
                }
                $orderDbId = $sessionData['order_db_id'];

                if ($msgType === 'location') {
                    $lat  = $locationData['latitude'] ?? '';
                    $long = $locationData['longitude'] ?? '';
                    $this->deliveryAddressModel->createAddress($orderDbId, $sessionData['recipient'], null, null, "$lat,$long");
                    $this->sendMessage($phone, "Location received. We have your address on file.");
                } elseif ($msgType === 'text') {
                    $lowerMsg    = strtolower($messageText);
                    $addressText = $messageText;
                    $mapLink     = null;
                    $sharedLoc   = null;

                    if (strpos($lowerMsg, 'maps.google.com') !== false) {
                        $mapLink    = $messageText;
                        $addressText = null;
                    }
                    $this->deliveryAddressModel->createAddress(
                        $orderDbId, 
                        $sessionData['recipient'],
                        $addressText, 
                        $mapLink,
                        $sharedLoc
                    );
                    $this->sendMessage($phone, "Thank you! We have your address on file.");
                } else {
                    $this->sendMessage($phone, "Please provide your address or share your location from WhatsApp.");
                    return $this->respondJSON('Waiting for address');
                }

                // Final confirmation and session termination.
                $this->sendMessage($phone, "Thank you! Your order is now confirmed. Have a great day.");
                $this->userSessionModel->delete($session['id']);
                break;

            default:
                $this->sendMessage($phone, "Something went wrong. Let's restart. Please type 'hi'.");
                $this->userSessionModel->delete($session['id']);
                break;
        }

        return $this->respondJSON('success');
    }

    
    /**
     * Helper method: Send a Quick Reply message to Gupshup
     */
    private function sendQuickReply($phone, $promptText, $options = [])
    {
        $url    = 'https://api.gupshup.io/wa/api/v1/msg';
        $apiKey = $this->gupshupapi;  // Your Gupshup API key
        $source = $this->source;                     // Your Gupshup source number
    
        // Build the quick_reply payload
        $payload = [
            'type'    => 'quick_reply',
            'content' => [
                'type' => 'text',
                'text' => $promptText
            ],
            'options' => $options
        ];
    
        $data = [
            'channel'     => 'whatsapp',
            'source'      => $source,
            'destination' => $phone,
            'message'     => json_encode($payload),
            'src.name'    => 'MediSoldierNew'
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

    /**
     * 2. Razorpay Webhook to confirm payment asynchronously
     */
    public function razorpayWebhook()
    {
        $rawPayload = file_get_contents('php://input');
        $data       = json_decode($rawPayload, true);
    
        $logFile = WRITEPATH . 'logs/razorpay_webhook_receipt.log';
        try {
            $fp = fopen($logFile, 'a');
            if ($fp) {
                fwrite($fp, '[' . date('Y-m-d H:i:s') . '] ' . $rawPayload . "\n");
                fclose($fp);
            }
        } catch (\Exception $e) {
        }
    
        if (!empty($data['event']) && $data['event'] === 'payment_link.paid') {
            $paymentLinkEntity = $data['payload']['payment_link']['entity'] ?? [];
            $status     = $paymentLinkEntity['status'] ?? '';
            $amountPaid = ($paymentLinkEntity['amount_paid'] ?? 0) / 100;
    
            if ($status === 'paid') {
                $orderEntity = $data['payload']['order']['entity'] ?? [];
                $receipt     = $orderEntity['receipt'] ?? '';
    
                if (!empty($receipt)) {
                    $orderRow = $this->orderModel->where('order_id', $receipt)->first();
    
                    if ($orderRow) {
                        $paymentRow = $this->paymentModel
                                           ->where('order_id', $orderRow['id'])
                                           ->where('payment_status', 'pending')
                                           ->first();
                        if ($paymentRow) {
                            $this->paymentModel->markAsPaid($paymentRow['id'], $amountPaid);
                        }
                    } else {
                        log_message('error', "Razorpay Webhook: no local order with order_id = $receipt");
                    }
                    
                    $user = $this->userModel->find($orderRow['user_id']);
                    $this->triggerPaidUpdate($user['phone']);
                }
            }
        }
    
        return $this->response->setJSON(['status' => 'ok']);
    }

    private function triggerPaidUpdate($userPhone)
    {
        $webhookUrl = base_url('webhook'); 
        $data = [
            "app"       => "MediSoldier",
            "timestamp" => time() * 1000,
            "version"   => 2,
            "type"      => "message",
            "payload"   => [
                "id"      => "wamid.HBg" . uniqid(),
                "source"  => $userPhone,
                "type"    => "text",
                "payload" => [
                    "text" => "paid"
                ],
                "sender" => [
                    "phone"         => $userPhone,
                    "name"          => "Admin Trigger",
                    "country_code"  => "91",
                    "dial_code"     => substr($userPhone, 2)
                ]
            ]
        ];
    
        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Create a Razorpay Payment Link on the fly.
     */
    private function createRazorpayPaymentLink($orderId, $amount, $customerName, $customerPhone, $customerEmail)
    {
        $razorAmount = (int) round($amount * 100);
    
        $postData = [
            "amount"         => $razorAmount,
            "currency"       => "INR",
            "accept_partial" => false,
            "reference_id"   => $orderId,
            "description"    => "Payment for $orderId",
            "customer" => [
                "name"    => $customerName,
                "contact" => $customerPhone,
                "email"   => $customerEmail
            ],
            "notify" => [
                "sms"   => true,
                "email" => true
            ],
            "callback_url"   => "https://medisoldier.sodiarc.in/",
            "callback_method"=> "get"
        ];
    
        $url = "https://api.razorpay.com/v1/payment_links";
        $ch  = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->razorpayKeyId . ":" . $this->razorpayKeySecret); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $logFile = WRITEPATH . 'logs/razorpay_create_link.log';
        try {
            $fp = fopen($logFile, 'a');
            if ($fp) {
                fwrite($fp, '[' . date('Y-m-d H:i:s') . "] Response: " . $response . "\n");
                fclose($fp);
            }
        } catch (\Exception $e) {
        }
    
        $result = json_decode($response, true);
        if (!empty($result['id'])) {
            return $result; 
        } else {
            log_message('error', 'Razorpay Link Creation Failed: ' . $response);
            return null;
        }
    }

    /**
     * Send WhatsApp message via Gupshup
     */
    private function sendMessage($phone, $message)
    {
        $url    = 'https://api.gupshup.io/wa/api/v1/msg';
        $apiKey = $this->gupshupapi;
        $source = $this->source;
        
        $data = [
            'channel'     => 'whatsapp',
            'source'      => $source,
            'destination' => $phone,
            'message'     => json_encode(['type' => 'text', 'text' => $message]),
            'src.name'    => 'MediSoldierNew'
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

    /**
     * Respond with JSON
     */
    private function respondJSON($message)
    {
        return $this->response->setJSON(['status' => $message]);
    }

    /**
     * Generate a unique order ID using your sequence table.
     */
    private function generateOrderId()
    {
        $year  = (int) date('Y');
        $month = (int) date('m');

        $record = $this->orderSequenceModel->getSequenceRow($year, $month);
        if (!$record) {
            $this->orderSequenceModel->createSequenceRow($year, $month, 1);
            $sequenceNumber = 1;
        } else {
            $sequenceNumber = $record['last_sequence'] + 1;
            $this->orderSequenceModel->updateSequence($year, $month, $sequenceNumber);
        }

        return sprintf("MS-%04d-%02d-%03d", $year, $month, $sequenceNumber);
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