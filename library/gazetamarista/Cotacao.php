<?php

/**
 * Classe que busca cotações
 * 
 * @name gazetamarista_Cotacao
 */
class gazetamarista_Cotacao extends Zend_Mail {
	/**
	 * Armazena as configurações gerais
	 *
	 * @access private
	 * @name _config
	 * @var Zend_Config
	 */
	private $_config = NULL;
	
	/**
	 * Método de inicialização da classe
	 * 
	 * @name init
	 */
	public function __construct() {

	}
	
	/**
	 * Retorna a cotacao dolar
	 * 
	 * @name dolar
	 * @return array
	 */
	public function dolar() {
	    // Data atual
        $data_atual = date("m-d-Y"); //MM-DD-YYYY

        // Url 2 (https://docs.awesomeapi.com.br/api-de-moedas)
        $url = 'http://economia.awesomeapi.com.br/json/all/USD-BRL';

        //USD-BRL (Dólar Comercial)
        //USDT-BRL (Dólar Turismo)
        //bid = Compra
        //ask = Venda

	    // Cria o objeto de requisição remota e configura
		$client = new Zend_Http_Client();
		$client->setUri($url);

		// Faz a requisição
		$response = $client->request("GET");
		$json     = $response->getBody();
        $decode   = json_decode($json);

		$var_compra = NULL;
		if(!empty($decode->USD->bid)) {
		    $var_compra = number_format($decode->USD->bid, 2, ',', '');
        }

        $var_venda = NULL;
		if(!empty($decode->USD->ask)) {
		    $var_venda = number_format($decode->USD->ask, 2, ',', '');
        }

        $var_data = NULL;
		if(!empty($decode->USD->create_date)) {
		    $var_data = date_format(date_create($decode->USD->create_date),"d/m/Y");
		    $var_hora = date_format(date_create($decode->USD->create_date),"H:i:s");
        }

		// Retorno 2
		$retorno = array(
		    'nome'   => 'Dólar comercial',
		    'compra' => $var_compra,
            'venda'  => $var_venda,
            'data'   => $var_data,
            'hora'   => $var_hora
        );
		
		// Retorna os valores
		return $retorno;
	}

	/**
	 * Retorna a cotacao commodities
	 *
	 * @name commodities
     * @param string $type tipo específico na busca
	 * @return array
	 */
	public function commodities($type='') {
	    // Envio ex soja
        //https://www.noticiasagricolas.com.br/cotacoes/soja.json

        // Data atual
        $data_atual = date("m-d-Y"); //MM-DD-YYYY

        // Url base
        $url_base = 'https://www.noticiasagricolas.com.br/cotacoes/';

        // Commodities
        $commodities = array(
			(object) array(
				'type'        => 'Soja',
				'name_search' => 'Soja - Bolsa de Chicago',
				'name'        => 'Soja - Chicago (CME)',
				'url'         => $url_base . 'soja.json',
				'price_title' => 'Fechamento',
				'price_label' => 'US$/Bushel',
				'price'       => 'us$',
				'columns'     => (object) array(
					'place'     => 50,
					'price'     => 51,
					'variation' => 374,
                ),
            ),
			(object) array(
				'type'        => 'Soja-PR',
				'name_search' => 'Indicador da Soja Cepea/Esalq - Paraná',
				'name'        => 'Soja Cepea/Esalq - PR',
				'url'         => $url_base . 'soja.json',
				'price_title' => 'Fechamento',
				'price_label' => 'R$/Saca 60 kg',
				'price'       => 'r$',
				'columns'     => (object) array(
					'place'     => 55,
					'price'     => 56,
					'variation' => 57,
                ),
            ),
			(object) array(
				'type'        => 'Milho',
				'name_search' => 'Milho - Bolsa de Chicago',
				'name'        => 'Milho - Chicago (CME)',
				'url'         => $url_base . 'milho.json',
				'price_title' => 'Fechamento',
				'price_label' => 'US$/Bushel',
				'price'       => 'us$',
				'columns'     => (object) array(
					'place'     => 70,
					'price'     => 71,
					'variation' => 373,
                ),
            ),
			(object) array(
				'type'        => 'Trigo',
				'name_search' => 'Trigo - Bolsa de Chicago',
				'name'        => 'Trigo - Chicago (CME)',
				'url'         => $url_base . 'trigo.json',
				'price_title' => 'Fechamento',
				'price_label' => 'US$/Bushel',
				'price'       => 'us$',
				'columns'     => (object) array(
					'place'     => 241,
					'price'     => 242,
					'variation' => 372,
                ),
            ),
			(object) array(
				'type'        => 'Boi-Gordo',
				'name_search' => 'Boi Gordo - B3 (Pregão Regular)',
				'name'        => 'Boi Gordo - B3',
				'url'         => $url_base . 'boi-gordo.json',
				'price_title' => 'Fechamento',
				'price_label' => 'R$/@',
				'price'       => 'r$',
				'columns'     => (object) array(
					'place'     => 776,
					'price'     => 777,
					'variation' => 778,
                ),
            )
        );

        // Retorno
        $arr_commodity = array();

        foreach( $commodities as $commodity ) {
            // Validação se busca todos ou apenas um item
            if( empty($type) || mb_strtolower($type) == mb_strtolower($commodity->type) ) {
                // Cria o objeto de requisição remota e configura
                $config = array(
                    'adapter'     => 'Zend_Http_Client_Adapter_Curl',
                    'curloptions' => array(CURLOPT_SSL_VERIFYPEER => false)
                );

                $client = new Zend_Http_Client($commodity->url, $config);

                // Faz a requisição
                $response   = $client->request("GET");
                $json       = $response->getBody();
                $attributes = json_decode($json, true);

                foreach( $attributes['tabelas'] as $tabela ) {
                    // Filter by name_search
                    if( $tabela['titulo'] === $commodity->name_search ) {
                        $date = $tabela['data'];

                        foreach( $tabela['valores'] as $values ) {
                            $place     = $values[$commodity->columns->place];
                            $price     = $values[$commodity->columns->price];
                            $price     = (float) str_replace(',', '.', preg_replace('/[^0-9,\/]/', '', $price));
                            $variation = (float) str_replace(',', '.', preg_replace('/[^0-9,-\/]/', '', $values[$commodity->columns->variation]));

                            if( $price === 0.0 ) continue;

                            if( $commodity->price == 'us$' ) {
                                $price = $price * 100;
                            }

                            // Completa
    //                        $arr_commodity[strtolower($commodity->type)] = array(
    //                            'type'        => $commodity->type,
    //                            'name'        => $commodity->name,
    //                            'city'        => $place,
    //                            'place'       => $place,
    //                            'price_title' => $commodity->price_title,
    //                            'price_label' => $commodity->price_label,
    //                            'price'       => $price,
    //                            'variation'   => $variation,
    //                            'date'        => $date,
    //                            'lat'         => null,
    //                            'lon'         => null,
    //                        );

                            $var_data = NULL;
                            if(!empty($date)) {
                                $var_data = date_format(date_create($date),"d/m/Y");
                                $var_hora = date_format(date_create($date),"H:i:s");
                            }

                            // Resumo
                            $arr_commodity[mb_strtolower($commodity->type)] = array(
                                'type'   => mb_strtolower($commodity->type),
                                'nome'   => $commodity->name,
                                'label'  => $place,
                                'compra' => (string)$price,
                                'data'   => $var_data,
                                'hora'   => $var_hora
                            );

                            // Retorna o primeiro array caso possua mais
                            break;
                        }
                    }
                }
            }
        }

		// Retorna os valores
		return $arr_commodity;
	}
}