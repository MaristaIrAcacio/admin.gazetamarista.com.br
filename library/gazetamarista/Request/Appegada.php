<?php
/**
 * Classe de conexão api appegada
 *
 * @name gazetamarista_Request_Appegada
 */
class gazetamarista_Request_Appegada {

	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "appegada";

	private $credentials;
	private $_application_config;
	private $_modules;
    private $session_config;

	/**
	 * Inicializa a classe
	 *
	 * @name init
	 */
	public function __construct() {
	    // Sessão de configuração
		$this->session_config = new Zend_Session_Namespace("configuracao");

		$url_api = 'https://api.appegada.com/';
		if( em_desenvolvimento() ) {
			$url_api = 'https://api-teste.appegada.com/';
		}

		// Credentials
        $this->credentials = array(
        	'client_url'	=> $url_api,
        	'client_name'   => 'Nahrung',
            'client_id' 	=> '22066639467149627412',
            'client_secret' => 'nAc=7Oh1S12WiZlX*fecho3ehIpE@e&7e34EsAw=&M!H?p98F7mato7api--!UWi'
        );

        // Armazena as configurações globais
		$this->_application_config = Zend_Registry::get("config");
		$this->_modules = Zend_Registry::get("modulos");

		// Função de bloquear injection
		$this->sanitize = new gazetamarista_Sanitize();

        // Cria o método para inicialização personalizada
		$this->init();
	}

	/**
	 * Método para inicialização
	 *
	 * @name init
	 */
	public function init() {

	}

    /**
     * Cadastro de cliente
	 *
	 * POST client/customers
     */
    public function createCustomer($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/customers', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca lista de clientes
	 *
	 * GET client/customers
     */
    public function listCustomers($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/customers', $params);

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Detalhe de cliente
	 *
	 * GET client/customers/{user}
     */
    public function getCustomer($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/customers/'.$params['customer_id']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Atualização de cliente
	 *
	 * POST client/customers/{user}
     */
    public function updateCustomer($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/customers/'.$params['customer_id'], $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Exclusão de cliente
	 *
	 * DELETE client/customers/{user}
     */
    public function deleteCustomer($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('delete', 'client/customers/'.$params['customer_id']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Login de cliente
	 * type 'general': email e password
	 * type 'facebook': access_token
	 *
	 * POST client/customers/login/{type}
     */
    public function loginCustomer($params=[], $type='general') {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/customers/login/'.$type, $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Alteração senha de cliente
	 *
	 * POST client/customers/{user}/change-password
     */
    public function changePasswordCustomer($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/customers/'.$params['customer_id'].'/change-password', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca filtros de produtos
	 *
	 * GET client/products/filters
     */
    public function getFilters($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/products/filters', $params);

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca lista de produtos
	 *
	 * GET client/products
     */
    public function listProducts($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/products', $params);

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Detalhe de produto
	 *
	 * GET client/products/{product}
     */
    public function getProduct($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/products/'.$params['idproduct']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Detalhe do carrinho de produtos
	 *
	 * GET client/cart/{user}
     */
    public function getCart($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/cart/'.$params['customer_id']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Adicionar produto no carrinho
	 *
	 * POST client/cart/{user}/product-add
     */
    public function addProductCart($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/cart/'.$params['customer_id'].'/product-add', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Atualizar produto do carrinho
	 *
	 * POST client/cart/{user}/product-edit
     */
    public function updateProductCart($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/cart/'.$params['customer_id'].'/product-edit', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Remover produto do carrinho
	 *
	 * POST client/cart/{user}/product-remove
     */
    public function deleteProductCart($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/cart/'.$params['customer_id'].'/product-remove', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Consultar frete de carrinho de produtos
	 *
	 * POST client/cart/{user}/shipping-calculate
     */
    public function shippingCart($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/cart/'.$params['customer_id'].'/shipping-calculate', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Enviar endereço e método de entrega selecionado
	 *
	 * POST client/cart/{user}/shipping-select
     */
    public function selectShippingCart($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/cart/'.$params['customer_id'].'/shipping-select', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Remover cupom do carrinho
	 *
	 * POST client/cart/{user}/coupon-remove
     */
    public function deleteCouponCart($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/cart/'.$params['customer_id'].'/coupon-remove', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca lista de cartões
	 *
	 * GET client/customers-cards
     */
    public function listCards($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/customers-cards', $params);

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Cadastro de cartão
	 *
	 * POST client/customers-cards
     */
    public function createCard($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/customers-cards', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Detalhe do cartão
	 *
	 * GET client/customers-cards/{user}/{card}
     */
    public function getCard($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/customers-cards/'.$params['customer_id'].'/'.$params['card_id']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Exclusão do cartão
	 *
	 * DELETE client/customers-cards/{user}/{card}
     */
    public function deleteCard($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('delete', 'client/customers-cards/'.$params['customer_id'].'/'.$params['card_id']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca lista de pedidos
	 *
	 * GET client/orders
     */
    public function listOrders($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/orders', $params);

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Detalhe de pedido
	 *
	 * GET client/orders/{user}/{order_id}
     */
    public function getOrder($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/orders/'.$params['customer_id'].'/'.$params['order_id']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca lista de endereços do cliente
	 *
	 * GET client/customers-address
     */
    public function listAddress($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/customers-address', $params);

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Cadastro de endereço
	 *
	 * POST client/customers-address
     */
    public function createAddress($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/customers-address', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Atualização de endereço
	 *
	 * POST client/customers-address/{user}/{address}
     */
    public function updateAddress($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/customers-address/'.$params['customer_id'].'/'.$params['address_id'], $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Detalhe de endereço
	 *
	 * GET client/customers-address/{user}/{address}
     */
    public function getAddress($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/customers-address/'.$params['customer_id'].'/'.$params['address_id']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Exclusão do endereço
	 *
	 * DELETE client/customers-address/{user}/{address}
     */
    public function deleteAddress($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('delete', 'client/customers-address/'.$params['customer_id'].'/'.$params['address_id']);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Consultar frete de produto
	 *
	 * POST client/products/{product}/shipping-calculate
     */
    public function shippingProduct($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('post', 'client/products/'.$params['idproduct'].'/shipping-calculate', $params);

        } catch (Exception $e) {
    		// Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca lista de estados
	 *
	 * GET client/webservice/states
     */
    public function listStates($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/webservice/states');

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca lista de cidades
	 *
	 * GET client/webservice/cities
     */
    public function listCities($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/webservice/cities', $params);

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
     * Busca dados do CEP
	 *
	 * GET client/webservice/zipcode/{zipcode}
     */
    public function getZipcode($params=[]) {
    	try {
    		// Retorna array 'status' e 'response' ou 'message'
            $response = $this->send('get', 'client/webservice/zipcode/'.$params['zipcode']);

        } catch (Exception $e) {
            // Erro
            $response = array('status' => "erro", 'code' => $e->getCode(), 'message' => $e->getMessage());
        }

        // Retorna json
		return json_encode($response);
    }

    /**
	 * Send request
	 *
	 * @param       $method
	 * @param       $url
	 * @param array $data
	 *
	 * @return object
	 * @throws Exception
	 */
	private function send($method, $url, array $data = [], array $headers = []) {
		$client = new Zend_Http_Client();
		$client->setUri($this->credentials['client_url'] . $url);
		$client->setHeaders([
			'Content-Type' 		=> 'application/json, Accept-Encoding: gzip',
			'Accept' 			=> 'application/json',
            'Language' 			=> 'pt',
            'x-client-id' 		=> $this->credentials['client_id'],
            'x-client-secret' 	=> $this->credentials['client_secret'],
		]);

//		if( em_desenvolvimento() ) {
//			$this->log->info('----');
//			$this->log->info($method);
//			$this->log->info($this->api . $url);
//			foreach( $data as $key => $data_ ) {
//				$this->log->info($key . ' : ' . $data_);
//			}
//			foreach( $headers as $key => $header ) {
//				$this->log->info($key . ' : ' . $header);
//			}
//		}

		if( $method === 'get' ) {
			$response = $client->setParameterGet($data)->request('GET');
		} elseif( $method === 'post' ) {
			$response = $client->setParameterPost($data)->request('POST');
		} elseif( $method === 'delete' ) {
			$response = $client->request('DELETE');
		}

//		if( em_desenvolvimento() ) {
//			$this->log->info($resposta->getBody());
//		}

		$data_decode = @json_decode($response->getBody(), true);
		$arrResponse = array(
			'server_message' => $response->getMessage(),
			'server_status'  => $response->getStatus(),
			'server_body'    => $response->getBody(),
			'data' 	  		 => $data_decode,
			'message' 		 => $data_decode['message'],
			'errors'  		 => $data_decode['errors']
		);
		//Zend_Debug::dump($arrResponse);exit;

		// Error
		if( $arrResponse['server_status'] >= 400 and $arrResponse['server_status'] <= 500 ) {
			$error = !empty($arrResponse['message']) ? $arrResponse['message'] : "Ocoreu um erro. Tente novamente.";

			// Has details error
            if( isset($arrResponse['errors']) ) {
            	// Primeiro erro caso possua mais
				$error = current($arrResponse['errors'])[0];
            }

            if($arrResponse['data']['code'] == 1000) {
            	// Retorno ERRO de carrinho
				$arrRetorno = array('status'=>'erro', 'code'=>1000, 'message'=>$error, 'messages'=>'');
			}else{
            	// Retorno ERRO
				$arrRetorno = array('status'=>'erro', 'code'=>$arrResponse['server_status'], 'message'=>$error, 'messages'=>$arrResponse['errors']);
			}
		}else{
			// Retorno SUCESSO
			$arrRetorno = array('status'=>'sucesso', 'response'=>$arrResponse['data']);
		}

		// Retorno
		return $arrRetorno;
	}

//    /**
//     * cURL
//     *
//     * Função que pega por cURL as requisições de autenticação e demais (GET/POST/DELETE/UPDATE)
//     * @link http://php.net/manual/en/book.curl.php
//     */
//    private function curl($url, $method = 'GET', $postFields = null, $timeout = 20, $charset = 'ISO-8859-1') {
//        if (strtoupper($method) === 'POST') {
//            $methodOptions = array(
//                CURLOPT_POST => true,
//                CURLOPT_POSTFIELDS => $postFields,
//            );
//        } else {
//            $methodOptions = array(
//                CURLOPT_HTTPGET => true
//            );
//        }
//
//        $options = array(
//            CURLOPT_HTTPHEADER => array(
//                'Content-Type: application/json'
//            ),
//            CURLOPT_URL => $url,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_HEADER => false,
//            CURLOPT_SSL_VERIFYPEER => false,
//            CURLOPT_CONNECTTIMEOUT => $timeout,
//            //CURLOPT_TIMEOUT => $timeout
//        );
//
//        $options = ($options + $methodOptions);
//
//        $curl = curl_init();
//        curl_setopt_array($curl, $options);
//        $resp = curl_exec($curl);
//        // $info = curl_getinfo($curl);
//        $error = curl_errno($curl);
//        $errorMessage = curl_error($curl);
//        curl_close($curl);
//
//        if ($error) {
//            throw new Exception("CURL can't connect: $errorMessage");
//        } else {
//            return $resp;
//        }
//    }

//    /**
//	 * Tratamento de Status retorno da API
//	 */
//    private function getStatus($response=NULL) {
//		if( $response->getStatusCode() >= 400 and $response->getStatusCode() <= 500 ) {
//			// Error default
//            $error = 'Ocoreu um erro. Tente novamente.';
//
//            // Json decode
//            $responseData = json_decode($response->getBody(), true);
//
//            // Has details error
//            if( isset($responseData->errors) ) {
//            	// Primeiro error caso possua mais
//                $error = $responseData->errors[0];
//            }
//
//            return $error;
//        }
//	}
}
