<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Models\UserSessionModel;
use App\Models\PinCodeModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\DeliveryAddressModel;
use App\Models\OrderSequenceModel;
use App\Models\OrderDetailsModel;
use App\Models\SubstitutionModel;
use App\Models\InsuranceDocumentModel;
use App\Models\CouponModel;

class ApiController extends ResourceController
{
    protected $format = 'json';
    protected $db;
    protected $userModel;
    protected $userSessionModel;
    protected $pinCodeModel;
    protected $orderModel, $orderDetailsModel;
    protected $paymentModel;
    protected $deliveryAddressModel;
    protected $orderSequenceModel;
    protected $substitutionModel;
    protected $couponModel;

    // Razorpay real credentials 
    private $razorpayKeyId     = 'rzp_live_pMMRSRARs41Xyi';
    private $razorpayKeySecret = 'u5b5w6HfAgcphELUsepIUd7H';
    
    // Whatsapp Real Creds
    private $gupshupapi = 'sk_81e432833f0b492586a196465721219d';
    private $source = '917249426487';
    
    // public function initController($request, $response, $logger)
    // {
    //     // Do not edit this line
    //     parent::initController($request, $response, $logger);
        
    //     // Manually set the Access-Control-Allow-Origin header for all responses.
    //     $this->response->setHeader('Access-Control-Allow-Origin', '*');
    // }
    
    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
         $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
    
    public function preflightAny()
    {
        return $this->response->setStatusCode(204);
    }
    
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
        $this->substitutionModel     = new SubstitutionModel();
        $this->couponModel           = new CouponModel();
    }

    /**
     * Helper method to check pincode availability.
     *
     * @param string|null $pincode Optionally pass a pincode; otherwise it is taken from the request.
     * @return array Returns an array with the pincode and its availability status,
     *               or an error message if missing.
     */
    protected function getPincodeAvailability($pincode = null)
    {
        if (!$pincode) {
            $pincode = $this->request->getGet('pincode');
        }

        if (!$pincode) {
            return [
                'error'   => true,
                'message' => 'Pincode is required.'
            ];
        }

        $pinCodeModel = new PinCodeModel();
        $isAvailable  = $pinCodeModel->isAvailable($pincode);

        return [
            'pincode'      => $pincode,
            'is_available' => $isAvailable
        ];
    }

    /**
     * Endpoint: /api/pincode/check (GET or POST)
     *
     * Checks if the provided pincode is available.
     *
     * Expected input:
     *   pincode=<pincode_value>
     *
     * @return \CodeIgniter\HTTP\Response JSON response containing pincode and availability status.
     */
    public function checkPincode()
    {
        $result = $this->getPincodeAvailability();

        if (isset($result['error']) && $result['error'] === true) {
            return $this->failValidationErrors($result['message']);
        }

        return $this->respond($result);
    }
    
    /**
     * Endpoint: /api/orders (GET)
     *
     * Returns orders data in a structure expected by the OrdersPage.
     *
     * The response structure:
     * {
     *   "ongoing": [
     *     {
     *       "order_id": "#MS-2025-01-003",
     *       "items": [
     *         { "name": "Paracetamol", "quantity": 1 },
     *         { "name": "Dolo", "quantity": 2 },
     *         { "name": "Clarion BD", "quantity": 2 }
     *       ],
     *       "status": "Out for delivery",
     *       "total_amount": "768.34"
     *     }
     *   ],
     *   "past": [
     *     {
     *       "order_id": "#MS-2025-01-002",
     *       "items": [
     *         { "name": "Paracetamol", "quantity": 1 },
     *         { "name": "Dolo", "quantity": 2 },
     *         { "name": "Clarion BD", "quantity": 2 }
     *       ],
     *       "status": "Delivered",
     *       "total_amount": "768.34",
     *       "date": "24 January, 2025"
     *     },
     *     {
     *       "order_id": "#MS-2025-01-001",
     *       "items": [
     *         { "name": "Paracetamol", "quantity": 1 },
     *         { "name": "Dolo", "quantity": 2 },
     *         { "name": "Clarion BD", "quantity": 2 }
     *       ],
     *       "status": "Cancelled",
     *       "total_amount": "768.34"
     *     }
     *   ]
     * }
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function getOrders()
    {
        $userId = $this->request->getGet('user_id');
        $orderModel = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();
    
        // If user_id is provided, filter orders by user_id; otherwise, fetch all orders.
        // Sort by created_at DESC to show newest orders first.
        if ($userId) {
            $orders = $orderModel
                ->where('user_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        } else {
            $orders = $orderModel
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }
    
        $ongoing = [];
        $past    = [];
    
        foreach ($orders as $order) {
            // Retrieve order line items.
            $details = $orderDetailsModel->getOrderDetailsByOrderId($order['id']);
            $items   = [];
            foreach ($details as $detail) {
                $items[] = [
                    'name'     => $detail['medicine_name'] ?? 'Unknown',
                    'quantity' => $detail['quantity'] ?? 1,
                ];
            }
    
            $orderData = [
                'order_id'     => $order['order_id'], // Custom order id string
                'items'        => $items,
                'status'       => $order['status'],
                'total_amount' => $order['total_amount'] ? number_format($order['total_amount'], 2) : "0.00",
            ];
    
            // Classify orders as ongoing or past based on their status.
            // e.g., if status is "delivered" or "cancelled", consider it a past order.
            if (in_array(strtolower($order['status']), ['delivered', 'cancelled'])) {
                $orderData['date'] = date("d F, Y", strtotime($order['created_at']));
                $past[] = $orderData;
            } else {
                $ongoing[] = $orderData;
            }
        }
    
        return $this->respond([
            'ongoing' => $ongoing,
            'past'    => $past,
        ]);
    }
    
    /**
     * Endpoint: /api/order/details (GET)
     *
     * Expects:
     *   order_id=<CUSTOM_ORDER_ID>  (e.g. MS-2025-03-001)
     *
     * Returns JSON like:
     * {
     *   "order_id": "MS-2025-03-001",
     *   "items": [
     *       { "name": "Paracetamol", "quantity": 1 },
     *       { "name": "Dolo", "quantity": 2 }
     *   ],
     *   "status": "pending",
     *   "total_amount": "100.00",
     *   "date": "15 March, 2025"
     * }
     */
    public function getOrderDetails()
    {
        $customOrderId = $this->request->getGet('order_id');
        if (!$customOrderId) {
            return $this->failValidationErrors('order_id is required.');
        }
        
        // Find the order by its custom order_id
        $order = $this->orderModel->where('order_id', $customOrderId)->first();
        if (!$order) {
            return $this->failNotFound("No order found with order_id = $customOrderId");
        }
        
        // Check payment status from the PaymentModel
        $paymentRow = $this->paymentModel
                           ->where('order_id', $order['id'])
                           ->orderBy('id', 'desc')
                           ->first();
        $isPaid = false;
        if ($paymentRow && strtolower($paymentRow['payment_status']) === 'paid') {
            $isPaid = true;
        }
        
        // Prepare the basic order data, including invoice_path and date
        $orderData = [
            'order_id'     => (string)$order['order_id'],
            'status'       => $order['status'],
            'total_amount' => $order['total_amount'] ? number_format($order['total_amount'], 2) : "0.00",
            'invoice_path' => isset($order['invoice_path']) ? (string)$order['invoice_path'] : null,
            'paid'         => $isPaid,
            'date'         => date("d F, Y", strtotime($order['created_at'])),
        ];
        
        // Fetch order items
        $orderDetailsModel = new \App\Models\OrderDetailsModel();
        $details = $orderDetailsModel->getOrderDetailsByOrderId($order['id']);
        $items   = [];
        foreach ($details as $detail) {
            $items[] = [
                'name'     => $detail['medicine_name'] ?? 'Unknown',
                'quantity' => $detail['quantity'] ?? 1,
            ];
        }
        $orderData['items'] = $items;
    
        // Fetch delivery address (if any)
        $addressRow = $this->deliveryAddressModel->where('order_id', $order['id'])->first();
        if ($addressRow) {
            $orderData['delivery_address'] = [
                'recipient' => $addressRow['recipient'] ?? null,
                'address'   => $addressRow['address_text'] ?? null,
                'lat_long'  => $addressRow['shared_location'] ?? null,
            ];
        } else {
            $orderData['delivery_address'] = null;
        }
        
        return $this->respond($orderData);
    }
    
    /**
     * Endpoint: /api/prescription/upload (POST)
     *
     * Expects a multipart/form-data request with:
     * - user_id: the user's ID (alternatively, you could fetch from session or token)
     * - prescription: the file (PDF or image)
     *
     * The endpoint stores the file in WRITEPATH.'uploads/prescriptions/' and then creates an order with the file path.
     *
     * Response:
     * {
     *    "order_id": "#MS-2025-... ",
     *    "order_db_id": 123,
     *    "message": "Prescription uploaded and order created successfully."
     * }
     */
    public function uploadPrescription()
    {
        // Retrieve user_id from POST data (or adjust as needed)
        $userId = $this->request->getVar('user_id');
        if (!$userId) {
            return $this->failValidationErrors('User ID is required.');
        }
        
        // Retrieve the uploaded file. 'prescription' is the form field name.
        $file = $this->request->getFile('prescription');
        if (!$file || !$file->isValid()) {
            return $this->failValidationErrors('A valid prescription file (PDF or image) is required.');
        }
        
        // Optionally validate file extension
        $allowedExtensions = ['pdf', 'png', 'jpg', 'jpeg', 'gif'];
        if (!in_array(strtolower($file->getClientExtension()), $allowedExtensions)) {
            return $this->failValidationErrors('Only PDF or image files are allowed.');
        }
        
        // Set upload directory (ensure this directory is writable)
        $uploadPath = WRITEPATH . 'uploads/prescriptions/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // Generate a unique file name and move the file
        $newName = $file->getRandomName();
        if (!$file->move($uploadPath, $newName)) {
            return $this->failServerError('Failed to store the prescription file.');
        }
        
        // Construct the file path to store (relative path; adjust if needed)
        $storedPath = 'uploads/prescriptions/' . $newName;
        
        // Create a new order using the OrderModel.
        $orderModel = new \App\Models\OrderModel();
        $uniqueOrderId = $this->generateOrderId();
        $orderDbId = $orderModel->createOrder($userId, $uniqueOrderId, $storedPath);
        
        if (!$orderDbId) {
            return $this->failServerError('Failed to create order.');
        }
        
        return $this->respond([
            'order_id'    => $uniqueOrderId,
            'order_db_id' => $orderDbId,
            'message'     => 'Prescription uploaded and order created successfully.'
        ]);
    }
    
    /**
     * Endpoint: /api/order/no-prescription (GET)
     *
     * Expects:
     *   user_id=<USER_ID>
     *
     * Creates a new order without a prescription, returning JSON:
     * {
     *   "order_id": "MS-2025-03-001",
     *   "order_db_id": 123,
     *   "message": "Order created without prescription. We will connect you soon."
     * }
     */
    public function createNoPrescriptionOrderGet()
    {
        // Retrieve user_id from query params (GET)
        $userId = $this->request->getGet('user_id');
        if (!$userId) {
            return $this->failValidationErrors('User ID is required.');
        }
    
        // 1. Generate a unique order ID
        $uniqueOrderId = $this->generateOrderId();
    
        // 2. Create a new order in the DB
        $orderDbId = $this->orderModel->createOrder($userId, $uniqueOrderId);
    
        if (!$orderDbId) {
            return $this->failServerError('Failed to create order.');
        }
    
        // 3. Return a JSON response
        return $this->respond([
            'order_id'    => $uniqueOrderId,
            'order_db_id' => $orderDbId,
            'message'     => 'Order created without prescription. We will connect you soon.'
        ]);
    }
    
    /**
     * Endpoint: /api/payment/create (GET)
     *
     * Expects:
     *   order_id=<CUSTOM_ORDER_ID>
     *
     * Creates a payment link for the specified order using Razorpay and returns:
     * {
     *   "order_id": "MS-2025-03-001",
     *   "payment_link": "https://rzp.io/l/xxxxx"
     * }
     */
    public function createPaymentLinkApi()
    {
        $customOrderId = $this->request->getGet('order_id');
        if (!$customOrderId) {
            return $this->response
                        ->setStatusCode(400)
                        ->setJSON(['error' => 'Order ID is required.']);
        }
        
        // Find the order by its custom order_id
        $order = $this->orderModel->where('order_id', $customOrderId)->first();
        if (!$order) {
            return $this->response
                        ->setStatusCode(404)
                        ->setJSON(['error' => "No order found with order_id = $customOrderId"]);
        }
        
        // Check if a pending payment already exists
        $existingPayment = $this->paymentModel
                                ->where('order_id', $order['id'])
                                ->where('payment_status', 'pending')
                                ->orderBy('id', 'desc')
                                ->first();
        
        if ($existingPayment && !empty($existingPayment['payment_link'])) {
            $responseData = [
                'order_id'     => (string)$order['order_id'],
                'payment_link' => (string)$existingPayment['payment_link']
            ];
            return $this->response->setJSON($responseData);
        }
        
        // Calculate final total (ensure total_amount is set in your order record)
        $finalTotal = (float) ($order['total_amount'] ?? 0.00);
        
        // Retrieve user details for Razorpay link creation
        $user = $this->userModel->find($order['user_id']);
        if (!$user) {
            return $this->response
                        ->setStatusCode(404)
                        ->setJSON(['error' => "User not found for the order."]);
        }
        
        // Create the Razorpay payment link using your existing logic
        $rpayResp = $this->createRazorpayPaymentLink(
            $order['order_id'],
            $finalTotal,
            $user['name'],
            substr($user['phone'], 2),
            'testuser@example.com'
        );
        
        if ($rpayResp) {
            $paymentLink = isset($rpayResp['short_url']) 
                           ? $rpayResp['short_url'] 
                           : (isset($rpayResp['payment_link']) ? $rpayResp['payment_link'] : '');
            $linkId = isset($rpayResp['id']) ? $rpayResp['id'] : '';
            
            // Create a payment record
            $this->paymentModel->createPaymentRecord($order['id'], $paymentLink);
            
            // Build response data, explicitly casting to strings
            $responseData = [
                'order_id'     => (string)$order['order_id'],
                'payment_link' => (string)$paymentLink
            ];
            
            $json = json_encode($responseData);
            if ($json === false) {
                return $this->response
                            ->setStatusCode(500)
                            ->setBody('JSON encoding error');
            }
            return $this->response
                        ->setContentType('application/json')
                        ->setBody($json);
        } else {
            return $this->response
                        ->setStatusCode(500)
                        ->setJSON(['error' => 'Failed to create payment link.']);
        }
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
     * Endpoint: /api/order/update-address (POST)
     *
     * Expects (POST body, JSON or form-data):
     *   order_id:   The custom order ID (e.g., MS-2025-03-001)
     *   recipient:  The name/relationship for the recipient (e.g., 'Myself', 'Father', etc.)
     *   address:    Full address text (optional if lat/long provided)
     *   latitude:   (optional)
     *   longitude:  (optional)
     *
     * Creates or updates the delivery address for the specified order.
     *
     * Returns JSON:
     * {
     *   "status": "success",
     *   "message": "Address updated successfully"
     * }
     */
    public function updateOrderAddress()
    {
        $orderId   = $this->request->getGet('order_id');
        $recipient = $this->request->getGet('recipient');
        $address   = $this->request->getGet('address');
        $latitude  = $this->request->getGet('latitude');
        $longitude = $this->request->getGet('longitude');
    
        // Basic validation
        if (!$orderId) {
            return $this->failValidationErrors('order_id is required.');
        }
    
        // Find the order by its custom order_id
        $order = $this->orderModel->where('order_id', $orderId)->first();
        if (!$order) {
            return $this->failNotFound("No order found with order_id = $orderId");
        }
    
        // Use default recipient if not provided
        if (!$recipient) {
            $recipient = 'Myself';
        }
    
        // Prepare data for DeliveryAddressModel
        $data = [
            'order_id'  => $order['id'],  // DB ID, not the custom string
            'recipient' => $recipient,
            'address_text'   => $address,
        ];
    
        // If latitude and longitude are provided, store them together.
        if ($latitude && $longitude) {
            $data['shared_location'] = "{$latitude},{$longitude}";
        }
    
        // Log the data for debugging (optional)
        log_message('error', 'Update Address GET Data: ' . print_r($data, true));
    
        try {
            // Check if an address record already exists for this order.
            $existingAddress = $this->deliveryAddressModel->where('order_id', $order['id'])->first();
            if ($existingAddress) {
                // Update existing address
                $this->deliveryAddressModel->update($existingAddress['id'], $data);
            } else {
                // Insert new address record
                $this->deliveryAddressModel->insert($data);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in updateOrderAddressGet: ' . $e->getMessage());
            return $this->failServerError("Exception: " . $e->getMessage());
        }
    
        return $this->respond([
            'status'  => 'success',
            'message' => 'Address updated successfully'
        ]);
    }
    
    public function getProfile()
    {
        $userId = $this->request->getVar('user_id');
        if (!$userId) {
            return $this->failValidationErrors('User ID is required.');
        }
        
        $user = $this->userModel->find($userId);
        if (!$user) {
            return $this->failNotFound('User not found.');
        }
        
        return $this->respond($user);
    }
    
    /**
     * GET /api/substitutes?search=<term>
     *
     * Returns a JSON array of substitution records
     * that match the search term in either composition or product_name
     * and are in Category A or B.
     */
    public function getSubstitutes()
    {
        $searchTerm = trim($this->request->getGet('search') ?? '');
        if ($searchTerm === '') {
            return $this->respond([]);
        }
    
        // 1) strip spaces & hyphens, lowercase
        $normalized = strtolower(str_replace([' ', '-'], '', $searchTerm));
    
        // 2) build the raw SQL snippets
        $nameLike = "REPLACE(REPLACE(LOWER(product_name), '-', ''), ' ', '') LIKE '%{$normalized}%'";
        $compLike = "REPLACE(REPLACE(LOWER(composition),    '-', ''), ' ', '') LIKE '%{$normalized}%'";
    
        // 3) one query to find the “best” product for composition
        $db       = \Config\Database::connect();
        $builder1 = $db->table('substitution');
        $builder1
            ->groupStart()
                ->where('category_manu', 'Category A')
                ->orWhere('category_manu', 'Category B')
            ->groupEnd()
            ->where($nameLike, null, false)   // raw SQL, no escaping
            ->limit(1);
    
        $product = $builder1->get()->getRowArray();
    
        // 4) pick composition
        $composition = $product['composition'] ?? $searchTerm;
        $normalizedComp = strtolower(str_replace([' ', '-'], '', $composition));
        // rebuild compLike for the chosen composition
        $compLike = "REPLACE(REPLACE(LOWER(composition), '-', ''), ' ', '') = '{$normalizedComp}'";
    
        // 5) fetch all A/B in that composition
        $builder2 = $db->table('substitution');
        $builder2
            ->groupStart()
                ->where('category_manu', 'Category A')
                ->orWhere('category_manu', 'Category B')
            ->groupEnd()
            ->where($compLike, null, false)
            ->distinct();
    
        $rows = $builder2->get()->getResultArray();
    
        // 6) highlight and sort
        $highlighted = $others = [];
        foreach ($rows as $r) {
            $n = strtolower(str_replace([' ', '-'], '', $r['product_name']));
            if (strpos($n, $normalized) !== false) {
                $r['highlight'] = true;
                $highlighted[]  = $r;
            } else {
                $others[] = $r;
            }
        }
        usort($others, fn($a, $b) => floatval($a['mrp']) <=> floatval($b['mrp']));
    
        return $this->respond(array_merge($highlighted, $others));
    }
    
    public function autocomplete()
    {
        // 1) read the "q" query-param
        $term = trim($this->request->getGet('q') ?? '');
        if ($term === '') {
            return $this->respond([]);
        }
    
        // 2) normalize: strip spaces & hyphens, lowercase
        $normalized = strtolower(str_replace([' ', '-'], '', $term));
    
        // 3) build and run the query
        $db      = \Config\Database::connect();
        $builder = $db->table('substitution');
    
        // tell CI we want DISTINCT product_name
        $builder
            ->select('product_name')
            ->distinct()
            // pass the entire raw LIKE expression as the first arg, then null + false
            ->where(
                "REPLACE(REPLACE(LOWER(product_name), '-', ''), ' ', '') LIKE '%{$normalized}%'",
                null,
                false
            )
            ->limit(10);
    
        $rows  = $builder->get()->getResultArray();
        $names = array_column($rows, 'product_name');
    
        return $this->respond($names);
    }
    
    private function docUploadsBaseDir(): string
    {
        return WRITEPATH . 'uploads/insurance_docs';
    }
    
    private function isAllowedDocExt(?string $ext): bool
    {
        $allowed = ['pdf','png','jpg','jpeg','webp','gif'];
        return $ext && in_array(strtolower($ext), $allowed, true);
    }
    
    /**
     * GET /api/insurance-documents?user_id=XX[&type=insurance_document|claim_document][&order_id=YY]
     * Returns existence flags + list (newest first).
     */
    public function insuranceDocuments()
    {
        $userId  = (int) $this->request->getGet('user_id');
        $type    = $this->request->getGet('type');
    
        if (!$userId) {
            return $this->failValidationErrors('user_id is required.');
        }
    
        $model = new InsuranceDocumentModel();
    
        // list query
        $builder = $model->where('user_id', $userId);
        if ($type)    $builder->where('type', $type);
    
        $rows = $builder->orderBy('uploaded_at', 'DESC')->findAll();
    
        // existence flags (per user)
        $hasInsurance = $model->where(['user_id'=>$userId,'type'=>'insurance_document'])->countAllResults() > 0;
        $hasClaim     = $model->where(['user_id'=>$userId,'type'=>'claim_document'])->countAllResults() > 0;
    
        $items = array_map(function($r){
            return [
                'id'          => (int)$r['id'],
                'user_id'     => (int)$r['user_id'],
                'type'        => (string)$r['type'],
                'uploaded_at' => (string)$r['uploaded_at'],
                'risk_score'  => $r['risk_score'],
                'risk_text'  => $r['risk_text'],
                'file_url'    => site_url("api/insurance-documents/{$r['id']}/file"),
                'filename'    => basename($r['document_path']),
            ];
        }, $rows);
    
        return $this->respond([
            'exists' => [
                'insurance_document' => $hasInsurance,
                'claim_document'     => $hasClaim,
            ],
            'items' => $items
        ]);
    }
    
    /**
     * POST /api/insurance-documents (multipart/form-data)
     * Fields: user_id, type (insurance_document|claim_document), file, [order_id]
     */
    public function uploadInsuranceDocument()
    {
        $userId  = (int) $this->request->getPost('user_id');
        $type    = (string) $this->request->getPost('type');
        $file    = $this->request->getFile('file');
    
        if (!$userId || !$type || !$file) {
            return $this->failValidationErrors('user_id, type and file are required.');
        }
        if (!in_array($type, ['insurance_document','claim_document'], true)) {
            return $this->failValidationErrors('Invalid type.');
        }
        if (!$file->isValid()) {
            return $this->failValidationErrors($file->getErrorString());
        }
        $ext = $file->getClientExtension();
        if (!$this->isAllowedDocExt($ext)) {
            return $this->failValidationErrors('Only PDF or image files are allowed.');
        }
    
        // Ensure directory exists: writable/uploads/insurance_docs/{user_id}
        $base = rtrim($this->docUploadsBaseDir(), '/');
        $dir  = $base . '/' . $userId;
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    
        // Unique name and move
        $newName = time() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);
        if (!$file->move($dir, $newName)) {
            return $this->failServerError('Failed to store file.');
        }
    
        // Save DB record with relative path from writable/uploads
        $relative = 'insurance_docs/' . $userId . '/' . $newName;
    
        $model = new InsuranceDocumentModel();
        $id = $model->insert([
            'user_id'       => $userId,
            'document_path' => $relative,
            'type'          => $type,
        ]);
    
        $row = $model->find($id);
    
        return $this->respondCreated([
            'message' => 'Uploaded',
            'item' => [
                'id'          => (int)$row['id'],
                'user_id'     => (int)$row['user_id'],
                'type'        => (string)$row['type'],
                'uploaded_at' => (string)$row['uploaded_at'],
                'file_url'    => site_url("api/insurance-documents/{$row['id']}/file"),
                'filename'    => basename($row['document_path']),
            ]
        ]);
    }
    
    /**
     * GET /api/insurance-documents/{id}
     * Basic metadata for one document.
     */
    public function getInsuranceDocument($id)
    {
        $model = new InsuranceDocumentModel();
        $row = $model->find((int)$id);
        if (!$row) return $this->failNotFound('Not found.');
    
        $row['file_url'] = site_url("api/insurance-documents/{$row['id']}/file");
        $row['filename'] = basename($row['document_path']);
        return $this->respond($row);
    }
    
    /**
     * DELETE /api/insurance-documents/{id}?user_id=XX
     * Deletes a single insurance document if it belongs to the given user.
     */
    public function deleteInsuranceDocument($id)
    {
        $id     = (int) $id;
        $userId = (int) $this->request->getGet('user_id'); // keep simple via query param
    
        if (!$id || !$userId) {
            return $this->failValidationErrors('id (path) and user_id (query) are required.');
        }
    
        $model = new InsuranceDocumentModel();
        $row   = $model->find($id);
        if (!$row) {
            return $this->failNotFound('Document not found.');
        }
    
        // Ownership check
        if ((int)$row['user_id'] !== $userId) {
            return $this->response->setStatusCode(403)->setJSON([
                'ok' => false,
                'message' => 'You are not allowed to delete this document.'
            ]);
        }
    
        // Resolve file path (same approach as streamInsuranceDocument)
        $relative = (string)$row['document_path']; // e.g. "insurance_docs/{userId}/{file}"
        $baseDir  = rtrim($this->docUploadsBaseDir(), '/'); // WRITEPATH.'uploads/insurance_docs'
        $full     = $baseDir . '/' . $relative;
    
        if (!is_file($full)) {
            // Fallback if $relative is already "insurance_docs/.."
            $full = WRITEPATH . 'uploads/' . $relative;
        }
    
        // Transaction for consistency
        $this->db->transStart();
        try {
            // 1) Delete file (if present)
            if (is_file($full)) {
                @unlink($full);
            }
    
            // 2) Delete DB row
            $model->delete($id);
    
            $this->db->transComplete();
        } catch (\Throwable $e) {
            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
            }
            log_message('error', 'deleteInsuranceDocument failed: ' . $e->getMessage());
            return $this->failServerError('Failed to delete the document.');
        }
    
        return $this->respondDeleted([
            'ok'      => true,
            'message' => 'Document deleted successfully.',
            'id'      => $id
        ]);
    }
    
    /**
     * GET /api/insurance-documents/{id}/file
     * Streams the stored file inline (PDF/images).
     */
    public function streamInsuranceDocument($id)
    {
        $model = new InsuranceDocumentModel();
        $row = $model->find((int)$id);
        if (!$row) {
            return $this->response->setStatusCode(404)->setBody('Not found');
        }
    
        $full = rtrim($this->docUploadsBaseDir(), '/') . '/' . $row['document_path'];
        // $row['document_path'] is relative to "insurance_docs/..", so fix if needed:
        if (!is_file($full)) {
            // Fallback if relative is like "insurance_docs/.."
            $full = WRITEPATH . 'uploads/' . $row['document_path'];
        }
        if (!is_file($full)) {
            return $this->response->setStatusCode(404)->setBody('Missing file');
        }
    
        $mime = mime_content_type($full) ?: 'application/octet-stream';
        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . basename($full) . '"')
            ->setBody(file_get_contents($full));
    }

    /**
     * POST/GET /api/coupon/verify
     * Body (JSON or form-data) OR query:
     *  - user_id (required)
     *  - code    (required)
     *
     * Looks up the user's phone from the DB, then validates the coupon for that phone:
     *   - status = active
     *   - within valid_from..valid_to
     *   - usage_count < usage_limit_per_coupon
     * On success increments usage_count.
     */
    public function verifyCoupon()
    {
        // GET-only: user_id & code
        $userId = $this->request->getGet('user_id');
        $code   = $this->request->getGet('code');
    
        if (!$userId || !$code) {
            return $this->response->setStatusCode(400)->setJSON([
                'ok' => false,
                'message' => 'user_id and code are required.'
            ]);
        }
    
        // 1) Fetch user (phone expected like 91XXXXXXXXXX)
        $user = $this->userModel->find((int)$userId);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'ok' => false,
                'message' => 'User not found.'
            ]);
        }
    
        $rawPhone = (string)($user['phone'] ?? '');
        if ($rawPhone === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'ok' => false,
                'message' => 'User does not have a phone number.'
            ]);
        }
    
        // 2) Normalize to last 10 digits for comparison
        $digitsUser = preg_replace('/\D+/', '', $rawPhone);   // strip non-digits (handles +91, spaces, - etc.)
        $phone10    = substr($digitsUser, -10);               // last 10 digits
        if (strlen($phone10) !== 10) {
            return $this->response->setStatusCode(400)->setJSON([
                'ok' => false,
                'message' => 'User phone number is invalid.'
            ]);
        }
    
        $couponCode = trim((string)$code);
    
        // 3) Find coupon by code + phone (match last 10 digits)
        //    Avoid MySQL 8-only functions; use nested REPLACE to strip common noise and then RIGHT(...,10)
        $db       = \Config\Database::connect();
        $builder  = $db->table('customer_coupons');
        $exprLast10 = "RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(customer_number,'+',''),'-',''),' ',''),'(',''),')',''),10)";
        $coupon   = $builder
            ->where('coupon_code', $couponCode)
            ->where("$exprLast10 =", $phone10, false)
            ->get()->getRowArray();
    
        if (!$coupon) {
            return $this->response->setStatusCode(404)->setJSON([
                'ok' => false,
                'message' => 'Invalid coupon for this user.'
            ]);
        }
    
        // 4) Check active
        if (strtolower($coupon['status']) !== 'active') {
            return $this->response->setStatusCode(403)->setJSON([
                'ok' => false,
                'message' => 'Coupon is not active.'
            ]);
        }
    
        // 5) Check date window
        $now = new \DateTimeImmutable('now');
        if (!empty($coupon['valid_from'])) {
            $from = new \DateTimeImmutable($coupon['valid_from']);
            if ($now < $from) {
                return $this->response->setStatusCode(403)->setJSON([
                    'ok' => false,
                    'message' => 'Coupon is not yet valid.'
                ]);
            }
        }
        if (!empty($coupon['valid_to'])) {
            $to = new \DateTimeImmutable($coupon['valid_to']);
            if ($now > $to) {
                return $this->response->setStatusCode(403)->setJSON([
                    'ok' => false,
                    'message' => 'Coupon has expired.'
                ]);
            }
        }
    
        // 6) Usage limits
        $totalLimit = (int)($coupon['usage_limit_per_coupon'] ?? 1);
        $used       = (int)($coupon['usage_count'] ?? 0);
        if ($used >= $totalLimit) {
            return $this->response->setStatusCode(403)->setJSON([
                'ok' => false,
                'message' => 'Coupon usage limit reached.'
            ]);
        }
    
        // 7) Increment usage_count atomically
        try {
            $this->db->transStart();
    
            // Lock row by re-reading and checking count (simple guard)
            $row = $db->table('customer_coupons')->where('id', $coupon['id'])->get()->getRowArray();
            if (!$row) {
                $this->db->transRollback();
                return $this->response->setStatusCode(409)->setJSON([
                    'ok' => false,
                    'message' => 'Coupon changed. Please retry.'
                ]);
            }
            $rowUsed  = (int)($row['usage_count'] ?? 0);
            $rowLimit = (int)($row['usage_limit_per_coupon'] ?? 1);
            if ($rowUsed >= $rowLimit) {
                $this->db->transRollback();
                return $this->response->setStatusCode(403)->setJSON([
                    'ok' => false,
                    'message' => 'Coupon usage limit reached.'
                ]);
            }
    
            $db->table('customer_coupons')->where('id', $row['id'])->update([
                'usage_count' => $rowUsed + 1,
                // optionally:
                // 'status' => ($rowUsed + 1) >= $rowLimit ? 'used_up' : $row['status'],
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);
    
            $this->db->transComplete();
        } catch (\Throwable $e) {
            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
            }
            return $this->response->setStatusCode(500)->setJSON([
                'ok' => false,
                'message' => 'Failed to consume coupon.'
            ]);
        }
    
        // 8) Success payload
        return $this->response->setJSON([
            'ok'      => true,
            'message' => 'Valid coupon',
            'data'    => [
                'coupon_code' => (string)$coupon['coupon_code'],
                'user'        => [
                    'id'    => (int)$user['id'],
                    'name'  => (string)($user['name'] ?? ''),
                    'phone' => (string)$rawPhone,
                ],
                'expires_at'  => (string)$coupon['valid_to'],
                'usage_left'  => max(0, $totalLimit - ($used + 1)),
            ]
        ]);
    }

    /**
     * POST /api/contact/submit
     *
     * Handles contact form submissions from the Connect page
     *
     * Expected POST data:
     *   - name: Full name of the person
     *   - email: Email address
     *   - phone: Phone number
     *   - interest: Area of interest (jobs, business, csr, other)
     *   - subject: Subject of the message
     *   - message: The actual message
     *
     * Returns JSON:
     * {
     *   "success": true,
     *   "message": "Thank you for reaching out! We will get back to you soon."
     * }
     */
    public function submitContactForm()
    {
        // Get POST data
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $interest = $this->request->getPost('interest');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');

        // Validate required fields
        if (!$name || !$email || !$phone || !$interest || !$subject || !$message) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'All fields are required.'
            ]);
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Invalid email address.'
            ]);
        }

        // Get IP address
        $ipAddress = $this->request->getIPAddress();

        // Save to database
        $contactModel = new \App\Models\ContactSubmissionsModel();
        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'interest' => $interest,
                'subject' => $subject,
                'message' => $message,
                'ip_address' => $ipAddress,
                'status' => 'new'
            ];

            $contactModel->insert($data);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Thank you for reaching out! We will get back to you soon.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Contact form submission error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Sorry, there was an error processing your request. Please try again.'
            ]);
        }
    }

}