<?php
/**
 * Classe de Facebook
 *
 * @name gazetamarista_Redesocial_Facebook
 */
class gazetamarista_Redesocial_Facebook {

	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "facebook";

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

		// Sessão do token
        $this->session_token_facebook = new Zend_Session_Namespace("token_facebook");

		// Credentials
        $this->credentials = array(
            'user_id'           => '000967584601298', // id página do facebook
            'user_token'        => '000d0e4bb6e751a4866f63d535765f2e',
            'app_id'            => '0007627545147229',
            'app_secret'        => '00023f4a6296674c7bd98b56142b09aa',
            'app_application'   => 'Teste app',
            'app_token'         => $this->session_token_facebook->token,
            'app_token_page'    => $this->session_token_facebook->token_page,
            'app_token_create'  => '000sTdzpe110BAAoNcarVewT3UCroVnEGTed0iGTNSZB7lGsVFzow5aaRc1hlZA0ckYmfoG0tnvfN9AHfAjRUKfTPrk71y4ywDlBnlztxAMK1aZBCIvZC21rXoMJte4qITybtgWbKeoxhsHJXwuDtSEx6S75cLu1coYxZCOCPU2lrUziiksj9P',
            'app_token_expire'  => '16 de setembro de 2022'
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
	    // Validação do token
        $this->validatoken();

        // Busca token da sessão novamente
        $this->credentials['app_token']      = $this->session_token_facebook->token;
        $this->credentials['app_token_page'] = $this->session_token_facebook->token_page;
	}

    /**
     * Busca o token de acesso (USER)
     */
    public function getTokenUser() {
        if(!empty($this->session_token_facebook->token)) {
            $app_token = $this->session_token_facebook->token;
            //echo('session:'.$app_token);
        }else{
            $app_token = $this->credentials['app_token_create'];
            //echo('create:'.$app_token);
        }

        try {
            // Curl
            $curl = curl_init();
            $grant_type = "grant_type=fb_exchange_token&fb_exchange_token=".$app_token;
            $url = "https://graph.facebook.com/oauth/access_token?client_id=".$this->credentials['app_id']."&client_secret=".$this->credentials['app_secret']."&".$grant_type;
            curl_setopt($curl, CURLOPT_URL, $url); // set the url variable to curl
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return output as string
            $response = curl_exec($curl); // execute curl call
            curl_close($curl); // close curl
            $responseBody = json_decode($response, true); // decode the response (without true this will crash)

            // Access_token
            $access_token = $responseBody['access_token'];

            if(!isset($responseBody['error'])) {
                // Sucesso
                $retorno = array(
                    'status'   => "sucesso",
                    'token'    => $access_token,
                    'response' => $response
                );
            }else{
                // Erro
                $retorno = array(
                    'status'  => "erro",
                    'dados'   => "",
                    'retorno' => $responseBody['error']['message']
                );
            }

        } catch (Exception $e) {
            // Erro
            $retorno = array(
                'status'  => "erro",
                'dados'   => "",
                'retorno' => $e->getMessage()
            );
        }

        // Retorna json
		return json_encode($retorno);
    }

    /**
     * Busca o token de acesso (PAGE)
     */
    public function getTokenPage() {
        if(!empty($this->session_token_facebook->token_page)) {
            $app_token = $this->session_token_facebook->token_page;
            //echo('session:'.$app_token);
        }else{
            $app_token = $this->credentials['app_token_create'];
            //echo('create:'.$app_token);
        }

        try {
            // Curl
            $curl = curl_init();
            $url = "https://graph.facebook.com/".$this->credentials['user_id']."/accounts?access_token=".$app_token;
            curl_setopt($curl, CURLOPT_URL, $url); // set the url variable to curl
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return output as string
            $response = curl_exec($curl); // execute curl call
            curl_close($curl); // close curl
            $responseBody = json_decode($response, true); // decode the response (without true this will crash)

            // Access_token page
            $responseData = $responseBody['data'][0];
            $access_token_page = $responseData['access_token'];

            if(!isset($responseBody['error'])) {
                // Sucesso
                $retorno = array(
                    'status'        => "sucesso",
                    'token_page'    => $access_token_page,
                    'response'      => $response
                );
            }else{
                // Erro
                $retorno = array(
                    'status'  => "erro",
                    'dados'   => "",
                    'retorno' => $responseBody['error']['message']
                );
            }

        } catch (Exception $e) {
            // Erro
            $retorno = array(
                'status'  => "erro",
                'dados'   => "",
                'retorno' => $e->getMessage()
            );
        }

        // Retorna json
		return json_encode($retorno);
    }

    /**
     * Testar o token de acesso
     */
    public function testerToken($token=null, $type='user') {
        if($token == null) {
            if($type == 'user') {
                if(!empty($this->session_token_facebook->token)) {
                    $token = $this->session_token_facebook->token;
                }else{
                    $token = $this->credentials['app_token'];
                }
            }

            if($type == 'page') {
                if(!empty($this->session_token_facebook->token_page)) {
                    $token = $this->session_token_facebook->token_page;
                }else{
                    $token = $this->credentials['app_token_page'];
                }
            }

            if(empty($token)) {
                $token = $this->credentials['app_token_create'];
            }
        }

        try {
            // Curl
            $curl = curl_init();
            $url = "https://graph.facebook.com/debug_token?input_token=".$token."&access_token=".$token;
            curl_setopt($curl, CURLOPT_URL, $url); // set the url variable to curl
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return output as string
            $response = curl_exec($curl); // execute curl call
            curl_close($curl); // close curl
            $responseBody = json_decode($response, true); // decode the response (without true this will crash)

            if(!isset($responseBody['error'])) {
                // Test browser and Facebook variables match for security
                // ($responseBody['data']['application'] == $this->credentials['app_application'])
                $validado = false;
                if($this->credentials['app_id'] == $responseBody['data']['app_id'] && $responseBody['data']['is_valid'] == true) {
                    $validado = true;

                    // Verifica validade de dias, retorno original é em segundos
                    // Fórmula [(emissao - expiracao) / 1 dia em segundos]
                    $emitido_seg    = (int)$responseBody['data']['issued_at'];
                    $expira_seg     = (int)$responseBody['data']['data_access_expires_at'];
                    $expira_em_dias = floor(($expira_seg - $emitido_seg) / 86400);
                    $restante_dias  = floor(($expira_seg - time()) / 86400);
                    $atual_seg      = time();

                    // Se faltar menos de 5 dias, gera novamente o token
                    if($restante_dias < 5) {
                        $validado = false;
                    }
                }

                // Sucesso
                $retorno = array(
                    'status'         => "sucesso",
                    'type'           => $responseBody['data']['type'],
                    'validado'       => $validado,
                    'issued_at'      => $emitido_seg,
                    'expires_at'     => $expira_seg,
                    'expira_em_dias' => $expira_em_dias,
                    'restante_dias'  => $restante_dias,
                    'atual_seg'      => $atual_seg,
                    'token'          => $token,
                    'response'       => $response
                );
            }else{
                // Erro
                $retorno = array(
                    'status'  => "erro",
                    'dados'   => "",
                    'retorno' => $responseBody['error']['message']
                );
            }
        } catch (Exception $e) {
            // Erro
            $retorno = array(
                'status'  => "erro",
                'dados'   => "",
                'retorno' => $e->getMessage()
            );
        }

        // Retorna json
		return json_encode($retorno);
    }

    /**
     * Busca dados do usuário (/me)
     */
    public function getUser() {
        try {
            // Params
            $fields = "&fields=id,name,first_name,email";
            $default_graph_version = 'v14.0';

            // Curl
            $curl = curl_init();
            $url = "https://graph.facebook.com/".$default_graph_version."/me?access_token=".$this->credentials['app_token'].$fields;
            curl_setopt($curl, CURLOPT_URL, $url); // set the url variable to curl
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return output as string
            $response = curl_exec($curl); // execute curl call
            curl_close($curl); // close curl
            $responseBody = json_decode($response, true); // decode the response

            if(!isset($responseBody['error'])) {
                // Sucesso
                $retorno = array(
                    'status'   => "sucesso",
                    'dados'    => $responseBody,
                    'response' => $response
                );
            }else{
                // Erro
                $retorno = array(
                    'status'  => "erro",
                    'dados'   => "",
                    'retorno' => $responseBody['error']['message']
                );
            }
        } catch (Exception $e) {
            // Erro
            $retorno = array(
                'status'  => "erro",
                'dados'   => "",
                'retorno' => $e->getMessage()
            );
        }

        // Retorna json
		return json_encode($retorno);
    }

	/**
	 * Busca o feed do usuário (/feed)
	 */
    public function getFeed() {
        try {
            // Params
            $fields = "&fields=id,type,link,permalink_url,full_picture,picture,message,created_time";
            $default_graph_version = 'v14.0';

            // Curl
            $curl = curl_init();
            $url = "https://graph.facebook.com/".$default_graph_version."/".$this->credentials['user_id']."/feed?access_token=".$this->credentials['app_token_page'].$fields;
            curl_setopt($curl, CURLOPT_URL, $url); // set the url variable to curl
            //curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return output as string
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl); // execute curl call
            curl_close($curl); // close curl
            $responseBody = json_decode($response, true); // decode the response

            //echo($url);
            //Zend_Debug::dump($responseBody);exit;

            if(!isset($responseBody['error'])) {
                // Sucesso
                $retorno = array(
                    'status'   => "sucesso",
                    'dados'    => $responseBody["data"],
                    'response' => $response
                );
            }else{
                // Erro
                $retorno = array(
                    'status'  => "erro",
                    'dados'   => "",
                    'retorno' => $responseBody['error']['message']
                );
            }
        } catch (Exception $e) {
            // Erro
            $retorno = array(
                'status'  => "erro",
                'dados'   => "",
                'retorno' => $e->getMessage()
            );
        }

    	// Retorna json
		return json_encode($retorno);
    }

    /**
	 * Busca os posts do usuário (/posts)
	 */
    public function getPosts() {
        try {
            // Params
            //$fields = "&fields=attachments";
            $fields = "&fields=id,type,link,permalink_url,full_picture,picture,message,created_time";
            $default_graph_version = 'v14.0';

            // Curl
            $curl = curl_init();
            $url = "https://graph.facebook.com/".$default_graph_version."/".$this->credentials['user_id']."/posts?access_token=".$this->credentials['app_token_page'].$fields;
            curl_setopt($curl, CURLOPT_URL, $url); // set the url variable to curl
            //curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return output as string
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl); // execute curl call
            curl_close($curl); // close curl
            $responseBody = json_decode($response, true); // decode the response

            if(!isset($responseBody['error'])) {
                // Sucesso
                $retorno = array(
                    'status'   => "sucesso",
                    'dados'    => $responseBody["data"],
                    'response' => $response
                );
            }else{
                // Erro
                $retorno = array(
                    'status'  => "erro",
                    'dados'   => "",
                    'retorno' => $responseBody['error']['message']
                );
            }
        } catch (FacebookSDKException $e) {
            // Erro
            $retorno = array(
                'status'  => "erro",
                'dados'   => "",
                'retorno' => $e->getMessage()
            );
        }

    	// Retorna json
		return json_encode($retorno);
    }

    /**
     * Função chamada no init()
     * Validação de token na sessão e no banco
     */
    private function validatoken() {
        // Inicia
        $gerarNovoToken = false;

        // Verifica se já está na sessão
        if(empty($this->session_token_facebook->token) || empty($this->session_token_facebook->token_page)) {
            // Busca token no banco de dados
            $row = (new Admin_Model_Tokensmidias())->fetchRow(array('type = ?' => 'facebook'), "id DESC");
            if($row) {
                if(!empty($row->token) && !empty($row->token_page)) {
                    // Verifica status do token
                    $getStatus      = $this->testerToken($row->token, 'user');
                    $getStatus_page = $this->testerToken($row->token_page, 'page');

                    $decode = json_decode($getStatus);
                    $decode_page = json_decode($getStatus_page);

                    if($decode->validado && $decode_page->validado) {
                        // Válido
                        $this->session_token_facebook->token      = $row->token;
                        $this->session_token_facebook->token_page = $row->token_page;
                    }else{
                        $gerarNovoToken = true;
                    }
                }else{
                    $gerarNovoToken = true;
                }
            }else{
                $gerarNovoToken = true;
            }
        }

        // Verifica se gera novo token
        if($gerarNovoToken) {
            // Gerar um novo token user
            $newToken    = $this->getTokenUser();
            $decodeToken = json_decode($newToken);

            // Gerar um novo token page
            $newToken_page    = $this->getTokenPage();
            $decodeToken_page = json_decode($newToken_page);

            if(!empty($decodeToken->token) && !empty($decodeToken_page->token_page)) {
                // Salvar no banco
                (new Admin_Model_Tokensmidias())->insert(array(
                    'type' => 'facebook', 'token' => trim($decodeToken->token), 'token_page' => trim($decodeToken_page->token_page), 'date' => date("Y-m-d H:i:s")
                ));

                // Atualizar sessão
                $this->session_token_facebook->token      = trim($decodeToken->token);
                $this->session_token_facebook->token_page = trim($decodeToken->token_page);
            }
        }
    }

    /**
     * cURL
     *
     * Função que pega por cURL as requisições de autenticação e demais (GET/POST/DELETE/UPDATE)
     * @link http://php.net/manual/en/book.curl.php
     */
    private function curl($url, $method = 'GET', $postFields = null, $timeout = 20, $charset = 'ISO-8859-1') {
        if (strtoupper($method) === 'POST') {
            $methodOptions = array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postFields,
            );
        } else {
            $methodOptions = array(
                CURLOPT_HTTPGET => true
            );
        }

        $options = array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            //CURLOPT_TIMEOUT => $timeout
        );

        $options = ($options + $methodOptions);

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $resp = curl_exec($curl);
        // $info = curl_getinfo($curl);
        $error = curl_errno($curl);
        $errorMessage = curl_error($curl);
        curl_close($curl);

        if ($error) {
            throw new Exception("CURL can't connect: $errorMessage");
        } else {
            return $resp;
        }
    }
}
