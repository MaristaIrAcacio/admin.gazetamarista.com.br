<?php

/**
 * Classe para rede social do twitter
 *
 * @name gazetamarista_Social_Twitter
 */
class gazetamarista_Social_Twitter
{

	/**
	 * Log do Zend
	 *
	 * @var Zend_Log
	 */
	private $log;

	/**
	 * API base
	 *
	 * @var string
	 */
	private $api;

	/**
	 * API key
	 *
	 * @var string
	 */
	private $api_key;

	/**
	 * API secret
	 *
	 * @var string
	 */
	private $api_secret;

	/**
	 * Zend config
	 *
	 * @var mixed
	 */
	public $session_config;

	function __construct($credential)
	{
		$this->log = inicia_log('twitter');

		$this->session_config = new Zend_Session_Namespace("configuracao");

		$this->api        = 'https://api.twitter.com';
		$this->api_key    = $this->session_config->dados->twitter_api_key;
		$this->api_secret = $this->session_config->dados->twitter_secret_key;
		$this->credential = $credential;

		return $this;
	}

	function generateOauthSignature($method, $url, $consumerKey, $nonce, $signatureMethod, $timestamp, $version, $consumerSecret, $tokenSecret, $tokenValue, $extraParams = array())
	{
		$base = strtoupper($method) . "&" . rawurlencode($url) . "&"
			. rawurlencode("oauth_consumer_key=" . $consumerKey
				. "&oauth_nonce=" . $nonce
				. "&oauth_signature_method=" . $signatureMethod
				. "&oauth_timestamp=" . $timestamp
				. "&oauth_token=" . $tokenValue
				. "&oauth_version=" . $version);

		if (!empty($extraParams)) {
			$base .= rawurlencode("&" . http_build_query($extraParams));
		}

		$key = rawurlencode($consumerSecret) . '&' . rawurlencode($tokenSecret);
		$signature = base64_encode(hash_hmac('sha1', $base, $key, true));

		return rawurlencode($signature);
	}

	/**
	 * Gera assinatura
	 *
	 * @param        $httpRequestMethod
	 * @param        $url
	 * @param        $params
	 * @param string $tokenSecret
	 *
	 * @return string
	 */
	public function createSignature($httpRequestMethod, $url, $params, $tokenSecret = '')
	{
		$strParams = rawurlencode(http_build_query($params));

		$baseString = $httpRequestMethod . "&" . rawurlencode($url) . "&" . $strParams;

		$signKey = rawurlencode($this->api_key);

		if( !empty($tokenSecret) )
		{
			$signKey = "&" . $signKey . rawurlencode($tokenSecret);
		}

		return base64_encode(hash_hmac('sha1', $baseString, $signKey, true));
	}

	/**
	 * Generate oauth header
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function generateOauthHeader($params)
	{
		foreach( $params as $k => $v )
		{

			$oauthParamArray[] = $k . '="' . rawurlencode($v) . '"';
		}

		$oauthHeader = implode(',', $oauthParamArray);

		return $oauthHeader;
	}

	/**
	 * Get user data
	 *
	 * @return mixed
	 * @throws Exception
	 */
	function me()
	{
		$url      = '/oauth/request_token';
		$full_url = $this->api . $url;

		#'oauth_callback' => 'https://' . Zend_Registry::get("config")->gazetamarista->config->domain . Zend_Registry::get("config")->gazetamarista->config->basepath . '/apiv2/auth/rota_acao?acao=twitter-callback',
		$headers = [
			'oauth_consumer_key'     => $this->api_key,
			'oauth_nonce'            => time(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp'        => time(),
			'oauth_version'          => '1.0',
			'oauth_callback'         => 'http://www.erickmonteiro.com.br/callback',
		];

		#$headers['oauth_signature'] = $this->createSignature('POST', $full_url, $headers);
		$headers['oauth_signature'] = $this->generateOauthSignature('POST', $full_url, $headers['oauth_consumer_key'], $headers['oauth_nonce'], $headers['oauth_signature_method'], $headers['oauth_timestamp'], $headers['oauth_version'], '', '', '', $extraParams = []);

		$oauthHeader = $this->generateOauthHeader($headers);

		$headers = [
			'Authorization' => 'OAuth ' . $oauthHeader,
			#'Authorization' => 'OAuth ' . urlencode('oauth_consumer_key='.$headers['oauth_consumer_key'].'&oauth_nonce='.$headers['oauth_nonce'].'&oauth_signature_method='.$headers['oauth_signature_method'].'&oauth_timestamp='.$headers['oauth_timestamp'].'&oauth_version='.$headers['oauth_version'].'&oauth_callback='.$headers['oauth_callback'].'&oauth_signature='.$oauthHeader),
			#'Authorization' => 'OAuth oauth_consumer_key="jvDZzzKEJ558kwwWV4DOrU1UK",oauth_signature_method="HMAC-SHA1",oauth_timestamp="1649800521",oauth_nonce="jlNEt1pVjj1TS1yfETaMLCIdEQg78Hx2fyb2RNxXHr",oauth_version="1.0",oauth_callback="http%3A%2F%2Fwww.erickmonteiro.com.br%2Fcallback",oauth_signature="klV28%2Bh2Qxn06vQVqgXlsb292Js%3D',
		];

		return $this->send('post', $url, [], $headers);
	}

	/**
	 * Send request
	 *
	 * @param       $method
	 * @param       $url
	 * @param array $data
	 * @param array $headers
	 *
	 * @return object
	 * @throws Exception
	 */
	private function send($method, $url, array $data = [], array $headers = [])
	{
		$client = new Zend_Http_Client();
		$client->setUri($this->api . $url);
		#$client->setHeaders([
		#	'Content-Type' => 'application/json; charset=utf-8',
		#]);
		$client->setHeaders($headers);

		if( em_desenvolvimento() )
		{
			$this->log->info('----');
			$this->log->info($method);
			$this->log->info($this->api . $url);

			foreach( $data as $key => $data_ )
			{
				$this->log->info($key . ' : ' . $data_);
			}

			foreach( $headers as $key => $header )
			{
				$this->log->info($key . ' : ' . $header);
			}
		}

		if( $method === 'get' )
		{
			$resposta = $client->setParameterGet($data)->request('GET');
		}
		elseif( $method === 'post' )
		{
			$resposta = $client->setParameterPost($data)->request('POST');
		}

		echo $resposta->getBody();
		exit;

		if( em_desenvolvimento() )
		{
			$this->log->info($resposta->getBody());
		}

		$data = @json_decode($resposta->getBody());

		// Error
		if( $resposta->getStatus() >= 400 and $resposta->getStatus() <= 500 )
		{
			$error = $data->errors[0]->message;

			throw new Exception($error);
		}

		return $data;
	}
}
