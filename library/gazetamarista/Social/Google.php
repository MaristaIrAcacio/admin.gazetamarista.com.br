<?php

/**
 * Classe para rede social do google
 *
 * @name gazetamarista_Social_Google
 */
class gazetamarista_Social_Google
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
	 * User credential
	 *
	 * @var string
	 */
	private $credential;

	function __construct($credential)
	{
		$this->log = inicia_log('google');

		$this->api        = 'https://oauth2.googleapis.com';
		$this->credential = $credential;

		return $this;
	}

	/**
	 * Get user access token
	 *
	 * @return string
	 */
	public function getUserAccessToken()
	{
		return $this->credential;
	}

	/**
	 * Get user data
	 *
	 * @return mixed
	 * @throws Exception
	 */
	function me()
	{
		return $this->send('get', '/tokeninfo?id_token=' . $this->credential);
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
			$error = $data->error_description ?? $data->error;

			throw new Exception($error);
		}

		return $data;
	}
}
