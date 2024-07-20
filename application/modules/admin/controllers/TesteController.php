<?php

/**
 * Controlador
 *
 * @name Admin_TesteController
 */
class Admin_TesteController extends Zend_Controller_Action {

	/**
	 * Armazena retorno da api
	 *
	 * @access protected
	 * @name $_model
	 */
	protected $_remote = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o remote
		$this->_remote = NULL;

		$this->arr_teste = array(
			0 => ['id'=>1, 'titulo'=>'Título para teste de listagem 1', 'data'=>'24/05/2023'],
			1 => ['id'=>2, 'titulo'=>'Título para teste de listagem 2', 'data'=>'25/05/2023'],
			2 => ['id'=>3, 'titulo'=>'Título para teste de listagem 3', 'data'=>'26/05/2023'],
			3 => ['id'=>4, 'titulo'=>'Título para teste de listagem 4', 'data'=>'27/05/2023']
		);
		
		// Continua o carregamento do controlador
		parent::init();
	}

	/**
	 * Listagem
	 */
	public function listaAction() {
		$this->view->registros = $this->arr_teste;
	}
	
	/**
	 * Formulário
	 */
	public function cadastroAction() {
		 $id = $this->_request->getParam("id", 0);

		 // View
		 $this->view->id = $id;
		 $this->view->data = $this->arr_teste[$id-1];
	}

	/**
	 * Teste API appegada
	 */
	public function apiAction() {
		//die("API appegada");

//		$params = ['limit' => 50, 'orderBy' => 'id:desc'];
//		$custormers = (new gazetamarista_Request_Appegada())->listCustomers($params);
//		$retorno_decode = json_decode($custormers, true);
//		Zend_Debug::dump($retorno_decode);
//		Zend_Debug::dump($retorno_decode['response']['data']);


//		$params = [
//			"name" => "Sr. Felipe Casanova Mendonça Filho",
//			"document" => "141.210.817-90",
//			"email" => "tcortes@example.org",
//			"cellphone" => "(87) 96447-5507",
//			"birth" => "2000-01-01",
//			"gender" => "Masculino",
//			"password" => "123456",
//			"password_confirmation" => "123456"
//		];
//		$custormer = (new gazetamarista_Request_Appegada())->createCustomer($params);
//		$retorno_decode = json_decode($custormer, true);
//		Zend_Debug::dump($retorno_decode);


//		$params = ['customer_id' => 50];
//		$custormer = (new gazetamarista_Request_Appegada())->deleteCustomer($params);
//		$retorno_decode = json_decode($custormer, true);
//		Zend_Debug::dump($retorno_decode);

//		$params = ['customer_id' => 37890];
//		$custormer = (new gazetamarista_Request_Appegada())->getCustomer($params);
//		$retorno_decode = json_decode($custormer, true);
//		Zend_Debug::dump($retorno_decode);
//		Zend_Debug::dump($retorno_decode['response']['data']);

//		$params = [
//			'customer_id' => 37891,
//			"name" => "Felipe Casanova Mendonça Filhos",
//			"document" => "141.210.817-90",
//			"email" => "tcortes@example.org",
//			"cellphone" => "(87) 96447-5507",
//			"birth" => "2000-01-01",
//			"gender" => "Masculino",
//			"password" => "123456",
//			"password_confirmation" => "123456"
//		];
//		$custormer = (new gazetamarista_Request_Appegada())->updateCustomer($params);
//		$retorno_decode = json_decode($custormer, true);
//		Zend_Debug::dump($retorno_decode);

//		$params = ["email" => "tcortes@example.org", "password" => "123456"];
//		$custormer = (new gazetamarista_Request_Appegada())->loginCustomer($params, 'general');
//		$retorno_decode = json_decode($custormer, true);
//		Zend_Debug::dump($retorno_decode);

//		$params = ["access_token" => "rCHIk31PEbdXWvBGLX5mHGNCMo6ByM0j5M5B5zNEX5Mp0ib8EmCFBUWD0yOU"];
//		$custormer = (new gazetamarista_Request_Appegada())->loginCustomer($params, 'facebook');
//		$retorno_decode = json_decode($custormer, true);
//		Zend_Debug::dump($retorno_decode);

//		$params = ["customer_id" => 37891, "password_new" => "123456", "password_new_confirmation" => "123456"];
//		$custormer = (new gazetamarista_Request_Appegada())->changePasswordCustomer($params);
//		$retorno_decode = json_decode($custormer, true);
//		Zend_Debug::dump($retorno_decode);

		exit;
	}
}
