<?php
/**
 * Classe de pagamentos por eRede
 *
 * @name gazetamarista_Pagamentos_Erede
 */
class gazetamarista_Pagamentos_Erede extends gazetamarista_Pagamentos_Abstract {

	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "erede";

	private $store;
	private $_application_config;
	private $_modules;
    private $session_config;

	/**
	 * Inicializa a classe de pagamento
	 *
	 * @name init
	 */
	public function init() {
		// Sessão de configuração
		$this->session_config = new Zend_Session_Namespace("configuracao");

		// Sessão do pagamento criado
        $this->tracking_ecommerce = new Zend_Session_Namespace("tracking_ecommerce");

		// Armazena as configurações globais
		$this->_application_config = Zend_Registry::get("config");
		$this->_modules = Zend_Registry::get("modulos");

		// Verifica id da assinatura
        if(empty($this->_idassinatura)) {
            return array('retorno' => "Pagamento não gerado corretamente.", 'status' => "erro");
            die();
        }

		// Função de bloquear injection
		$this->sanitize = new gazetamarista_Sanitize();

        // Busca as configurações
        $config = Zend_Registry::get("config");

        // Domínio
        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $this->dominio = "http://localhost" . $config->gazetamarista->config->basepath;
        } elseif ($_SERVER['HTTP_HOST'] == "sites.gazetamarista.com.br") {
            $this->dominio = "http://sites.gazetamarista.com.br" . $config->gazetamarista->config->basepath;
        } elseif ($_SERVER['HTTP_HOST'] == "local.gazetamarista.com.br") {
            $this->dominio = "http://local.gazetamarista.com.br" . $config->gazetamarista->config->basepath;
        } elseif ($_SERVER['HTTP_HOST'] == "192.168.1.222") {
            $this->dominio = "http://192.168.1.222" . $config->gazetamarista->config->basepath;
        } else {
            $this->dominio = "https://" . $config->gazetamarista->config->domain;
        }

        // Chama a biblioteca do e-Rede
        require_once(APPLICATION_PATH."/../library/gazetamarista/Library/Erede/vendor/autoload.php");

        // *********************************************************************************
        // Verifica configuração da loja
    	if($this->session_config->dados->pagto_ativo) {
            if (getenv('APPLICATION_ENV') != "production") {
                // ** Loja teste Pett Love *******
                $loja_pv    = "27603781";
                $loja_token = "01646a126766404783bbf5f214b6d486";

                // Configuração da loja
                $this->store = new \Rede\Store($loja_pv, $loja_token, \Rede\Environment::sandbox());
            } else {
                // ** Loja producao Pett Love *******
                $loja_pv    = "88884651";
                $loja_token = "c10a266c4b124d2f91c3abde0f85a914";

                // Configuração da loja
                $this->store = new \Rede\Store($loja_pv, $loja_token, \Rede\Environment::production());
            }
        }else{
    		throw new Exception("Sistema inativo, verifique configuração de pagamento.");
    	}
        // *********************************************************************************
	}

    /**
	 *
	 * Envia Requisição para criar a transação
	 *
	 * O retorno do método register, por padrão, será um objeto com a resposta da requisição
	 *
	 */
    public function enviarTransacao($metodoPagto = null, $parametros = '') {
        // Result
        $retorno = array();

        // Adiciona o model
        $model_clientes = new Admin_Model_Clientes();

        // Tipo de pagamento cartão de crédito
        if ($metodoPagto == 'credit_card') {

            // Validade cartão
            $vencimento_arr = explode("/", $parametros['card_validade']);
            if(count($vencimento_arr) > 0) {
                $mesCartao = $vencimento_arr[0];
                $anoCartao = '20' . $vencimento_arr[1];
            }else{
                $mesCartao = null;
                $anoCartao = null;
            }

            // Parâmetros cartão de crédito
            $cc_documento   = $parametros['card_cpf'];
            $cc_name        = $parametros['card_nome'];
            $cc_number      = str_replace(" ", "", $parametros['card_numero']);
            $expiracao      = $parametros['card_validade'];
            $cc_cvv         = $parametros['card_cvv'];
            $valortotal     = str_replace('.', '', $parametros['valor_plano']);
            $parcelas       = $parametros['card_parcela'];
            $final_cartao   = substr(trim($cc_number), -4);
            $recorrente     = $parametros['recorrente'];
            $renovar_plano  = $parametros['renovar_plano'];

            $parse_telefone = explode(' ', $this->_cliente->telefone);
            if (count($parse_telefone) > 0) {
                $ddd_pagamento = str_replace(")", "", str_replace("(", "", $parse_telefone[0]));
                $telefone_pagamento = str_replace("-", "", $parse_telefone[1]);
            } else {
                $ddd_pagamento = "";
                $telefone_pagamento = $this->_cliente->telefone;
            }

            // Monta a versão da referencia do pagamento
            $session_refversion = (int)$this->tracking_ecommerce->refversion;
            if($session_refversion > 0) {
                $session_refversion++;
            }else{
                $session_refversion = 1;
            }
            $this->tracking_ecommerce->refversion = $session_refversion;

            // Transação que será autorizada
            $transaction = new \Rede\Transaction($parametros['valor_plano'], 'assinatura' . $this->_idassinatura . 'v' . $session_refversion);
            $transaction->creditCard(
                $cc_number,
                $cc_cvv,
                $mesCartao,
                $anoCartao,
                $cc_name
            );

            // Tipo
            $transaction->setKind('credit');

            if ($parcelas > 1) {
                // Parcelamento (De 2 a 12, não enviar o parâmetro para a vista)
                $transaction->setInstallments($parcelas);
            }

            try {
                // Criar a transação
                $transaction = (new \Rede\eRede($this->store))->create($transaction);

                $array_return = array(
                    'reference'         => $transaction->getReference(),
                    'authorizationCode' => $transaction->getAuthorizationCode(),
                    'amount'            => $transaction->getAmount(),
                    'cardBin'           => $transaction->getCardBin(),
                    'cardHolderName'    => $transaction->getCardHolderName(),
                    'last4'             => $transaction->getLast4(),
                    'kind'              => $transaction->getKind(),
                    'returnCode'        => $transaction->getReturnCode(),
                    'returnMessage'     => $transaction->getReturnMessage(),
                    'tid'               => $transaction->getTid()
                );

                if ($transaction->getReturnCode() == '00') {
                    // SUCESSO
                    $retorno['retorno'] = $array_return;
                    $retorno['status'] = "sucesso";
                } else {
                    // ERRO
                    $retorno['retorno'] = $array_return;
                    $retorno['status'] = "erro";
                }
            } catch (Exception $ex) {
                $retorno['retorno'] = $ex->getMessage();
                $retorno['status'] = "erro";
            }

        }else if ($metodoPagto == 'debit') {
            // Débito

            $retorno['retorno'] = "Método não liberado.";
            $retorno['status']  = "erro";
        } else {
            $retorno['retorno'] = "Método inválido.";
            $retorno['status']  = "erro";
        }

        // Salva log e atualiza tabela pedido
        $this->status($retorno['status'], $retorno, 'eRede');

        // Return
        return $retorno;
    }

    /**
	 *
	 * Envia Requisição para criar a transação com token de cartão
	 *
	 * O retorno do método register, por padrão, será um objeto com a resposta da requisição
	 *
	 */
    public function enviarTransacaoCardToken($metodoPagto = null, $parametros = '') {
        // Result
        $retorno = array();

        // Adiciona o model
        $model_clientes = new Admin_Model_Clientes();

        // Tipo de pagamento cartão de crédito
        if ($metodoPagto == 'credit_card') {

        } else {
            $retorno['retorno'] = "Método inválido.";
            $retorno['status']  = "erro";
        }

        // Salva log e atualiza tabela pedido
        $this->status($retorno['status'], $retorno, 'eRede');

        // Return
        return $retorno;
    }

    /**
	 * Consulta código da transação
	 *
	 * Sempre que precisar, você pode consultar dados de uma transação específica utilizando seu código identificador
	 *
	 */
    public function consultarTransacao($transactionCode) {
    	if(!empty($transactionCode)) {

    		try {
    			$transaction = new \Rede\eRede($this->store);
                $transaction->get('TID123');

                printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());

			}catch (Exception $e) {
				// Erro
				$retorno = array(
    				'status'  => "erro",
    				'retorno' => $e->getMessage()
    			);
			}
    	}else{
    		// Erro
    		$retorno = array(
    			'status'  => "erro",
    			'retorno' => "Código de transação é obrigatório"
    		);
    	}

    	// Retorna json
		return json_encode($retorno);
    }

    /**
	 * Solicitar cancelamento de transação
	 *
	 * Sempre que precisar você pode solicitar o cancelamento de uma transação que ainda esteja sendo processada
	 *
	 */
    public function cancelarTransacao($transactionCode) {

    	if(!empty($transactionCode)) {
    		try{
    			// Transação que será cancelada
                $transaction = new \Rede\eRede($this->store);
                $tr_cancel   = new \Rede\Transaction(20.99);
                $transaction->cancel($tr_cancel->setTid('TID123'));

                if ($transaction->getReturnCode() == '359') {
                    printf("Transação cancelada com sucesso; tid=%s\n", $transaction->getTid());
                }

			}catch (Exception $e) {
				// Erro
				$retorno = array(
    				'status' => "erro",
    				'retorno' => $e->getMessage()
    			);
			}
    	}else{
    		// Erro
    		$retorno = array(
    			'status' => "erro",
    			'retorno' => "Código da transação é obrigatório"
    		);
    	}

    	// Retorna json
		return json_encode($retorno);
    }

    /**
	 * Consulta cancelamento da transação
	 *
	 * Sempre que precisar, você pode consultar dados de uma transação específica utilizando seu código identificador
	 *
	 */
    public function consultarCancelamentoTransacao($transactionCode) {
    	if(!empty($transactionCode)) {

    		try {
    			$transaction = new \Rede\eRede($this->store);
    			$transaction->getRefunds('TID123');

                printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());

			}catch (Exception $e) {
				// Erro
				$retorno = array(
    				'status'  => "erro",
    				'retorno' => $e->getMessage()
    			);
			}
    	}else{
    		// Erro
    		$retorno = array(
    			'status'  => "erro",
    			'retorno' => "Código de transação é obrigatório"
    		);
    	}

    	// Retorna json
		return json_encode($retorno);
    }

    /**
     *  Salvar Dados do Cartão no ID do Cliente
     *
     *  @access public
     *  @name saveCardClient
     *  @param array $parametros ($_POST form novo cartão)
     */
    public function saveCardClient($parametros = null) {
        // Inicia resposta
        $retorno = array();

        // Seta a sessão de usuário
        $session_cliente = new Zend_Session_Namespace("cliente");

        if(!$session_cliente->dados->idcliente > 0) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Você não está logado corretamente.";
            return $retorno;
        }

        // Somente número do cartão
        $somenteNumCartao = preg_replace('/[^0-9]/', '', $parametros['numero_cartao']);

        // Permitido acima de 15 numeros
        if( strlen($somenteNumCartao) <= 14 ) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Deve conter no mínimo 15 números.";
            return $retorno;
        }

        // Bandeira
        $brand_card = $this->card_brand($somenteNumCartao);

        // Número cartão
        $inicioCartao   = substr($somenteNumCartao, 0, 6);
        $finalCartao    = substr($somenteNumCartao, -4);
        $cartaoNum      = $inicioCartao.'******'.$finalCartao;

        // Validade cartão
        $vencimento_arr = explode("/", $parametros['vencimento']);
        if(count($vencimento_arr) > 0) {
            $mesCartao = $vencimento_arr[0];
            $anoCartao = '20' . $vencimento_arr[1];
        }

        // Verifica se já existe o cartao
        $cartaoRow = (new Admin_Model_Clientescartoes())->fetchRow(array(
            "idcliente = ?" => $session_cliente->dados->idcliente,
            "numero_cartao = ?" => $cartaoNum,
            "validade_mes = ?" => $mesCartao,
            "validade_ano = ?" => $anoCartao,
            "deletado_em IS NULL"
        ));

        if($cartaoRow) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Cartão já existente em sua conta.";
        }else{
            // Validar no gateway o cartão (gerar token)

//            // Crie uma instância do objeto que irá retornar o token do cartão
//            $card = new \Cielo\API30\Ecommerce\CreditCard();
//            $card->setCustomerName($session_cliente->dados->nome_completo);
//            $card->setCardNumber($somenteNumCartao);
//            $card->setHolder($parametros['nome_impresso']);
//            $card->setExpirationDate($mesCartao.'/'.$anoCartao);
//            $card->setBrand($this->varBrand($brand_card));

            try {
                // Configure o SDK com seu merchant e o ambiente apropriado para recuperar o cartão
                //$card = (new \Cielo\API30\Ecommerce\CieloEcommerce($this->merchant, $this->environment))->tokenizeCard($card);
                $card = "";

                // Get the token
                //$cardToken = $card->getCardToken();
                $cardToken = "xxxxdcba-e30b-4775-9c3c-e1c01432790a";

                if(!empty($cardToken)) {
                    // SUCESSO na cielo
                    $retorno['status']  = "sucesso";
                    $retorno['retorno'] = $card;
                }else{
                    // ERRO
                    $retorno['status']  = "erro";
                    $retorno['retorno'] = $card;
                }
            } catch (CieloRequestException $e) {
                // ERRO: Em caso de erros de integração, podemos tratar o erro aqui.
                // os códigos de erro estão todos disponíveis no manual de integração.
                $retorno['status']  = "erro";
                $retorno['retorno'] = $e->getCieloError();
            }

            if($retorno['status'] == 'sucesso') {
                // Cadastrar novo cartão no banco de dados

                // Array dados
                $data_insert = array(
                    'idcliente'     => $session_cliente->dados->idcliente,
                    'token'         => $cardToken,
                    'nome'          => $parametros['nome_impresso'],
                    'validade_mes'  => $mesCartao,
                    'validade_ano'  => $anoCartao,
                    'validade'      => $parametros['vencimento'],
                    'numero_cartao' => $cartaoNum,
                    'final_cartao'  => $finalCartao,
                    'cpf_titular'   => $parametros['cpf_titular'],
                    'marca'         => strtolower($brand_card),
                    'cadastrado_em' => date("Y-m-d H:i:s"),
                    'principal'     => 1,
                    'validado'      => 1,
                    'retorno'       => json_encode($retorno)
                );

                // Remove flag de cartão principal
                (new Admin_Model_Clientescartoes())->update(array('principal' => 0), array('idcliente = ?' => $session_cliente->dados->idcliente));

                // Insere cartão
                $novo_idcartao = (new Admin_Model_Clientescartoes())->insert($data_insert);

                $retorno['dados'] = array(
                    'idcartao'        => $novo_idcartao,
                    'card_token'      => $cardToken,
                    'bandeira_url'    => 'common/default/images/cards/'.strtolower($brand_card).'.png',
                    'cartao_bandeira' => $brand_card,
                    'numeros_cartao'  => $finalCartao
                );
            }else{
                // ERRO
                $retorno['status']   = "erro";
                $retorno['titulo']   = "Cartão não validado. Tente novamente.";
                $retorno['mensagem'] = "";
                $retorno['retorno']  = $retorno['retorno'];
            }
        }

        // Return
        return $retorno;
    }

    /**
     * Busca qual a bandeira do número de cartão informado
     *
     * @param $card
     *
     * @return string|null
     */
    function card_brand($card) {
        $brands = array(
            'visa'       => '/^4[0-9]\d+$/',
            'mastercard' => '/^((5(([1-2]|[4-5])[0-9]{8}|0((1|6)([0-9]{7}))|3(0(4((0|[2-9])[0-9]{5})|([0-3]|[5-9])[0-9]{6})|[1-9][0-9]{7})))|((508116)\d{4,10})|((502121)\d{4,10})|((589916)\d{4,10})|(2[0-9]{15})|(67[0-9]{14})|(506387)\d{4,10})/',
            'diners'     => '/^(?:5[45]|36|30[0-5]|3095|3[8-9])\d+$/',
            'discover'   => '/^6(?:011|22(12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])|5|4|2[4-6][0-9]{3}|28[2-8][0-9]{2})\d+$/',
            'elo'        => '/^4011(78|79)|^43(1274|8935)|^45(1416|7393|763(1|2))|^504175|^627780|^63(6297|6368|6369)|(65003[5-9]|65004[0-9]|65005[01])|(65040[5-9]|6504[1-3][0-9])|(65048[5-9]|65049[0-9]|6505[0-2][0-9]|65053[0-8])|(65054[1-9]|6505[5-8][0-9]|65059[0-8])|(65070[0-9]|65071[0-8])|(65072[0-7])|(65090[1-9]|6509[1-6][0-9]|65097[0-8])|(65165[2-9]|6516[67][0-9])|(65500[0-9]|65501[0-9])|(65502[1-9]|6550[34][0-9]|65505[0-8])|^(506699|5067[0-6][0-9]|50677[0-8])|^(509[0-8][0-9]{2}|5099[0-8][0-9]|50999[0-9])|^65003[1-3]|^(65003[5-9]|65004\d|65005[0-1])|^(65040[5-9]|6504[1-3]\d)|^(65048[5-9]|65049\d|6505[0-2]\d|65053[0-8])|^(65054[1-9]|6505[5-8]\d|65059[0-8])|^(65070\d|65071[0-8])|^65072[0-7]|^(65090[1-9]|65091\d|650920)|^(65165[2-9]|6516[6-7]\d)|^(65500\d|65501\d)|^(65502[1-9]|6550[3-4]\d|65505[0-8])$/',
            'amex'       => '/^3[47][0-9]{13}$/',
            'jcb'        => '/^(?:35[2-8][0-9])\d+$/',
            'aura'       => '/^((?!504175))^((?!5067))(^50[0-9])/',
            'hipercard'  => '/^606282|^3841(?:[0|4|6]{1})0/',
            'maestro'    => '/^(?:50|5[6-9]|6[0-9])\d+$/',
        );

        foreach( $brands as $brand => $regex ) {
            if( preg_match($regex, $card) ) {
                return $brand;
            }
        }

        return null;
    }

    /**
	 * Converter dados retornados do Pagseguro e armazenados no campo 'dados' da tabela 'pedidos_status'
 	 *
	 * Recebe o idpedido e o objeto
	 * Retorna um array já convertido
	 *
	 */
    public function convertserialize($idpedido = 0, $objetodados) {
    	$arr = (array)$objetodados;

    	if(count($arr) > 1) {
			unset($arr['__PHP_Incomplete_Class_Name']);

			foreach($arr as $key => $item) {
				$chave = str_replace("PagSeguroTransaction","",strip_tags($key));

				if($chave == 'type' || $chave == 'status' || $chave == 'paymentMethod' || $chave == 'items' || $chave == 'sender' || $chave == 'shipping') {
					$objectitens = (array)$item;
					unset($objectitens['__PHP_Incomplete_Class_Name']);

					foreach($objectitens as $w => $objectitem) {
						$subitem = array();
						$w = str_replace("PagSeguroTransactionType","",strip_tags($w));
						$w = str_replace("PagSeguroTransactionStatus","",strip_tags($w));

						if($chave != 'paymentMethod' && $chave != 'items' && $chave != 'sender' && $chave != 'shipping') {
							if(!empty($w)) {
								if($chave == 'type') {
									$subitens = $objectitem;
								}else{
									$subitens[$w] = $objectitem;
								}
							}

							// Armazena no array
							$dadostatus[$idpedido][$chave] = $subitens;
						}else{
							if($chave == 'paymentMethod') {
								// Array metodo de pagamento da compra
								$objectmetodos = (array)$objectitem;
								unset($objectmetodos['__PHP_Incomplete_Class_Name']);

								foreach($objectmetodos as $o => $metodo) {
									$o = str_replace("PagSeguroPaymentMethod","",strip_tags($o));

									// Armazena no array
									$dadostatus[$idpedido][$chave][$o] = $metodo;
								}
							}

							if($chave == 'items') {
								// Array subitens da compra
								$objectsubitens = (array)$objectitem;
								unset($objectsubitens['__PHP_Incomplete_Class_Name']);

								foreach($objectsubitens as $y => $sub) {
									$y = str_replace("PagSeguroItem","",strip_tags($y));

									$itemsubitens[$y] = $sub;
								}

								// Armazena no array
								$dadostatus[$idpedido][$chave][$w] = $itemsubitens;
							}

							if($chave == 'sender') {
								$w = str_replace("PagSeguroSender","",strip_tags($w));

								if($w == 'phone') {
									$objectsenders = (array)$objectitem;
									unset($objectsenders['__PHP_Incomplete_Class_Name']);

									foreach($objectsenders as $h => $phone) {
										$h = str_replace("PagSeguroPhone","",strip_tags($h));

										// Armazena no array
										$dadostatus[$idpedido][$chave][$h] = $phone;
									}
								}else{
									// Armazena no array
									$dadostatus[$idpedido][$chave][$w] = $objectitem;
								}
							}

							if($chave == 'shipping') {
								$w = str_replace("PagSeguroShipping","",strip_tags($w));

								if($w == 'address') {
									$objectaddress = (array)$objectitem;
									unset($objectaddress['__PHP_Incomplete_Class_Name']);

									foreach($objectaddress as $m => $address) {
										$m = str_replace("PagSeguroAddress","",strip_tags($m));

										// Armazena no array
										$dadostatus[$idpedido][$chave][$m] = $address;
									}
								}

								if($w == 'type') {
									$objecttype = (array)$objectitem;
									unset($objecttype['__PHP_Incomplete_Class_Name']);

									foreach($objecttype as $n => $type) {
										$n = str_replace("PagSeguroShipping","",strip_tags($n));

										// Armazena no array
										$dadostatus[$idpedido][$chave][$n] = $type;
									}
								}

								if($w == 'cost') {
									// Armazena no array
									$dadostatus[$idpedido][$chave][$w] = $objectitem;
								}
							}
						}
					}
				}else{
					// Armazena no array
					$dadostatus[$idpedido][$chave] = $item;
				}
			}
		}else{
			$dadostatus = false;
		}

		return $dadostatus;
    }

    /*
     * Envio de teste
     */
    private function testeTransaction() {
        // Teste eRede

        $transaction = new \Rede\Transaction(20.99, 'pedido' . time());
        $transaction->creditCard(
            '4235647728025682',
            '123',
            '01',
            '2021',
            'John Snow Show'
        );

        // Tipo
        $transaction->setKind('credit');

        // Parcelamento (De 2 a 12, não enviar o parâmetro para a vista)
        $transaction->setInstallments(2);

        // Autoriza e captura a transação
        $transaction = new \Rede\eRede($this->store);
        $transaction->create($transaction);

        var_dump($transaction);

        if ($transaction->getReturnCode() == '00') {
            printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
        }

        die("<br><br>Teste e-Rede");
    }

//    returnCode: returnMessage
//    1	expirationYear: Invalid parameter size
//    2	expirationYear: Invalid parameter format
//    3	expirationYear: Required parameter missing
//    4	cavv: Invalid parameter size
//    5	cavv: Invalid parameter format
//    6	postalCode: Invalid parameter size
//    7	postalCode: Invalid parameter format
//    8	postalCode: Required parameter missing
//    9	complement: Invalid parameter size
//    10	complement: Invalid parameter format
//    11	departureTax: Invalid parameter format
//    12	documentNumber: Invalid parameter size
//    13	documentNumber: Invalid parameter format
//    14	documentNumber: Required parameter missing
//    15	securityCode: Invalid parameter size
//    16	securityCode: Invalid parameter format
//    17	distributorAffiliation: Invalid parameter size
//    18	distributorAffiliation: Invalid parameter format
//    19	xid: Invalid parameter size
//    20	eci: Invalid parameter format
//    21	xid: Required parameter for Visa card is missing
//    22	street: Required parameter missing
//    23	street: Invalid parameter format
//    24	affiliation: Invalid parameter size
//    25	affiliation: Invalid parameter format
//    26	affiliation: Required parameter missing
//    27	Parameter cavv or eci missing
//    28	code: Invalid parameter size
//    29	code: Invalid parameter format
//    30	code: Required parameter missing
//    31	softdescriptor: Invalid parameter size
//    32	softdescriptor: Invalid parameter format
//    33	expirationMonth: Invalid parameter format
//    34	code: Invalid parameter format
//    35	expirationMonth: Required parameter missing
//    36	cardNumber: Invalid parameter size
//    37	cardNumber: Invalid parameter format
//    38	cardNumber: Required parameter missing
//    39	reference: Invalid parameter size
//    40	reference: Invalid parameter format
//    41	reference: Required parameter missing
//    42	reference: Order number already exists
//    43	number: Invalid parameter size
//    44	number: Invalid parameter format
//    45	number: Required parameter missing
//    46	installments: Not correspond to authorization transaction
//    47	origin: Invalid parameter format
//    49	The value of the transaction exceeds the authorized
//    50	installments: Invalid parameter format
//    51	Product or service disabled for this merchant. Contact Rede
//    53	Transaction not allowed for the issuer. Contact Rede.
//    54	installments: Parameter not allowed for this transaction
//    55	cardHolderName: Invalid parameter size
//    56	Error in reported data. Try again.
//    57	affiliation: Invalid merchant
//    58	Unauthorized. Contact issuer.
//    59	cardHolderName: Invalid parameter format
//    60	street: Invalid parameter size
//    61	subscription: Invalid parameter format
//    63	softdescriptor: Not enabled for this merchant
//    64	Transaction not processed. Try again
//    65	token: Invalid token
//    66	departureTax: Invalid parameter size
//    67	departureTax: Invalid parameter format
//    68	departureTax: Required parameter missing
//    69	Transaction not allowed for this product or service.
//    70	amount: Invalid parameter size
//    71	amount: Invalid parameter format
//    72	Contact issuer.
//    73	amount: Required parameter missing
//    74	Communication failure. Try again
//    75	departureTax: Parameter should not be sent for this type of transaction
//    76	kind: Invalid parameter format
//    78	Transaction does not exist
//    79	Expired card. Transaction cannot be resubmitted. Contact issuer.
//    80	Unauthorized. Contact issuer. (Insufficient funds)
//    82	Unauthorized transaction for debit card.
//    83	Unauthorized. Contact issuer.
//    84	Unauthorized. Transaction cannot be resubmitted. Contact issuer.
//    85	complement: Invalid parameter size
//    86	Expired card
//    87	At least one of the following fields must be filled: tid or reference
//    88	Merchant not approved. Regulate your website and contact the Rede to return to transact.
//    89	token: Invalid token
//    97	tid: Invalid parameter size
//    98	tid: Invalid parameter format
//    132	DirectoryServerTransactionId: Invalid parameter size.
//    133	ThreedIndicator: Invalid parameter value.
//    150	Timeout. Try again
//    151	installments: Greater than allowed
//    153	documentNumber: Invalid number
//    154	embedded: Invalid parameter format
//    155	eci: Required parameter missing
//    156	eci: Invalid parameter size
//    157	cavv: Required parameter missing
//    158	capture: Type not allowed for this transaction
//    159	userAgent: Invalid parameter size
//    160	urls: Required parameter missing (kind)
//    161	urls: Invalid parameter format
//    167	Invalid request JSON
//    169	Invalid Content-Type
//    171	Operation not allowed for this transaction
//    173	Authorization expired
//    176	urls: Required parameter missing (url)
//    899	Unsuccessful. Please contact Rede.
//    1018	MCC Invalid Size.
//    1019	MCC Parameter Required.
//    1020	MCC Invalid Format.
//    1021	PaymentFacilitatorID Invalid Size.
//    1023	PaymentFacilitatorID Invalid Format.
//    1030	CitySubMerchant Invalid Size.
//    1034	CountrySubMerchant Invalid Size.

}
