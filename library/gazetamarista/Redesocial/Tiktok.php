<?php
/**
 * Classe de Tiktok
 *
 * @name gazetamarista_Redesocial_Tiktok
 */
class gazetamarista_Redesocial_Tiktok {

	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "tiktok";

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
        $this->session_token_tiktok = new Zend_Session_Namespace("token_tiktok");

		// Credentials
        $this->credentials = array(
            'user_id'           => '00041400581769117', // id do tiktok
            'user_token'        => '',
            'app_id'            => '',
            'app_code'          => '',
            'app_key'           => '',
            'app_secret'        => '',
            'app_application'   => 'Teste app',
            'app_token'         => $this->session_token_facebook->token,
            'app_token_create'  => ''
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
        $this->credentials['app_token'] = $this->session_token_tiktok->token;
	}

    /**
     * Busca o token de acesso
     */
    public function getToken() {
        if(!empty($this->session_token_tiktok->token)) {
            $app_token = $this->session_token_tiktok->token;
        }else{
            $app_token = $this->credentials['app_token_create'];
        }

        try {
            // Curl
            $curl = curl_init();
            $url = "https://open-api.tiktok.com/oauth/access_token";
            $postFields = array(
                "client_key"    => $this->credentials['app_key'],
                "client_secret" => $this->credentials['app_secret'],
                "code"          => $this->credentials['app_code'],
                "grant_type"    => "authorization_code"
            );
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($curl, CURLOPT_URL, $url); // set the url variable to curl
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return output as string
            $response = curl_exec($curl); // execute curl call
            curl_close($curl); // close curl
            $responseBody = json_decode($response, true); // decode the response (without true this will crash)

            // Retorno
            $open_id        = $responseBody['open_id'];
            $access_token   = $responseBody['access_token']; // valid for 24 hours
            $refresh_token  = $responseBody['refresh_token']; // valid for 365 days

            if(!isset($responseBody['error'])) {
                // Sucesso
                $retorno = array(
                    'status'        => "sucesso",
                    'open_id'       => $open_id,
                    'token'         => $access_token,
                    'refresh_token' => $refresh_token,
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
    public function testerToken($token=null) {
        if($token == null) {
            $token = $this->credentials['app_token'];

            if(!empty($token)) {
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
                    $expira_seg     = (int)$responseBody['data']['expires_at'];
                    $expira_em_dias = floor(($expira_seg - $emitido_seg) / 86400);

                    // Se faltar menos de 10 dias, gera novamente o token
                    if($expira_em_dias < 10) {
                        $validado = false;
                    }
                }

                // Sucesso
                $retorno = array(
                    'status'         => "sucesso",
                    'validado'       => $validado,
                    'issued_at'      => $emitido_seg,
                    'expires_at'     => $expira_seg,
                    'expira_em_dias' => $expira_em_dias,
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
     * Busca dados do usuário
     */
    public function getUser() {
        try {
            // Params
            $fields = "&fields=id,name,username";
            $default_graph_version = 'v12.0';

            // Curl
            $curl = curl_init();
            $url = "https://graph.facebook.com/".$default_graph_version."/".$this->credentials['user_id']."?access_token=".$this->credentials['app_token'].$fields;
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
	 * Busca o feed do usuário (/media)
	 */
    public function getFeed() {
        try {
            // Params
            $fields = "&fields=id,media_type,media_url,thumbnail_url,caption,permalink,timestamp,username,owner";
            $default_graph_version = 'v12.0';

            // Curl
            $curl = curl_init();
            $url = "https://graph.facebook.com/".$default_graph_version."/".$this->credentials['user_id']."/media?access_token=".$this->credentials['app_token'].$fields;
            curl_setopt($curl, CURLOPT_URL, $url); // set the url variable to curl
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // return output as string
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
     * Função chamada no init()
     * Validação de token na sessão e no banco
     */
    private function validatoken() {
        // Inicia
        $gerarNovoToken = false;

        // Verifica se já está na sessão
        if(empty($this->session_token_facebook->token)) {
            // Busca token no banco de dados
            $row = (new Admin_Model_Tokensmidias())->fetchRow(array('type = ?' => 'facebook'), "id DESC");
            if($row) {
                if(!empty($row->token)) {
                    // Verifica status do token
                    $getStatus = $this->testerToken($row->token);
                    $decode = json_decode($getStatus);
                    if($decode->validado) {
                        // Válido
                        $this->session_token_facebook->token = $row->token;
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
            // Gerar um novo token
            $newToken = $this->getToken();
            $decodeToken = json_decode($newToken);
            if(!empty($decodeToken->token)) {
                // Salvar no banco
                (new Admin_Model_Tokensmidias())->insert(array('type' => 'facebook', 'token' => trim($decodeToken->token), 'date' => date("Y-m-d H:i:s")));

                // Atualizar sessão
                $this->session_token_facebook->token = trim($decodeToken->token);
            }
        }
    }
}
