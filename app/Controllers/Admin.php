<?php

namespace App\Controllers;

class Admin extends BaseController {

    public $adminAuthModel;
    protected $userModel, $orderModel, $orderDetailsModel, $medicinesMasterModel;
    
    private $gupshupapi = 'sk_81e432833f0b492586a196465721219d';
    private $source = '917249426487';
    
    
    public function __construct() {
        $this->adminAuthModel = model('App\Models\Admin\AdminModel');
        $this->userModel  = model('App\Models\UserModel');  
        $this->orderModel = model('App\Models\OrderModel');
        $this->orderDetailsModel = model('App\Models\OrderDetailsModel');
        $this->medicinesMasterModel = model('App\Models\MedicinesMasterModel');
        $this->couponModel = model('App\Models\CouponModel');
    }

    // ===================================
    // Existing Methods (Authentication, etc.)
    // ===================================
    
    public function login() {
        if($this->checkSession())
            return redirect()->to(base_url('admin/dashboard'));

        echo view('admin/login');
        $this->showAlert();
    }

    public function login_submit() {
        $userId = addslashes($this->request->getPost('userid', FILTER_SANITIZE_STRING));
        $password = hash('sha256', $this->request->getPost('password'));

        $isValid = $this->adminAuthModel->where(['userid' => $userId, 'password' => $password])->findAll();
        if(count($isValid) > 0) {
            $this->session->set(['adminId' => $isValid[0]['id']]);
            return redirect()->to(base_url('admin/dashboard'));
        } else {
            $this->session->setFlashdata('error', 'Please check userid or password.');
            return redirect()->to(base_url('admin/login'));
        }
    }

    public function logout() {
        $this->session->remove('adminId');
        return redirect()->to(base_url('admin/login'));
    }

    public function dashboard() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));
        
        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/dashboard');
        echo view('admin/layouts/footer');
        $this->showAlert();
    }

    public function profile() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));
        
        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/profile');
        echo view('admin/layouts/footer');
        $this->showAlert();
    }

    // ===================================
    // NEW METHODS FOR MEDISOLDIER TABLES
    // ===================================

    // 1. USERS
    public function users() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();

        // CSRF tokens
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        // Set the table to 'users'
        $crud->setTable('users');
        // For example, display phone & name more clearly:
        $crud->displayAs('phone', 'Phone Number');

        // If you want to prevent adding new users in admin, you can:
        $crud->unsetAdd();$crud->unsetAdd();

        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        
        $css_files = $output->css_files;
        $js_files  = $output->js_files;
        $output    = $output->output;

        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "Users",
            'output'      => $output
        ];  

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
    }

    // 2. PINCODES
    public function pincodes() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('pincodes');
        // 'is_available' is enum('available','unavailable'), you might want to set a dropdown
        // For example:
        // $crud->fieldType('is_available', 'dropdown', ['available' => 'Available', 'unavailable' => 'Unavailable']);

        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        
        $css_files = $output->css_files;
        $js_files  = $output->js_files;
        $output    = $output->output;

        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "Pincodes",
            'output'      => $output
        ];  

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
    }

    public function orders()
    {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));
    
        $crud = $this->_getGroceryCrudEnterprise();
    
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
    
        $crud->setTable('orders');
        $crud->setRelation('user_id', 'users', 'name');
    
        $crud->displayAs('order_id', 'Order ID');
        $crud->displayAs('user_id', 'User');
        // $crud->fieldType('prescription_path', 'url');
        
        $crud->callbackReadField('prescription_path', function($value, $primaryKey, $row) {
            $baseUrl = "https://medisoldier.sodiarc.in/"; // Change this to your desired base URL
            if (strpos($value, "https") !== 0) {
                 $value = $baseUrl . ltrim($value, "/");
            }
            return '<a href="' . esc($value) . '" target="_blank">' . esc($value) . '</a>';
        });
    
        $crud->defaultOrdering('id','desc');
        $crud->unsetAdd();
        $crud->unsetDelete();
    
        // Add a custom action button
        $crud->setActionButton('Order Details', 'fa fa-file', function ($row) {
            return '/admin/editOrderDetails/' . $row->order_id;
        }, false);
    
        // Make the prescription_path clickable in Read/Modal
        $crud->callbackReadField('prescription_path', function($value, $primaryKey, $row) {
            return '<a href="' . esc($value) . '" target="_blank">' . esc($value) . '</a>';
        });
    
        // We only want read/edit
        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();
    
        // If you want to filter by ?status=...
        $selectedStatus = $this->request->getGet('status');
        if(!empty($selectedStatus)) {
            $crud->where(['status' => $selectedStatus]);
        }
    
        // --------------------------------------------
        // 1) Callback to detect changes after update
        // --------------------------------------------
        $crud->callbackAfterUpdate(function ($stateParameters) {
            // $stateParameters->primaryKeyValue is the 'id' of the updated orders row
            // You can fetch the updated row and do further logic
            $orderId = $stateParameters->primaryKeyValue;
    
            // We'll load the models inside the callback or from $this
            $orderModel = model('App\Models\OrderModel');
            $userModel  = model('App\Models\UserModel');
            $userSessionModel = model('App\Models\UserSessionModel');
    
            // 1. Fetch the updated order
            $updatedOrder = $orderModel->find($orderId);
            if (!$updatedOrder) {
                // No order found, do nothing
                return $stateParameters;
            }
    
            // 2. Get the user phone
            $userRow = $userModel->find($updatedOrder['user_id']);
            if (!$userRow) {
                // No user found, do nothing
                return $stateParameters;
            }
    
            $phone = $userRow['phone'];
            $newStatus = $updatedOrder['status'];  // e.g. 'packed', 'delivered', etc.
    
            // 3. Send a WhatsApp message about the new status
            //    We'll create a small helper function or inline
            $msg = "Your order (ID: {$updatedOrder['order_id']}) status is now: {$newStatus}";
            
            // Using your existing "sendMessage($phone, $message)" from the Home or from a trait
            // If it's in the same controller, do $this->sendMessage($phone, $msg).
            // If not, define a small function or code inline:
            $this->sendMessage($phone, $msg);
    
            // 4. If status is 'cancelled' or 'delivered', close the user session
            if (in_array($newStatus, ['cancelled', 'delivered'])) {
                // If there's an active session for this phone, we delete it
                $sessionRow = $userSessionModel->getSessionByPhone($phone);
                if ($sessionRow) {
                    $userSessionModel->delete($sessionRow['id']);
                }
            }
    
            // Return $stateParameters so Grocery CRUD continues normally
            return $stateParameters;
        });
    
        // --------------------------------------------
        // 2) End of callback setup
        // --------------------------------------------
    
        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
    
        $css_files = $output->css_files;
        $js_files  = $output->js_files;
        $finalHtml = $output->output; 
    
        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "Orders",
            'output'      => $finalHtml
        ];  
    
        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
    }


    // 4. ORDER DETAILS
    public function order_details() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('order_details');
        // Example relation to 'orders' if needed:
        $crud->setRelation('order_id', 'orders', 'order_id');
        $crud->defaultOrdering('id','desc');
        
        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $css_files = $output->css_files;
        $js_files  = $output->js_files;
        $output    = $output->output;

        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "Order Details",
            'output'      => $output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
    }

    // 5. DELIVERY ADDRESSES
    public function delivery_addresses() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('delivery_addresses');
        // relation to orders
        $crud->setRelation('order_id', 'orders', 'order_id');

        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $css_files = $output->css_files;
        $js_files  = $output->js_files;
        $output    = $output->output;

        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "Delivery Addresses",
            'output'      => $output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
    }

    // 6. PAYMENTS
    public function payments() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('payments');
        // For example, link to 'orders'
        $crud->setRelation('order_id', 'orders', 'order_id');
        $crud->displayAs('payment_status', 'Status');
        $crud->defaultOrdering('id', 'desc');

        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $css_files = $output->css_files;
        $js_files  = $output->js_files;
        $output    = $output->output;

        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "Payments",
            'output'      => $output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
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
    
    // 7. INSURANCE DOCUMENTS
    public function insurance_documents()
    {
        if (!$this->checkSession()) {
            return redirect()->to(base_url('admin/login'));
        }
    
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
    
        $crud->setTable('insurance_documents');
    
        // Only user_id remains as relation
        $crud->setRelation('user_id', 'users', 'name');
    
        // Handle file uploads for 'document_path'
        // Actual server storage (WRITEPATH = writable/)
        $crud->callbackColumn('document_path', function ($value, $row) {
            return '<a href="' . site_url("api/insurance-documents/{$row->id}/file") . '" target="_blank">View</a>';
        });
    
        // Optional: choose which fields are editable
        $crud->columns(['user_id', 'document_path', 'risk_score', 'risk_text', 'type', 'uploaded_at']);
        $crud->fields(['user_id', 'document_path', 'risk_score', 'risk_text', 'type']);
    
        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();
    
        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
    
        $data = [
            'css_files'   => $output->css_files,
            'js_files'    => $output->js_files,
            'breadcrumbs' => "Insurance Documents",
            'output'      => $output->output
        ];
    
        echo view('admin/layouts/header', ['data' => $this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
    }

    // 8. ORDER STATUS HISTORY
    public function order_status_history() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('order_status_history');
        $crud->setRelation('order_id', 'orders', 'order_id');

        // Possibly rename columns:
        $crud->displayAs('status', 'Order Status');
        // If you want to limit the dropdown to certain statuses, you can do:
        // $crud->fieldType('status', 'dropdown', [
        //     'pending' => 'Pending',
        //     'review' => 'Review',
        //     'packed' => 'Packed',
        //     'delivered' => 'Delivered',
        //     'cancelled' => 'Cancelled'
        // ]);

        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $css_files = $output->css_files;
        $js_files  = $output->js_files;
        $output    = $output->output;

        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "Order Status History",
            'output'      => $output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
    }
    
    public function admins()
    {
        if (!$this->checkSession()) {
            return redirect()->to(base_url('admin/login'));
        }
    
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
    
        // Table & subject
        $crud->setTable('admin'); // your table name is exactly `admin`
        $crud->setSubject('Distributor User', 'Distributor Users');
        $crud->where(['type' => 'DISTRIBUTOR']);
    
        // List columns (hide password)
        $crud->columns(['userid', 'type']);
    
        // Form fields
        $crud->fields(['userid', 'password', 'type']);
    
        // Required & unique
        $crud->requiredFields(['userid', 'type']); // password required only on Add (handled below)
        $crud->uniqueFields(['userid']);
    
        // Labels
        $crud->displayAs([
            'userid'   => 'User ID',
            'password' => 'Password',
            'type'     => 'Account Type'
        ]);
    
        // Type dropdown
        $crud->fieldType('type', 'dropdown', [
            'ADMIN'       => 'ADMIN',
            'DISTRIBUTOR' => 'DISTRIBUTOR'
        ]);
    
        // Validation rules (GCE expects array format)
        // $crud->setRules([
        //     ['field' => 'userid', 'label' => 'User ID', 'rules' => 'min_length[3]|max_length[255]'],
        //     ['field' => 'type',   'label' => 'Account Type', 'rules' => 'in_list[ADMIN,DISTRIBUTOR]'],
        //     // Password rules are applied conditionally in callbacks
        // ]);
    
        // Require password on ADD only
        $crud->callbackAddForm(function($state) {
            // Nothing to change in the form; requirement is enforced before insert
            return $state;
        });
    
        // Hash password on ADD; enforce provided
        $crud->callbackBeforeInsert(function($stateParameters) {
            $data = $stateParameters->data ?? [];
    
            if (empty($data['password'])) {
                // Fail gracefully with validation-like message
                throw new \Exception('Password is required.');
            }
    
            // CI4 hash used in your login flow: sha256
            $data['password'] = hash('sha256', $data['password']);
    
            $stateParameters->data = $data;
            return $stateParameters;
        });
    
        // Hash password on UPDATE only if provided (keep old if left blank)
        $crud->callbackBeforeUpdate(function($stateParameters) {
            $data = $stateParameters->data ?? [];
    
            if (array_key_exists('password', $data)) {
                $pwd = trim((string)$data['password']);
                if ($pwd === '') {
                    // Remove empty password to avoid overwriting with blank
                    unset($data['password']);
                } else {
                    $data['password'] = hash('sha256', $pwd);
                }
            }
    
            $stateParameters->data = $data;
            return $stateParameters;
        });
    
        // Optional safety: prevent deletes on admin accounts
        // (remove these two lines if you want deletes)
        $crud->unsetDelete();
    
        // Cosmetics / assets like in your other methods
        $crud->unsetBootstrap();
        $crud->unsetJquery();
    
        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
    
        $css_files = (array)($output->css_files ?? []);
        $js_files  = (array)($output->js_files ?? []);
        $finalHtml = $output->output;
    
        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => 'Admin Users',
            'output'      => $finalHtml
        ];
    
        echo view('admin/layouts/header', ['data' => $this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }

    
    public function customer_coupons()
    {
        if (!$this->checkSession()) {
            return redirect()->to(base_url('admin/login'));
        }
    
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
    
        $crud->setTable('customer_coupons');
        $crud->setSubject('Coupon', 'Coupons');
    
        // Show distributor (admin.userid) via relation
        $crud->setRelation('account_id', 'admin', 'userid');
        
        $adminId = (int) $this->session->adminId;
        $adminType = (string) ($this->session->type ?? ''); // e.g. 'distributor' or 'admin'
    
        if ($adminId != 1) {
            // Filters LIST/READ queries
            $crud->where('customer_coupons.account_id', $adminId);
        }
    
        // ---- List columns (include coupon_code for visibility) ----
        $crud->columns([
            'coupon_code', 'status',
            'customer_name', 'customer_number', 'customer_pincode',
            'account_id',
            'usage_count',
            'valid_from', 'valid_to',
            'updated_at'
        ]);
        
        
    
        // ---- Form fields (do NOT show coupon_code / valid_* / usage limits) ----
        // account_id is displayed but disabled; value forced from session
        $crud->fields([
            'account_id',
            'customer_name', 'customer_number', 'customer_pincode',
            'status'
        ]);
    
        // Required (account_id is injected)
        $crud->requiredFields([
            'customer_name', 'customer_number', 'customer_pincode'
        ]);
    
        $crud->uniqueFields(['coupon_code']);
    
        $crud->displayAs([
            'account_id'               => 'Distributor',
            'customer_name'            => 'Customer Name',
            'customer_number'          => 'Customer Number',
            'customer_pincode'         => 'Customer Pincode',
            'coupon_code'              => 'Coupon Code',
            'status'                   => 'Status',
            'usage_count'              => 'Used',
            'valid_from'               => 'Valid From',
            'valid_to'                 => 'Valid To',
            'updated_at'               => 'Last Updated'
        ]);
    
        $crud->fieldType('status', 'dropdown', [
            'active'   => 'Active',
            'inactive' => 'Inactive',
            'expired'  => 'Expired',
            'used_up'  => 'Used Up'
        ]);
    
        // ---- Make account_id read-only and prefilled with session adminId ----
        $crud->callbackAddField('account_id', function () {
            $adminId = (int)$this->session->adminId;
            $db = \Config\Database::connect();
            $label = (string)$db->table('admin')->select('userid')->where('id', $adminId)->get()->getRow('userid');
            return '
                <input type="text" class="form-control" value="'.esc($label).'" disabled>
                <input type="hidden" name="account_id" value="'.esc($adminId).'">
            ';
        });
    
        $crud->callbackEditField('account_id', function ($value, $primaryKey) {
            // Keep original value for display; still lock to session on save
            $adminId = (int)$this->session->adminId;
            $db = \Config\Database::connect();
            $label = (string)$db->table('admin')->select('userid')->where('id', $value ?: $adminId)->get()->getRow('userid');
            return '
                <input type="text" class="form-control" value="'.esc($label).'" disabled>
                <input type="hidden" name="account_id" value="'.esc($value ?: $adminId).'">
            ';
        });
    
        // ---- Before Insert: enforce defaults & generate coupon ----
        $crud->callbackBeforeInsert(function ($state) {
            $data = $state->data ?? [];
    
            // Always trust session for account_id
            $data['account_id'] = (int)$this->session->adminId;
    
            // Auto-code like bulk
            if (empty($data['coupon_code'])) {
                $data['coupon_code'] = $this->generateUniqueCouponCode($this->couponModel);
            }
    
            // Clean phone (no spaces)
            if (!empty($data['customer_number'])) {
                $data['customer_number'] = preg_replace('/\s+/', '', $data['customer_number']);
            }
    
            // Defaults (not shown in form)
            $now = new \DateTime();
            $data['valid_from'] = $now->format('Y-m-d H:i:s');
            $data['valid_to']   = (clone $now)->modify('+1 year')->format('Y-m-d H:i:s');
            $data['usage_limit_per_coupon']   = 1;
            $data['usage_limit_per_customer'] = 1;
            $data['usage_count']  = 0;
            $data['redeemed_at']  = null;
    
            $state->data = $data;
            return $state;
        });
    
        // ---- After Insert: send WhatsApp TEMPLATE message with copyable code ----
        $crud->callbackAfterInsert(function ($state) {
            try {
                // Fetch the inserted row to get fields (esp. coupon_code)
                $id = $state->insertId;
                $row = $this->couponModel->find($id);
                if ($row) {
                    $name = (string)$row['customer_name'];
                    $phone = (string)$row['customer_number'];
                    $code  = (string)$row['coupon_code'];
    
                    // Prefix 91 if needed (your note: "91 will not come in customer_phone number u have to prefix it")
                    $dest = $this->normalizeIndianMsisdn($phone); // returns like 91XXXXXXXXXX
    
                    // Send template; param[2] below is used by the "Copy Offer Code" button in your approved template
                    $this->sendTemplateMessage(
                        $dest,
                        $name,
                        $code,
                        // Optional: image to show in template (same one from your cURL)
                        'https://fss.gupshup.io/0/public/0/0/gupshup/917249426487/b617e912-fa75-45be-95ef-2907c0cd8973/1756140974720_PHOTO-2025-08-24-21-06-38.jpg'
                    );
                }
            } catch (\Throwable $e) {
                log_message('error', 'Template send failed: '.$e->getMessage());
            }
            return $state;
        });
    
        // ---- Before Update: keep account/session binding, never change coupon code ----
        $crud->callbackBeforeUpdate(function ($state) {
            $data = $state->data ?? [];
            $data['account_id'] = (int)$this->session->adminId;
    
            if (isset($data['customer_number'])) {
                $data['customer_number'] = preg_replace('/\s+/', '', $data['customer_number']);
            }
            unset($data['coupon_code'], $data['usage_limit_per_coupon'], $data['usage_limit_per_customer'], $data['valid_from'], $data['valid_to']);
    
            $state->data = $data;
            return $state;
        });
    
        $crud->defaultOrdering('updated_at', 'desc');
        $crud->unsetBootstrap();
        $crud->unsetJquery();
    
        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
    
        $css_files = (array)($output->css_files ?? []);
        $js_files  = (array)($output->js_files ?? []);
        $html      = $output->output;
    
        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "Customer Coupons",
            'output'      => $html
        ];
    
        echo view('admin/layouts/header', ['data' => $this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }
    

    // 9. USER SESSIONS
    public function user_sessions() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('user_sessions');
        // If you want to show phone in a more friendly way:
        $crud->displayAs('phone', 'User Phone');
        // Possibly hide session_data if it’s too big or just text?

        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->setRead();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $css_files = $output->css_files;
        $js_files  = $output->js_files;
        $output    = $output->output;

        $data = [
            'css_files'   => $css_files,
            'js_files'    => $js_files,
            'breadcrumbs' => "User Sessions",
            'output'      => $output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', (array)$data);
        echo view('admin/layouts/footer');
    }
    
    // CUSTOM UI
    public function listPendingReviewOrders()
    {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));
        // Suppose 'review' means it's waiting for admin to fill in details
        $orders = $this->orderModel->where('status', 'pending')->findAll();
        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/list_pending_orders', ['orders' => $orders]);
        echo view('admin/layouts/footer');
        $this->showAlert();
    }
    
    public function editOrderDetails($orderId)
    {
        if (!$this->checkSession()) {
            return redirect()->to(base_url('admin/login'));
        }
    
        // 1. Get the order
        $orderRow = $this->orderModel->where('order_id', $orderId)->first();
        if (!$orderRow) {
            return redirect()->back()->with('error','Order not found');
        }
    
        // 2. Get existing order_details
        $lineItems = $this->orderDetailsModel->where('order_id', $orderRow['id'])->findAll();
    
        // 3. If you have a medicines_master table, fetch for a dropdown
        $allMedicines = $this->medicinesMasterModel->findAll();
    
        // 4. Prepare the invoice info & total_amount for the view
        $existingInvoicePath = $orderRow['invoice_path'] ?? '';   // e.g. "uploads/invoices/myfile.pdf"
        $existingTotalAmount = $orderRow['total_amount'] ?? 0.00; // e.g. "1234.00"
    
        // 5. Render a view
        echo view('admin/layouts/header', ['data' => $this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/edit_order_details', [
            'order'             => $orderRow,
            'lineItems'         => $lineItems,
            'allMedicines'      => $allMedicines,
            'existingInvoice'   => $existingInvoicePath,
            'existingTotalAmt'  => $existingTotalAmount
        ]);
        echo view('admin/layouts/footer');
        $this->showAlert();
    }
    

    
    public function updateOrderDetails()
    {
        $orderId   = $this->request->getPost('order_id');
        $finalAmt  = (float) $this->request->getPost('total_amount');
        
        $this->storeFinalTotal($orderId, $finalAmt);
    
        // Arrays
        $medicineNames   = $this->request->getPost('medicine_name');
        $quantities      = $this->request->getPost('quantity');
        $purchasePrices  = $this->request->getPost('purchase_price');
        $salePrices      = $this->request->getPost('sale_price');
    
        // 1. Find the order
        $orderRow = $this->orderModel->where('order_id', $orderId)->first();
        if (!$orderRow) {
            return redirect()->back()->with('error','Order not found');
        }
      
       $invoiceFile = $this->request->getFile('invoice_file');
        if ($invoiceFile && $invoiceFile->isValid()) {
            // 2. Generate a random name
            $newName = $invoiceFile->getRandomName();
        
            // 3. Move it to the "public/uploads/invoices" folder
            //    NOTE: use ROOTPATH to get the project root
            $invoiceFile->move(ROOTPATH . 'public/uploads/invoices', $newName);
        
            // 4. Build a relative or absolute URL that the user can access
            //    e.g. base_url('uploads/invoices/filename.pdf')
            $invoicePath = 'uploads/invoices/' . $newName;
        
            // or for a fully qualified URL:
            $invoiceUrl  = base_url('public/uploads/invoices/'.$newName);
        
            // 5. If needed, send the file via WhatsApp
            $user = $this->userModel->find($orderRow['user_id']);
            if ($user) {
                $phone = $user['phone']; // or wherever the phone is stored
            
                if (!empty($invoiceUrl)) {
                    $this->sendFileMessage($phone, $invoiceUrl, "Here is your invoice...");
                }
            }
        }
    
        // 3. Delete existing line items
        // $this->orderDetailsModel->where('order_id', $orderRow['id'])->delete();
    
        // 4. Insert new line items & compute totals
        $totalPurchase = 0.00;
        
        // 4. Insert new line items & compute totals
        $totalSale = 0.00;
        $totalPurchase = 0.00;
    
        foreach ($medicineNames as $idx => $mName) {
            $qty   = (int) $quantities[$idx];
            $pCost = (float) $purchasePrices[$idx];  // purchase price
            $sCost = (float) $salePrices[$idx];      // sale price
            $this->orderDetailsModel->insert([
                'order_id'       => $orderRow['id'],
                'medicine_name'  => $mName,
                'quantity'       => $qty,
                'purchase_price' => $pCost,
                'sale_price'     => $sCost
            ]);
    
            $totalPurchase += ($qty * $pCost);
        }
    
        // 5. Update order table
        //    - status -> 'review' or keep your logic
        //    - total_amount -> $totalSale
        //    - total_purchase? you can add a column in 'orders' or store it separately
        //    - invoice_path if we uploaded a file
        $updateData = [
            'status'            => 'review',
            'invoice_path'      => $invoicePath ?? null,  // store path if not null
            'total_purchase'    => $totalPurchase // if you have a column 'total_purchase'
        ];
    
        // If invoice wasn't uploaded, keep it unchanged
        if (!isset($invoicePath)) {
            unset($updateData['invoice_path']);
        }
    
        $this->orderModel->update($orderRow['id'], $updateData);
    
        // 6. We want to send the invoice along with the payment link if invoice was uploaded
        //    Let's see how we create the payment link
        $user = $this->userModel->find($orderRow['user_id']);
        // We'll do our "adminupdate" or "invoiceupdate" -> up to you
        $this->triggerChatbotAdminUpdate($user['phone']);
    
        return redirect()->to('orders?status=review')->with('success','Order updated & Admin Update triggered!');
    }
    
    public function storeFinalTotal($orderId, $finalAmt)
    {
        // 1. Find the matching row in the orders table
        $orderRow = $this->orderModel->where('order_id', $orderId)->first();
        if (!$orderRow) {
            // You can handle the case if the order doesn't exist
            return false;
        }
    
        // 2. Update the orders table
        $this->orderModel->update($orderRow['id'], [
            'total_amount' => $finalAmt,
            // Optionally set 'status' => 'review' or anything else:
            // 'status' => 'review'
        ]);
    
        return true;
    }
    
    private function triggerChatbotAdminUpdate($userPhone)
    {
        // Suppose your chatbot is at /home/webhook
        $webhookUrl = base_url('webhook'); 
        $data = [
            "app"       => "MediSoldier",            // as in your example
            "timestamp" => time() * 1000,            // approximate ms-based timestamp
            "version"   => 2,                        // version from your sample
            "type"      => "message",
            "payload"   => [
                "id"      => "wamid.HBg" . uniqid(), // a placeholder or unique ID
                "source"  => $userPhone,             // user phone as 'source', if you want
                "type"    => "text",                 // message type is text
                "payload" => [
                    "text" => "adminupdate"          // <-- we want to pass "adminupdate" here
                ],
                "sender" => [
                    "phone"         => $userPhone,    
                    "name"          => "Admin Trigger", // or any placeholder name
                    "country_code"  => "91",            // adjust if needed
                    "dial_code"     => substr($userPhone, 2) // e.g. 8276048671 if phone is 918276048671
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



    // ---------------------------------------
    // HELPER FUNCTIONS
    // ---------------------------------------
    
    public function checkSession() {
        $flag = true;
        if($this->session->has('adminId') && $this->session->adminId != '') {
            $isValid = $this->adminAuthModel->where('id', $this->session->adminId)->findAll();
            if(count($isValid) <= 0) {
                $flag = false;
            } else {
                $this->data = $this->getUserData();
            }
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function getUserData() {
        return $this->adminAuthModel->where('id', $this->session->adminId)->findAll();
    }
    
    
    /**
     * Send WhatsApp message via Gupshup
     */
    private function sendFileMessage($phone, $fileUrl, $caption = '')
    {
        $url    = 'https://api.gupshup.io/wa/api/v1/msg';
        $apiKey = $this->gupshupapi; 
        $source = $this->source;  
    
        // Detect file extension to decide between 'type' => 'image' or 'file'
        $ext = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
    
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Send it as an image
            $payload = [
                'type'        => 'image',
                'previewUrl'  => $fileUrl,   // Gupshup expects these fields for image
                'originalUrl' => $fileUrl,
                'caption'     => $caption,
                'filename'    => basename($fileUrl)
            ];
        } else {
            // Otherwise, treat it as a generic file (PDF, docx, etc.)
            $payload = [
                'type'     => 'file',
                'url'      => $fileUrl,
                'caption'  => $caption,
                'filename' => basename($fileUrl)
            ];
        }
    
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
    
    // === COUPON BULK UPLOAD ===
    
    public function couponBulkUploadForm()
    {
        if (!$this->checkSession()) {
            return redirect()->to(base_url('admin/login'));
        }
    
        $data = [
            'breadcrumbs' => 'Bulk Upload Coupons',
            'templateUrl' => base_url('admin/coupons/bulk-template'),
            'flashError'  => session()->getFlashdata('error'),
            'flashSuccess'=> session()->getFlashdata('success')
        ];
    
        echo view('admin/layouts/header', ['data' => $this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/coupons_bulk_upload_form', $data);
        echo view('admin/layouts/footer');
    }
    
    public function couponBulkTemplate()
    {
        if (!$this->checkSession()) {
            return redirect()->to(base_url('admin/login'));
        }
    
        // We no longer include valid_from, valid_to, or usage_limit columns.
        // They are set by the server with defaults.
        $headers = [
            'customer_name',
            'customer_pincode',
            'customer_number',
            'status' // optional; defaults to active
        ];
    
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=coupon_upload_template.csv');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
    
        fputcsv($out, $headers);
        // Example rows
        fputcsv($out, ['John Doe','560001','+919876543210','active']);
        fputcsv($out, ['Jane Smith','110011','9876543210','']); // status empty -> active
    
        fclose($out);
        exit;
    }

    
    public function couponBulkUploadProcess()
    {
        if (!$this->checkSession()) {
            return redirect()->to(base_url('admin/login'));
        }
    
        helper(['form']);
    
        $rules = [
            'csv_file' => [
                'label' => 'CSV File',
                'rules' => 'uploaded[csv_file]|ext_in[csv_file,csv]|max_size[csv_file,4096]'
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', implode(' ', $this->validator->getErrors()));
        }
    
        $file = $this->request->getFile('csv_file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file upload.');
        }
    
        $adminId = (int)$this->session->adminId;
        if ($adminId <= 0) {
            return redirect()->back()->with('error', 'Invalid admin session.');
        }
    
        $path = $file->getTempName();
    
        // --- Detect delimiter by sampling first line ---
        $firstLine = '';
        if ($fh = fopen($path, 'r')) {
            $firstLine = fgets($fh, 1048576) ?: '';
            fclose($fh);
        }
        $candidates = [',', ';', "\t", '|'];
        $delimiter = ',';
        $bestCount = 1;
        foreach ($candidates as $d) {
            $parts = str_getcsv($firstLine, $d);
            if (count($parts) > $bestCount) {
                $bestCount = count($parts);
                $delimiter = $d;
            }
        }
    
        // --- Open and read header with detected delimiter ---
        $handle = fopen($path, 'r');
        if (!$handle) {
            return redirect()->back()->with('error', 'Unable to read the uploaded CSV.');
        }
        $rawHeader = fgetcsv($handle, 0, $delimiter);
        if (!$rawHeader) {
            fclose($handle);
            return redirect()->back()->with('error', 'CSV appears empty or malformed.');
        }
    
        // --- Normalize header (strip BOM/NBSP/quotes, map aliases) ---
        $normalizeHeader = function (string $h): string {
            $h = preg_replace('/^\xEF\xBB\xBF/', '', $h);     // BOM
            $h = str_replace("\xC2\xA0", ' ', $h);           // NBSP
            $h = trim($h, " \t\n\r\0\x0B\"'");
            $h = preg_replace('/\s+/', ' ', $h);
            $h = strtolower(trim($h));
    
            static $aliases = [
                'name'           => 'customer_name',
                'customer name'  => 'customer_name',
                'pincode'        => 'customer_pincode',
                'pin code'       => 'customer_pincode',
                'phone'          => 'customer_number',
                'mobile'         => 'customer_number',
                'customer phone' => 'customer_number',
                // status is optional; keep as-is if present
            ];
            if (isset($aliases[$h])) return $aliases[$h];
            return str_replace([' ', '-'], '_', $h);
        };
    
        $header = array_map(fn($h) => $normalizeHeader((string)$h), $rawHeader);
        $idx = array_flip($header);
    
        // --- Required columns: only these three now ---
        $must = ['customer_name','customer_pincode','customer_number'];
        foreach ($must as $col) {
            if (!array_key_exists($col, $idx)) {
                fclose($handle);
                $seen = implode(', ', $header);
                return redirect()->back()->with('error', "Missing required column: {$col}. Found headers: {$seen}");
            }
        }
    
        // Helper to get by name safely
        $get = function(array $row, string $name) use ($idx): string {
            return isset($idx[$name]) ? trim((string)($row[$idx[$name]] ?? '')) : '';
        };
    
        // --- Defaults you requested ---
        $now       = new \DateTime();                   // valid_from
        $validFrom = $now->format('Y-m-d H:i:s');
        $validTo   = (clone $now)->modify('+1 year')->format('Y-m-d H:i:s');
        $defaultUsagePerCoupon   = 1;
        $defaultUsagePerCustomer = 1;
    
        // --- Insert loop ---
        $model   = $this->couponModel;
        $success = 0;
        $failed  = 0;
        $errors  = [];
        $batch   = [];
        $line    = 1;
    
        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $line++;
    
            if (!array_filter($row, fn($v) => trim((string)$v) !== '')) continue;
    
            $customer_name  = $get($row, 'customer_name');
            $customer_pin   = $get($row, 'customer_pincode');
            $customer_num   = preg_replace('/\s+/', '', $get($row, 'customer_number'));
    
            // status is optional; default active
            $status = $get($row, 'status') ?: 'active';
    
            // IGNORE any CSV values for:
            // usage_limit_per_coupon, usage_limit_per_customer, valid_from, valid_to
    
            $rowErr = [];
            if ($customer_name === '' || mb_strlen($customer_name) > 120) $rowErr[] = 'Invalid customer_name';
            if ($customer_pin === '' || mb_strlen($customer_pin) > 10)   $rowErr[] = 'Invalid customer_pincode';
            if ($customer_num === '' || mb_strlen($customer_num) > 20)   $rowErr[] = 'Invalid customer_number';
            if ($status !== '' && !in_array($status, ['active','inactive','expired','used_up'], true)) {
                $rowErr[] = 'Invalid status';
            }
    
            if ($rowErr) {
                $failed++;
                $errors[] = "Line {$line}: " . implode('; ', $rowErr);
                continue;
            }
    
            $record = [
                'account_id'               => $adminId,
                'customer_name'            => $customer_name,
                'customer_pincode'         => $customer_pin,
                'customer_number'          => $customer_num,
                'coupon_code'              => $this->generateUniqueCouponCode($model),
                'status'                   => $status,
                'valid_from'               => $validFrom, // today
                'valid_to'                 => $validTo,   // +1 year
                'usage_limit_per_coupon'   => $defaultUsagePerCoupon,    // 1
                'usage_limit_per_customer' => $defaultUsagePerCustomer,  // 1
                'usage_count'              => 0,
                'redeemed_at'              => null,
                'created_at'               => date('Y-m-d H:i:s'),
                'updated_at'               => date('Y-m-d H:i:s')
            ];
    
            $batch[] = $record;
    
            if (count($batch) >= 500) {
                try {
                    $model->insertBatch($batch);
                    $success += count($batch);
                    
                    $this->sendTemplatesForBatch($batch);
                } catch (\Throwable $e) {
                    $failed += count($batch);
                    $errors[] = "Insert batch failed near line {$line}: " . $e->getMessage();
                }
                $batch = [];
            }
        }
        fclose($handle);
    
        if (!empty($batch)) {
            try {
                $model->insertBatch($batch);
                $success += count($batch);
                
                 $this->sendTemplatesForBatch($batch);
            } catch (\Throwable $e) {
                $failed += count($batch);
                $errors[] = "Final insert failed: " . $e->getMessage();
            }
        }
    
        $data = [
            'breadcrumbs' => 'Bulk Upload Coupons',
            'summary'     => ['inserted' => $success, 'failed' => $failed, 'errors' => $errors]
        ];
    
        echo view('admin/layouts/header', ['data' => $this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/coupons_bulk_upload_result', $data);
        echo view('admin/layouts/footer');
    }


    
    // --- helpers (no DB open) ---
    
    /** Accepts 'Y-m-d' or 'Y-m-d H:i:s'; returns 'Y-m-d H:i:s' or null */
    private function parseLooseDateTime(?string $value): ?string
    {
        $v = trim((string)$value);
        if ($v === '') return null;
    
        foreach (['Y-m-d H:i:s', 'Y-m-d'] as $fmt) {
            $dt = \DateTime::createFromFormat($fmt, $v);
            if ($dt && $dt->format($fmt) === $v) {
                if ($fmt === 'Y-m-d') $dt->setTime(0, 0, 0);
                return $dt->format('Y-m-d H:i:s');
            }
        }
        return null;
    }
    
    /** Generate a globally-unique coupon code (fits your UNIQUE index on coupon_code) */
    private function generateUniqueCouponCode($model): string
    {
        for ($i = 0; $i < 5; $i++) {
            $code = 'MEDS' . $this->randomBase36(9); // e.g., MEDS3F9A8Q1R
            if ($model->where('coupon_code', $code)->countAllResults() == 0) {
                return $code;
            }
        }
        return 'MEDS' . strtoupper(bin2hex(random_bytes(6)));
    }
    
    private function randomBase36(int $length): string
    {
        $out = '';
        while (strlen($out) < $length) {
            $n = random_int(0, 36**5 - 1);
            $chunk = strtoupper(str_pad(base_convert($n, 10, 36), 5, '0', STR_PAD_LEFT));
            $out .= $chunk;
        }
        return substr($out, 0, $length);
    }
    
    /** Return Indian MSISDN like 91XXXXXXXXXX (strip +, spaces, 0 prefix, etc.) */
    private function normalizeIndianMsisdn(string $raw): string
    {
        $p = preg_replace('/\D+/', '', $raw); // keep digits only
        // Remove leading 0s
        $p = ltrim($p, '0');
        // Remove leading 91 if present (we'll ensure exactly one 91)
        if (strpos($p, '91') === 0) {
            $p = substr($p, 2);
        }
        // Now ensure exactly 91 prefix
        return '91' . $p;
    }
    
    /**
     * Send a WhatsApp TEMPLATE message (Gupshup) with an image & dynamic params.
     * The "Copy Offer Code" button in your approved template should bind to params[2].
     *
     * @param string $msisdnLike91XXXXXXXXXX   destination (without +, with 91 prefix)
     * @param string $customerName
     * @param string $couponCode
     * @param string|null $imageUrl
     */
    private function sendTemplateMessage(string $msisdnLike91XXXXXXXXXX, string $customerName, string $couponCode, ?string $imageUrl = null)
    {
        $url    = 'https://api.gupshup.io/wa/api/v1/template/msg';
        $imageUrl = 'https://fss.gupshup.io/0/public/0/0/gupshup/917249426487/b617e912-fa75-45be-95ef-2907c0cd8973/1756140974720_PHOTO-2025-08-24-21-06-38.jpg';
        $apiKey = $this->gupshupapi; // reuse your controller key, or replace if you use a separate key for template API
        $source = $this->source;
    
        // Your approved template id from the curl you shared
        $templateId = 'cd52216b-6250-48c4-9975-28d08f5f5f90';
        
        // $this->gupshupOptin($msisdnLike91XXXXXXXXXX);
    
        // Template parameters:
        //   [0] -> Customer name
        //   [1] -> Coupon code (shown in body)
        //   [2] -> Coupon code again (bound to "Copy Offer Code" button payload)
        $template = [
            'id'     => $templateId,
            'params' => [$customerName, $couponCode, $couponCode],
        ];
    
        // Optional rich media message
        $message = $imageUrl ? [
            'type'  => 'image',
            'image' => ['link' => $imageUrl],
        ] : ['type' => 'text', 'text' => '']; // body comes from template; text can stay empty
    
        $data = [
            'channel'     => 'whatsapp',
            'source'      => $source,
            'destination' => $msisdnLike91XXXXXXXXXX, // MUST be 91xxxxxxxxxx (no +)
            'src.name'    => 'MediSoldierNew',
            'template'    => json_encode($template),
            'message'     => json_encode($message)
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
        $resp = curl_exec($ch);
      
        if ($resp === false) {
            log_message('error', 'Gupshup template curl error: '.curl_error($ch));
        }
        curl_close($ch);
        return $resp;
    }
    
    /**
     * Send the approved WhatsApp TEMPLATE for each inserted coupon record in a batch.
     * Expects the same array shape you insert with insertBatch(): each element has
     *   - customer_name
     *   - customer_number
     *   - coupon_code
     */
    private function sendTemplatesForBatch(array $batch): void
    {
        foreach ($batch as $rec) {
            try {
                $name = (string)($rec['customer_name'] ?? '');
                $phoneRaw = (string)($rec['customer_number'] ?? '');
                $code  = (string)($rec['coupon_code'] ?? '');
    
                if ($name === '' || $phoneRaw === '' || $code === '') {
                    continue; // skip incomplete rows
                }
    
                // Ensure destination is 91XXXXXXXXXX (no +)
                $dest = $this->normalizeIndianMsisdn($phoneRaw);
    
                // Optional image; reuse the same one you used for single-create
                $imageUrl = 'https://fss.gupshup.io/0/public/0/0/gupshup/917249426487/b617e912-fa75-45be-95ef-2907c0cd8973/1756140974720_PHOTO-2025-08-24-21-06-38.jpg';
            
    
                // Sends template with params: [ customer_name, coupon_code, coupon_code ]
                // The button "Copy Offer Code" should bind to params[2] as per your template.
                $this->sendTemplateMessage($dest, $name, $code, $imageUrl);
    
                // (Optional) tiny delay to be polite with the API; uncomment if needed
                // usleep(120000); // 120ms
    
            } catch (\Throwable $e) {
                log_message('error', 'Bulk template send failed: ' . $e->getMessage());
            }
        }
    }

    /**
     * Opt-in a user to your WA app before sending templates.
     * Return ['ok'=>true] on success or already opted-in.
     */
    private function gupshupOptin(string $dest91): bool
    {
        $url  = 'https://api.gupshup.io/wa/api/v1/optin';
        $data = [
            'channel' => 'whatsapp',
            'user'    => $dest91,   // e.g. 919876543210
        ];
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'apikey: ' . $this->gupshupapi,
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        print_r($resp);
        die;
    
        // Gupshup returns 200 even if already opted-in; treat 2xx as success
        if ($http >= 200 && $http < 300) return true;
    
        return false;
    }

    // ===================================
    // WEBSITE CONTENT CRUD METHODS
    // ===================================

    /**
     * Manage Companies
     */
    public function companies() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('companies');
        $crud->setSubject('Company', 'Companies');

        $crud->columns(['name', 'logo', 'description', 'display_order', 'is_active']);
        $crud->fields(['name', 'logo', 'description', 'website_url', 'display_order', 'is_active']);

        // Enable file upload for logo
        $crud->setFieldUpload('logo', 'assets/uploads/companies', base_url('assets/uploads/companies'));

        // Display logo as image in the grid
        $crud->callbackColumn('logo', function ($value, $row) {
            if (empty($value)) {
                return '<span style="color: #999;">No logo</span>';
            }
            $imageUrl = base_url('assets/uploads/companies/' . $value);
            return '<img src="' . esc($imageUrl) . '" style="max-width: 100px; max-height: 50px; object-fit: contain;" alt="' . esc($row->name) . '">';
        });

        $crud->displayAs('logo', 'Logo');
        $crud->displayAs('display_order', 'Display Order');
        $crud->displayAs('is_active', 'Active');
        $crud->displayAs('website_url', 'Website URL');

        $crud->fieldType('is_active', 'dropdown', [1 => 'Active', 0 => 'Inactive']);

        $crud->unsetBootstrap();
        $crud->unsetJquery();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $data = [
            'css_files'   => $output->css_files,
            'js_files'    => $output->js_files,
            'breadcrumbs' => "Manage Companies",
            'output'      => $output->output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }

    /**
     * Manage Partners
     */
    public function partners() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('partners');
        $crud->setSubject('Partner', 'Partners');

        $crud->columns(['name', 'logo', 'website_url', 'display_order', 'is_active']);
        $crud->fields(['name', 'logo', 'website_url', 'display_order', 'is_active']);

        // Enable file upload for logo
        $crud->setFieldUpload('logo', 'assets/uploads/partners', base_url('assets/uploads/partners'));

        // Display logo as image in the grid
        $crud->callbackColumn('logo', function ($value, $row) {
            if (empty($value)) {
                return '<span style="color: #999;">No logo</span>';
            }
            // Check if it's a full URL or just a filename
            $imageUrl = (strpos($value, 'http') === 0) ? $value : base_url('assets/uploads/partners/' . $value);
            return '<img src="' . esc($imageUrl) . '" style="max-width: 100px; max-height: 50px; object-fit: contain;" alt="' . esc($row->name) . '">';
        });

        $crud->displayAs('logo', 'Logo');
        $crud->displayAs('display_order', 'Display Order');
        $crud->displayAs('is_active', 'Active');
        $crud->displayAs('website_url', 'Website URL');

        $crud->fieldType('is_active', 'dropdown', [1 => 'Active', 0 => 'Inactive']);

        $crud->unsetBootstrap();
        $crud->unsetJquery();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $data = [
            'css_files'   => $output->css_files,
            'js_files'    => $output->js_files,
            'breadcrumbs' => "Manage Partners",
            'output'      => $output->output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }

    /**
     * Manage Board Members
     */
    public function board_members() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('board_members');
        $crud->setSubject('Board Member', 'Board Members');

        $crud->columns(['name', 'position', 'photo', 'member_type', 'education', 'display_order', 'is_active']);
        $crud->fields(['name', 'position', 'photo', 'bio', 'education', 'member_type', 'display_order', 'is_active']);

        // Enable file upload for photo
        $crud->setFieldUpload('photo', 'assets/uploads/board_members', base_url('assets/uploads/board_members'));

        // Display photo as image in the grid
        $crud->callbackColumn('photo', function ($value, $row) {
            if (empty($value)) {
                return '<span style="color: #999;">No photo</span>';
            }
            // Check if it's a full URL or just a filename
            $imageUrl = (strpos($value, 'http') === 0) ? $value : base_url('assets/uploads/board_members/' . $value);
            return '<img src="' . esc($imageUrl) . '" style="max-width: 80px; max-height: 80px; object-fit: cover; border-radius: 50%;" alt="' . esc($row->name) . '">';
        });

        $crud->displayAs('photo', 'Photo');
        $crud->displayAs('display_order', 'Display Order');
        $crud->displayAs('is_active', 'Active');
        $crud->displayAs('member_type', 'Member Type');

        $crud->fieldType('member_type', 'dropdown', ['board' => 'Board Member', 'advisory' => 'Advisory Board']);
        $crud->fieldType('is_active', 'dropdown', [1 => 'Active', 0 => 'Inactive']);

        $crud->unsetBootstrap();
        $crud->unsetJquery();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $data = [
            'css_files'   => $output->css_files,
            'js_files'    => $output->js_files,
            'breadcrumbs' => "Manage Board Members",
            'output'      => $output->output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }

    /**
     * View Contact Submissions
     */
    public function contact_submissions() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('contact_submissions');
        $crud->setSubject('Contact Submission', 'Contact Submissions');

        $crud->columns(['name', 'email', 'phone', 'interest', 'subject', 'status', 'created_at']);
        $crud->fields(['name', 'email', 'phone', 'interest', 'subject', 'message', 'status', 'admin_notes']);

        $crud->displayAs('admin_notes', 'Admin Notes');
        $crud->displayAs('created_at', 'Submitted At');

        $crud->fieldType('status', 'dropdown', [
            'new' => 'New',
            'read' => 'Read',
            'replied' => 'Replied',
            'archived' => 'Archived'
        ]);

        $crud->fieldType('interest', 'dropdown', [
            'jobs' => 'Jobs',
            'business' => 'Business',
            'csr' => 'CSR/Philanthropy',
            'other' => 'Other'
        ]);

        $crud->unsetAdd();
        $crud->unsetDelete();
        $crud->setRead();

        $crud->unsetBootstrap();
        $crud->unsetJquery();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $data = [
            'css_files'   => $output->css_files,
            'js_files'    => $output->js_files,
            'breadcrumbs' => "Contact Submissions",
            'output'      => $output->output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }

    /**
     * Manage Site Settings
     */
    public function site_settings() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('site_settings');
        $crud->setSubject('Setting', 'Site Settings');

        $crud->columns(['setting_key', 'setting_value', 'setting_group', 'description', 'is_active']);
        $crud->fields(['setting_key', 'setting_value', 'setting_type', 'setting_group', 'description', 'is_active']);

        $crud->displayAs('setting_key', 'Setting Key');
        $crud->displayAs('setting_value', 'Value');
        $crud->displayAs('setting_type', 'Type');
        $crud->displayAs('setting_group', 'Group');
        $crud->displayAs('is_active', 'Active');

        $crud->fieldType('setting_type', 'dropdown', [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'number' => 'Number',
            'url' => 'URL',
            'email' => 'Email',
            'image' => 'Image',
            'json' => 'JSON'
        ]);

        $crud->fieldType('is_active', 'dropdown', [1 => 'Active', 0 => 'Inactive']);

        $crud->unsetBootstrap();
        $crud->unsetJquery();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $data = [
            'css_files'   => $output->css_files,
            'js_files'    => $output->js_files,
            'breadcrumbs' => "Site Settings",
            'output'      => $output->output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }

    /**
     * Manage News Items
     */
    public function news_items() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('news_items');
        $crud->setSubject('News Item', 'News Items');

        $crud->columns(['title', 'embed_type', 'category', 'is_featured', 'is_active', 'published_at']);
        $crud->fields(['title', 'content', 'embed_url', 'embed_type', 'image', 'external_link', 'category', 'display_order', 'is_featured', 'is_active', 'published_at']);

        $crud->displayAs('embed_url', 'Embed URL');
        $crud->displayAs('embed_type', 'Embed Type');
        $crud->displayAs('display_order', 'Display Order');
        $crud->displayAs('is_featured', 'Featured');
        $crud->displayAs('is_active', 'Active');
        $crud->displayAs('published_at', 'Published At');

        $crud->fieldType('embed_type', 'dropdown', [
            'linkedin' => 'LinkedIn',
            'instagram' => 'Instagram',
            'youtube' => 'YouTube',
            'other' => 'Other'
        ]);

        $crud->fieldType('is_featured', 'dropdown', [1 => 'Yes', 0 => 'No']);
        $crud->fieldType('is_active', 'dropdown', [1 => 'Active', 0 => 'Inactive']);

        $crud->unsetBootstrap();
        $crud->unsetJquery();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $data = [
            'css_files'   => $output->css_files,
            'js_files'    => $output->js_files,
            'breadcrumbs' => "News Items",
            'output'      => $output->output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }

    // ===================================
    // SIDEBAR URL ALIASES (matching sidebar links)
    // ===================================

    /**
     * Manage Timeline Events (sidebar: admin/timeline)
     */
    public function timeline() {
        if(!$this->checkSession())
            return redirect()->to(base_url('admin/login'));

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('timeline_events');
        $crud->setSubject('Timeline Event', 'Timeline Events');

        $crud->columns(['year', 'title', 'alignment', 'display_order', 'is_active']);
        $crud->fields(['year', 'title', 'description', 'image_url', 'alignment', 'display_order', 'is_active']);

        $crud->displayAs('image_url', 'Image URL');
        $crud->displayAs('display_order', 'Display Order');
        $crud->displayAs('is_active', 'Active');

        $crud->fieldType('alignment', 'dropdown', [
            'left' => 'Left',
            'right' => 'Right'
        ]);

        $crud->fieldType('is_active', 'dropdown', [1 => 'Active', 0 => 'Inactive']);

        $crud->defaultOrdering('year', 'asc');

        $crud->unsetBootstrap();
        $crud->unsetJquery();

        $output = $crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        $data = [
            'css_files'   => $output->css_files,
            'js_files'    => $output->js_files,
            'breadcrumbs' => "Manage Timeline",
            'output'      => $output->output
        ];

        echo view('admin/layouts/header', ['data'=>$this->data]);
        echo view('admin/layouts/sidebar', ['data'=>$this->data]);
        echo view('admin/crud_layout', $data);
        echo view('admin/layouts/footer');
    }

    /**
     * News - Alias for sidebar URL (admin/news)
     */
    public function news() {
        return $this->news_items();
    }

    /**
     * Contacts - Alias for sidebar URL (admin/contacts)
     */
    public function contacts() {
        return $this->contact_submissions();
    }

    /**
     * Settings - Alias for sidebar URL (admin/settings)
     */
    public function settings() {
        return $this->site_settings();
    }
}
