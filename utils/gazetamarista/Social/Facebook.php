<?php

/**
 * Classe para rede social do facebook
 *
 * @name gazetamarista_Social_Facebook
 */
class gazetamarista_Social_Facebook
{

	/**
	 * Log do Zend
	 *
	 * @var Zend_Log
	 */
	private $log;

	/**
	 * API version
	 *
	 * @var string
	 */
	private $apiVersion = 'v13.0';

	/**
	 * API base
	 *
	 * @var string
	 */
	private $api;

	/**
	 * User acces token
	 *
	 * @var string
	 */
	private $access_token;

	function __construct($access_token)
	{
		$this->log = inicia_log('facebook');

		$this->api          = 'https://graph.facebook.com/' . $this->apiVersion;
		$this->access_token = $access_token;

		return $this;
	}

	/**
	 * Get user access token
	 *
	 * @return string
	 */
	public function getUserAccessToken()
	{
		return $this->access_token;
	}

	/**
	 * Get user data
	 *
	 * @return mixed
	 * @throws Exception
	 */
	function me()
	{
		$params = [
			'fields' => 'id,name,email,first_name,last_name,picture.width(170).height(170)',
		];

		return $this->send('get', '/me', $params);
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
	private function send($method, $url, array $data = [], array $headers = [])
	{
		$client = new Zend_Http_Client();
		$client->setUri($this->api . $url);
		$client->setHeaders([
			'Content-Type' => 'application/json; charset=utf-8',
		]);
		$client->setHeaders($headers);

		// Set access token
		$data['access_token'] = $this->access_token;

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

		if( em_desenvolvimento() )
		{
			$this->log->info($resposta->getBody());
		}

		$data = @json_decode($resposta->getBody());

		// Error
		if( $resposta->getStatus() >= 400 and $resposta->getStatus() <= 500 )
		{
			$error = $data->error->message;

			throw new Exception($error);
		}

		return $data;
	}
}
