<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// ============================================
// FRONTEND ROUTES (RK Group Website)
// ============================================
$routes->get('/', 'Frontend::index');
$routes->get('/about', 'Frontend::about');
$routes->get('/careers', 'Frontend::careers');
$routes->get('/connect', 'Frontend::connect');

// ============================================
// HOME/API ROUTES (Medisoldier App)
// ============================================
$routes->add('/app', 'Home::index'); // Old home page now at /app


// Webhook Route
$routes->add('/webhook', 'Home::webhook');
$routes->add('/razorpay-webhook', 'Home::razorpayWebhook');
$routes->add('/webhook/test', 'Home::test');

// Auth route 
$routes->add('/auth/check-phone', 'Auth::checkPhone');
$routes->add('/auth/send-otp', 'Auth::sendOTP');
$routes->add('/auth/verify-otp', 'Auth::verifyOTP');
$routes->add('/auth/create-user', 'Auth::createUser');

// Api Route
$routes->get('/api/pincode/check', 'ApiController::checkPincode');
$routes->get('/api/orders', 'ApiController::getOrders');
$routes->post('/api/prescription/upload', 'ApiController::uploadPrescription');
$routes->add('/api/order/no-prescription', 'ApiController::createNoPrescriptionOrderGet');
$routes->get('/api/order/details', 'ApiController::getOrderDetails');
$routes->get('/api/payment/create', 'ApiController::createPaymentLinkApi');
$routes->add('/api/order/update-address', 'ApiController::updateOrderAddress');
$routes->get('/api/profile', 'ApiController::getProfile');
// $routes->post('/api/profile/update, ApiController::updateProfile');
$routes->get('/api/substitutes', 'ApiController::getSubstitutes');
$routes->get('/api/autocomplete', 'ApiController::autocomplete');

$routes->get ('api/insurance-documents',              'ApiController::insuranceDocuments');
$routes->post('api/insurance-documents',              'ApiController::uploadInsuranceDocument');
$routes->get ('api/insurance-documents/(:num)',       'ApiController::getInsuranceDocument/$1');
$routes->get ('api/insurance-documents/(:num)/file',  'ApiController::streamInsuranceDocument/$1');

$routes->add('api/coupon/verify', 'ApiController::verifyCoupon');
$routes->delete('api/insurance-documents/(:num)', 'ApiController::deleteInsuranceDocument/$1');

$routes->options('api/(:any)', 'ApiController::preflightAny');


$routes->group('admin', function($routes) {

    // Authentication
    $routes->add('login', 'Admin::login');
    $routes->post('login-submit', 'Admin::login_submit');
    $routes->add('logout', 'Admin::logout');

    // Dashboard
    $routes->add('dashboard', 'Admin::dashboard');
    $routes->add('profile', 'Admin::profile');


    // ============================================
    //  NEW ROUTES FOR MEDISOLDIER TABLES
    // ============================================

    // USERS
    $routes->add('users', 'Admin::users'); 
    // Example for CRUD:
    // $routes->add('users/add', 'Admin::users_add');
    // $routes->add('users/edit/(:num)', 'Admin::users_edit/$1');
    // $routes->add('users/delete/(:num)', 'Admin::users_delete/$1');

    // PINCODES
    $routes->add('pincodes', 'Admin::pincodes');
    $routes->add('customer-coupons', 'Admin::customer_coupons');
    // Similarly:
    // $routes->add('pincodes/add', 'Admin::pincodes_add');
    // $routes->add('pincodes/edit/(:num)', 'Admin::pincodes_edit/$1');
    // $routes->add('pincodes/delete/(:num)', 'Admin::pincodes_delete/$1');

    // ORDERS
    $routes->add('orders', 'Admin::orders');
    // $routes->add('orders/view/(:num)', 'Admin::orders_view/$1');

    // ORDER DETAILS
    $routes->add('order-details', 'Admin::order_details');

    // DELIVERY ADDRESSES
    $routes->add('delivery-addresses', 'Admin::delivery_addresses');

    // PAYMENTS
    $routes->add('payments', 'Admin::payments');

    // INSURANCE DOCUMENTS
    $routes->add('insurance-documents', 'Admin::insurance_documents');

    // ORDER STATUS HISTORY
    $routes->add('order-status-history', 'Admin::order_status_history');

    // USER SESSIONS
    $routes->add('user-sessions', 'Admin::user_sessions');
    $routes->add('distributors', 'Admin::admins');

    $routes->get('list-pending', 'Admin::listPendingReviewOrders');
    $routes->get('editOrderDetails/(:segment)', 'Admin::editOrderDetails/$1');
    $routes->post('updateOrderDetails', 'Admin::updateOrderDetails');
    
    $routes->get('coupons/bulk-upload', 'Admin::couponBulkUploadForm');
    $routes->post('coupons/bulk-upload', 'Admin::couponBulkUploadProcess');
    $routes->get('coupons/bulk-template', 'Admin::couponBulkTemplate');

    // ============================================
    //  WEBSITE CONTENT MANAGEMENT ROUTES
    // ============================================

    // Companies
    $routes->add('companies', 'Admin::companies');
    $routes->add('companies/(:any)', 'Admin::companies/$1');

    // Partners
    $routes->add('partners', 'Admin::partners');
    $routes->add('partners/(:any)', 'Admin::partners/$1');

    // Board Members
    $routes->add('board-members', 'Admin::board_members');
    $routes->add('board-members/(:any)', 'Admin::board_members/$1');

    // Contact Submissions
    $routes->add('contact-submissions', 'Admin::contact_submissions');
    $routes->add('contact-submissions/(:any)', 'Admin::contact_submissions/$1');

    // Site Settings
    $routes->add('site-settings', 'Admin::site_settings');
    $routes->add('site-settings/(:any)', 'Admin::site_settings/$1');

    // News Items
    $routes->add('news-items', 'Admin::news_items');
    $routes->add('news-items/(:any)', 'Admin::news_items/$1');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}