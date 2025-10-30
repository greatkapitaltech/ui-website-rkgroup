<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

include(APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;

class BaseController extends Controller {
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url'];
    protected $session, $request, $validation; // Required 

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();
		$this->request = service('request');
		$this->validation =  \Config\Services::validation();
	}
	
	public function _getDbData() {
		$db = (new \Config\Database())->default;
		return [
			'adapter' => [
				'driver' => 'mysqli',
				'host'     => $db['hostname'],
				'database' => $db['database'],
				'username' => $db['username'],
				'password' => $db['password'],
				'charset' => 'utf8'
			]
		];
	}
	
	public function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true) {
		$db = $this->_getDbData();
		$config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();

		$groceryCrud = new GroceryCrud($config, $db);
		return $groceryCrud;
	}

    public function showAlert() {
		if($this->session->getFlashData('error')) {
			echo "<script>swal('Error!', '".$this->session->getFlashData('error')."', 'error')</script>";
		}

		if($this->session->getFlashData('success')) {
            echo "<script>swal('Success!', '".$this->session->getFlashData('success')."', 'success')</script>";		}

		if($this->session->getFlashData('info')) {
            echo "<script>swal('Info!', '".$this->session->getFlashData('info')."', 'info')</script>";		}
	}
}