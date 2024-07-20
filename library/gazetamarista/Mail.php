<?php

/**
 * Classe de envio de emails
 * 
 * @name gazetamarista_Mail
 */
class gazetamarista_Mail extends Zend_Mail {
	/**
	 * Armazena o transporte do email
	 *
	 * @access private 
	 * @name _transport
	 * @var Zend_Mail_Transport_Smtp
	 */
	private $_transport = NULL;
	
	/**
	 * Método de inicialização da classe
	 * 
	 * @name init
	 * @param string $encode Codificação do email
	 */
	public function __construct($encode=NULL) {
		// Busca as configurações
		$config = Zend_Registry::get("config");
		
		// Verifica as configurações padrão
		$ssl = "ssl";
		if(isset($config->gazetamarista->email->ssl)) {
			$ssl = $config->gazetamarista->email->ssl;
		}
		
		$port = "465";
		if(isset($config->gazetamarista->email->port)) {
			$port = $config->gazetamarista->email->port;
		}
		
		$auth = "login";
		if(isset($config->gazetamarista->email->auth)) {
			$auth = $config->gazetamarista->email->auth;
		}
		
		if(isset($config->gazetamarista->email->encode)) {
			$encode = $config->gazetamarista->email->encode;
		}
		
		// Constroi o parent
		parent::__construct($encode);
		
		// Cria a configuração do email
		$email_conf = array(
			'auth' => $auth,
			'username' => $config->gazetamarista->email->username,
			'password' => $config->gazetamarista->email->password,
			'ssl' => $ssl,
			'port' => $port
		);
		
		// Cria o objeto de transport
		$this->_transport = new Zend_Mail_Transport_Smtp($config->gazetamarista->email->smtp, $email_conf);
		
		// Verifica se possui email e nome default
		if((isset($config->gazetamarista->email->default->email)) && (isset($config->gazetamarista->email->default->nome))) {
			parent::setFrom($config->gazetamarista->email->default->email, $config->gazetamarista->email->default->nome);
		}
	}
	
	/**
	 * Método para enviar o email
	 * 
	 * @name send
	 */
	public function send() {
		// Envia o email
		parent::send($this->_transport);
	}
	
	/**
	 * Adiciona imagens ao corpo do email
	 * 
	 * @name addEmbeddedImage
	 * @param string $image Imagem á ser anexada
	 * @param string $id ID da imagem
	 * @param string $path Caminho relativo usado no email
	 */
	public function addEmbeddedImage($image, $id, $path) {
		$attach = parent::createAttachment(
			file_get_contents($image),
			"image/png",
			Zend_Mime::DISPOSITION_INLINE,
			Zend_Mime::ENCODING_BASE64,
			$path
		);
		
		$attach->id = $id;
		
		return $this;
	}

	/**
	 * Função para trocar as variaveis do template dos emails
	 * 
	 */
	public function trocarVarEmails($data = null, $contents) {
		// Busca o config
		$config = Zend_Registry::get("config");

		// Captura o domínio
		if($_SERVER['HTTP_HOST'] == "localhost") {
			$url_dominio = "http://localhost" . $config->gazetamarista->config->basepath;
		}elseif($_SERVER['HTTP_HOST'] == "sites.gazetamarista.com.br") {
			$url_dominio = "http://sites.gazetamarista.com.br" . $config->gazetamarista->config->basepath;
		}else{
			$url_dominio = "https://" . $config->gazetamarista->config->domain;
		}
		
		// Contents
		$contents = str_replace ( "{\$siteurl}", $url_dominio, $contents);
		$contents = str_replace ( "{\$sitename}", $url_dominio, $contents);
		$contents = str_replace ( "{\$logo-site}", $url_dominio . "/common/email/images/logo-cliente.png", $contents);
		$contents = str_replace ( "{\$imagePath}", $url_dominio . "/common/email/images/", $contents);		
		$contents = str_replace ( "{\$datetime}", date ( "d/m/Y", strtotime ( date("Y-m-d") ) ) . " " . date("H:i:s"), $contents);
		$contents = str_replace ( "{\$ip}", $_SERVER ['REMOTE_ADDR'], $contents);

		foreach($data as $key => $value) {
			// Condições especiais para tratar diferente o campo (adicionar outras especiais, caso necessário)
			if($key == 'mensagem'){
				$contents = str_replace ( "{\$".$key."}", nl2br($value), $contents);
			}
			elseif($key == 'arquivo'){
				$arquivo_html = "
					<a href='". $url_dominio . $value."' target='_blank'>visualizar</a>
				";
				$contents = str_replace ( "{\$".$key."}", $arquivo_html, $contents);
			}
			else{
				$contents = str_replace ( "{\$".$key."}", $value, $contents);
			}
		}

		return $contents;
	}
}