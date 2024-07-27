<?php
/**
 * Classe de pagamentos por pagSeguro
 *
 * @name gazetamarista_Pagamentos_Pagseguro
 */
class gazetamarista_Pagamentos_Pagseguro extends gazetamarista_Pagamentos_Abstract {

	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "pagseguro";

	private $credentials;
	private $_application_config;
	private $_modules;
	private $cliente;
    private $session_config;

	/**
	 * Inicializa a classe de pagamento
	 *
	 * @name init
	 */
	public function init() {
		//session_start();

		// Sessão de configuração
		$this->session_config = new Zend_Session_Namespace("configuracao");

		// Armazena as configurações globais
		$this->_application_config = Zend_Registry::get("config");
		$this->_modules = Zend_Registry::get("modulos");

		// Função de bloquear injection
		$this->sanitize         = new gazetamarista_Sanitize();

		// Verifica configuração pagSeguro
//    	if($this->session_config->dados['pagseguro_ativo'] == '1') {
//    		// Pagseguro ativo
//    	}else{
//    		die("Sistema inativo, verifique configuração do Pagseguro");
//    	}


        // Chama a biblioteca do PagSeguro
        require_once(APPLICATION_PATH."/../library/gazetamarista/Library/PagSeguroLibrary/vendor/autoload.php");
        // Inicializa Biblioteca
        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("CW Panel")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("CW Panel")->setRelease("1.0.0");

        // Define qual Ambiente utilizar
        if($this->session_config->dados->pagto_ambiente == 'sandbox'){
            \PagSeguro\Configuration\Configure::setEnvironment('sandbox');
            \PagSeguro\Configuration\Configure::setAccountCredentials( $this->session_config->dados->pagto_sandbox_email, $this->session_config->dados->pagto_sandbox_token);
        }else{
            \PagSeguro\Configuration\Configure::setEnvironment('production');
            \PagSeguro\Configuration\Configure::setAccountCredentials( $this->session_config->dados->pagto_production_email, $this->session_config->dados->pagto_production_token);
        }

        // Credencial pagSeguro
        $this->credentials =\PagSeguro\Configuration\Configure::getAccountCredentials();

		$this->_login       = new Zend_Session_Namespace("loginadmin");

        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $this->dominio = "http://localhost" . $config->gazetamarista->config->basepath;
        } elseif ($_SERVER['HTTP_HOST'] == "sites.gazetamarista.com.br") {
            $this->dominio = "http://sites.gazetamarista.com.br" . $config->gazetamarista->config->basepath;
        } else {
            $this->dominio = "http://" . $config->gazetamarista->config->domain;
        }

	}


	/**
	 *
	 * Envia Requisição para criar a transação
	 *
	 * O retorno do método register, por padrão, será um objeto com a resposta da requisição
	 *
	 */
	public function enviarAssinatura($tipopagamento, $parametros = '') {

		// Adiciona o model
		$model_animais = new Admin_Model_Clubeanimais();
		$model_clientes_enderecos = new Admin_Model_Clientesenderecos();
		$model_planos			= new Admin_Model_Planos();
		$model_clubeassinaturas	= new Admin_Model_Clubeassinaturas();

		//Session
		$planosession  = new Zend_Session_Namespace("plano");
		$UsuarioSession  = new Zend_Session_Namespace("usuario");
		$EntregaSession  = new Zend_Session_Namespace("entrega");
		$animais = new Zend_Session_Namespace("animais");


		// Credencial pagSeguro
		$credentials = PagSeguroConfig::getAccountCredentials();

		//Confirma Dados do Plano no Banco
		$select_plano = $model_planos->select()->where("idplano = ?", $planosession->idplano)->limit(1);
		$DadosPlano = $model_planos->fetchRow($select_plano);


		//Confirma Dados de cobrança
		$select_endereco = $model_clientes_enderecos->select()->where("idcliente = ?", $planosession->usuario->idcliente)->where("tipo = ?", "Cobrança")->order("idcliente_endereco DESC")->limit(1);
		$DadosCobranca = $model_clientes_enderecos->fetchRow($select_endereco);


		if(!empty($tipopagamento)) {
			// Tipo de pagamento cartão de crédito
			if($tipopagamento == 'credit_card') {
				// Padrões
				$idpedido			= $planosession->idplano;
				$sender_hash		= $parametros['sender_hash'];
				$tipodocumento 		= $parametros['tipodocumento'];
				$documento			= $parametros['documento'];
				$valor_final 		= str_replace(",",".", $parametros['valor_total']);
				$valor_total		= number_format((float)$valor_final, 2, '.', '');

				// Parâmetros cartão de crédito
				$cc_name 			= $parametros['cc-name'];
				$cc_number 			= $parametros['cc-number'];
				$cc_exp 			= $parametros['cc-exp'];
				$cc_cvc 			= $parametros['cc-cvc'];
				$card_token			= $parametros['card_token'];
				$sender_hash		= $parametros['sender_hash'];
				$final_cartao 		= substr(trim($cc_number),-4);
				$imagem_icon 		= $parametros['imgicon'];
				$bandeira 			= ucfirst($parametros['bandeira']);
				$metodo_pagamento	= 'Cartão '.$bandeira;


				if(!empty($sender_hash)) {
					$parse_telefone	= explode(' ', $this->_pedido->celular_pagamento);
					if(count($parse_telefone) > 0) {
						$ddd_pagamento		= str_replace(")", "", str_replace("(", "", $parse_telefone[0]));
						$telefone_pagamento	= str_replace("-", "", $parse_telefone[1]);
					}else{
						$ddd_pagamento		= "";
						$telefone_pagamento	= $this->_pedido->celular_pagamento;
					}

					$quantidade  			= "1";
					$Referencia 			= "ASS".round(microtime(true) * 1000);

					// Dados do pagamento
					$nome_pagamento 		= $planosession->usuario->nome;
					$nascimento_pagamento 	= $planosession->usuario->data;
					$sexo_pagamento 		= $planosession->usuario->sexo;
					$email_pagamento 		= $planosession->usuario->email;
					$cpf_pagamento 			= str_replace(array('.', '-'),"",$planosession->usuario->cpf);
					$telefone_pagamento 	= explode (')', $planosession->usuario->telefone);
					$telefone_ddd 			= str_replace("(","",$telefone_pagamento[0]);
					$telefone_pagamento 	= str_replace("-","",$telefone_pagamento[1]);
					$celular_pagamento 		= explode (')', $planosession->usuario->celular);
					$celular_ddd 			= str_replace("(","",$celular_pagamento[1]);
					$celular_pagamento 		= str_replace("-","",$celular_pagamento[1]);
					if(!$DadosCobranca){
						$endereco_pagamento 	= $planosession->entrega->endereco;
						$numero_pagamento 		= $planosession->entrega->numero;
						$complemento_pagamento 	= $planosession->entrega->complemento;
						$bairro_pagamento 		= $planosession->entrega->bairro;
						$cep_pagamento 			= $planosession->entrega->cep;
						$cidade_pagamento 		= $planosession->entrega->cidade;
						$estado_pagamento 		= strtoupper($planosession->entrega->estado);
					}else{
						$endereco_pagamento 	= $DadosCobranca->endereco;
						$numero_pagamento 		= $DadosCobranca->numero;
						$complemento_pagamento 	= $DadosCobranca->complemento;
						$bairro_pagamento 		= $DadosCobranca->bairro;
						$cep_pagamento 			= $DadosCobranca->cep;
						$cidade_pagamento 		= $DadosCobranca->cidade;
						$estado_pagamento 		= strtoupper($DadosCobranca->estado);
					}

					$destinatario_entrega 	= $planosession->usuario->nome;
					$cep_entrega 			= $planosession->entrega->cep;
					$endereco_entrega	 	= $planosession->entrega->endereco;
					$numero_entrega 		= $planosession->entrega->numero;
					$complemento_entrega	= $planosession->entrega->complemento;
					$bairro_entrega 		= $planosession->entrega->bairro;
					$cidade_entrega 		= $planosession->entrega->cidade;
					$estado_entrega 		= $planosession->entrega->estado;




					//Dados Animal Principal
					$DataAnimalPrincipal['tipo_pet'] 				= $animais->principal->tipo_pet;
					$DataAnimalPrincipal['nome_pet'] 				= $animais->principal->nome_pet;
					$DataAnimalPrincipal['sexo_pet'] 				= $animais->principal->sexo_pet;
					$DataAnimalPrincipal['aniversario_pet'] 		=  implode("-", array_reverse(explode("/", $animais->principal->aniversario_pet)));
					$DataAnimalPrincipal['raca_pet'] 				= $animais->principal->raca_pet;
					$DataAnimalPrincipal['problema_pele'] 			= $animais->principal->problema_pele;
					$DataAnimalPrincipal['obesidade'] 				= $animais->principal->obesidade;
					$DataAnimalPrincipal['preferencia_petisco']   	= $animais->principal->preferencia_petisco;
					$DataAnimalPrincipal['preferencia_brinquedo'] 	= $animais->principal->preferencia_brinquedo;
					$DataAnimalPrincipal['preferencia_higiene'] 	= $animais->principal->preferencia_higiene;

					//Dados Animal Adicional
					if ($animais->adicional) {
						$DataAnimalAdicional['tipo_pet'] 				= $animais->adicional->tipo_pet;
						$DataAnimalAdicional['nome_pet'] 				= $animais->adicional->nome_pet;
						$DataAnimalAdicional['sexo_pet'] 				= $animais->adicional->sexo_pet;
						$DataAnimalAdicional['aniversario_pet'] 		= implode("-", array_reverse(explode("/", $animais->adicional->aniversario_pet)));
						$DataAnimalAdicional['raca_pet'] 				= $animais->adicional->raca_pet;
						$DataAnimalAdicional['problema_pele'] 			= $animais->adicional->problema_pele;
						$DataAnimalAdicional['obesidade'] 				= $animais->adicional->obesidade;
						$DataAnimalAdicional['preferencia_petisco']   	= $animais->adicional->preferencia_petisco;
						$DataAnimalAdicional['preferencia_brinquedo'] 	= $animais->adicional->preferencia_brinquedo;
						$DataAnimalAdicional['preferencia_higiene'] 	= $animais->adicional->preferencia_higiene;
					}


					if( getenv('APPLICATION_ENV') != "production") {
						// *********************************************************************************
						// ** Ambiente de teste Pagseguro, e-mail deve ser @sandbox.pagseguro.com.br *******
						$email_pagamento = "c09564454053279162710@sandbox.pagseguro.com.br";
						// *********************************************************************************
					}

					//Dados para Salvar no Banco
					$DataClube['idcliente'] 			= $planosession->usuario->idcliente;
					$DataClube['idplano'] 				= $planosession->idplano;
					$DataClube['tituloplano'] 			= $planosession->nome_plano;
						//Dados Pagamento
						$DataClube['valorpago'] 			= $valor_total;
						$DataClube['data_contratacao'] 		= date("Y-m-d H:i:s");
						$DataClube['status'] 				= 'Pendente';
						$DataClube['cliente_session_id']	= PagSeguroSessionService::getSession($credentials);;
						$DataClube['endereco_ip']			= $_SERVER['REMOTE_ADDR'];
						$DataClube['ref_assinatura']		= $Referencia;
						//Dados Usuario
						$DataClube['nome_pagamento'] 		= $nome_pagamento;
						$DataClube['nascimento_pagamento'] 	= $nascimento_pagamento;
						$DataClube['documento_pagamento'] 	= $cpf_pagamento;
						$DataClube['email_pagamento']		= $email_pagamento;
						$DataClube['telefone_pagamento'] 	= $planosession->usuario->telefone;
						$DataClube['celular_pagamento'] 	= $planosession->usuario->celular;
						$DataClube['endereco_pagamento'] 	= $endereco_pagamento;
						$DataClube['numero_pagamento'] 		= $numero_pagamento;
						$DataClube['cep_pagamento'] 		= $cep_pagamento;
						$DataClube['bairro_pagamento'] 		= $bairro_pagamento;
						$DataClube['cidade_pagamento'] 		= $cidade_pagamento;
						$DataClube['estado_pagamento'] 		= $estado_pagamento;
						$DataClube['destinatario_entrega'] 	= $destinatario_entrega;
						$DataClube['cep_entrega'] 			= $cep_entrega;
						$DataClube['endereco_entrega'] 		= $endereco_entrega;
						$DataClube['numero_entrega']		= $numero_entrega;
						$DataClube['complemento_entrega'] 	= $complemento_entrega;
						$DataClube['bairro_entrega'] 		= $bairro_entrega;
						$DataClube['cidade_entrega'] 		= $cidade_entrega;
						$DataClube['estado_entrega'] 		= $estado_entrega;


						//Dados Plano
						$DataClube['porte_animal'] 			= $planosession->porte;
						$DataClube['itens_extra'] 			= $planosession->upgrade->itensextras;
						$DataClube['animal_extra'] 			= $planosession->upgrade->maisanimais;
						$DataClube['frete']					= $planosession->frete_total;


					/**
					 *
					 * VERIFICA SE EXISTE UM PLANO DE ASSINATURA
					 *
					 * Caso não exista cria um plano de assinaturas.
					 * Só então é possivel criar uma assinatura.
					 *
					 */
						// Instacia o objeto de pagamento
						$preApprovalRequest = new PagSeguroPreApprovalRequest();

						// Definindo a moeda a ser utilizada no pagamento
						$preApprovalRequest->setCurrency("BRL");

						// Referenciando a transação do PagSeguro em seu sistema
						$preApprovalRequest->setReference($Referencia);

						// Informando os dados do cartão
						$creditCardToken = $card_token;

						//Frequência de Cobrança do Plano
						if($planosession->nome_plano == 'plano-mensal'){
							$frequencia = "Monthly";
						}else if($planosession->nome_plano == "plano-trimestral"){
							$frequencia = "Trimonthly";
						}else{
							$frequencia = "Semiannually";
						}

						$preApprovalRequest->setPreApprovalCharge('auto');
						$preApprovalRequest->setPreApprovalName($DadosPlano['plano']." - Clube de Assinatura - Tribo Pets ");
						$preApprovalRequest->setPreApprovalDetails("Clube de assinaturas.");
						$preApprovalRequest->setPreApprovalAmountPerPayment($valor_total);
						$preApprovalRequest->setPreApprovalPeriod($frequencia);

						try {
							// Requisição ao pagSeguro
							$credentials = new PagSeguroAccountCredentials("henrique.carlos@gazetamarista.com.br", "F81578D92BC947F2B6EBB19F95EF8EA8");
							//$response = $preApprovalRequest->register($this->credentials);
							$response = $preApprovalRequest->register($credentials);
							$serialize_response = serialize($response);

							if ($response == 'Unauthorized') {
								// Erro
								$retorno = array(
									'status' => "erro",
									'retorno' => $serialize_response
								);
							}else{
								$preApprovalCode = $response['code'];

								// Insere as informações no banco
								$code['code_plano'] = $preApprovalCode;
								$teste = $model_planos->update($code, array('idplano = ?' => $planosession->idplano));

							}
						} catch (PagSeguroServiceException $e) {
							// Erro
							$retorno = array(
								'status' => "erro",
								'retorno' => $e->getMessage() . " teste"
							);
						}


					// Se existe o codigo do plano de assinatura
					if($preApprovalCode != ''){

						// Dados necessários para vincular/assinar o cliente e seu cartão de crédito ao plano/assinatura de pagamento recorrente
						$postvals = (object) array(
							'plan' => $preApprovalCode,
							'reference' => $Referencia,
							'sender' => (object) array(
								'name' => $nome_pagamento,
								'email' => $email_pagamento,
								'ip' => $ip,
								'hash' => $sender_hash,
								'phone' => (object) array(
									'areaCode' => intval($telefone_ddd),
									'number' => intval($telefone_pagamento)
								),
								'address' => (object) array(
									'street' => $endereco_pagamento,
									'number' => $numero_pagamento,
									'complement' => $complemento_pagamento,
									'district' => $bairro_pagamento,
									'city' => $cidade_pagamento,
									'state' => $estado_pagamento,
									'country' => 'BRA',
									'postalCode' => $cep_pagamento
								),
								'documents' => array(
									(object) array(
										'type' => 'CPF',
										'value' => $cpf_pagamento
									)
								)
							),
							'paymentMethod' => (object) array(
								'type' => "CREDITCARD",
								'creditCard' => (object) array(
									'token' => $card_token,
									'holder' => (object) array(
										'name' => $nome_pagamento,
										'birthDate' => $nascimento_pagamento,
										'documents' => array(
											(object) array(
												'type' => 'CPF',
												'value' => $cpf_pagamento
											)
										),
										'billingAddress' => (object) array(
											'street' => $endereco_pagamento,
											'number' => $numero_pagamento,
											'complement' => $complemento_pagamento,
											'district' => $bairro_pagamento,
											'city' => $cidade_pagamento,
											'state' => $estado_pagamento,
											'country' => 'BRA',
											'postalCode' => $cep_pagamento
										),
										'phone' => (object) array(
											'areaCode' => intval($telefone_ddd),
											'number' => intval($telefone_pagamento)
										)
									)
								)
							),
						);

						// Encode
						$postvals = json_encode($postvals);

						// Recupera a URL do webservice de adesão ao pagamento recorrente
						$connectionData = new PagSeguroConnectionData($this->credentials, 'preApproval');

						$url = $connectionData->getWebserviceUrl() . $connectionData->getResource('findUrl');
						$url = str_replace("v2/", "", $url);
						$url = "{$url}?" . $connectionData->getCredentialsUrlQuery();

						try {
							// Requisição ao pagSeguro
							$response = self::curl($url, 'POST', $postvals);
							$serialize_response = json_decode($response, true);


							if ($response == 'Unauthorized' || $serialize_response['error'] == 1) {
								// Erro
								$retorno = array(
									'status' => "erro",
									'retorno' => $serialize_response
								);
							} else {
								//Adiciona Clube de Assinaturas no Banco
								$DataClube['code_assinatura'] = $serialize_response['code'];
								$idClubeassinatura = $model_clubeassinaturas->insert($DataClube);

								// Adiciona Animal Principal no Banco
								$DataAnimalPrincipal['idclubeassinaturas'] = $idClubeassinatura;
								$model_animais->insert($DataAnimalPrincipal);

								//Dados Animal Adional no banco
								if ($animais->adicional) {
									$DataAnimalAdicional['idclubeassinaturas'] = $idClubeassinatura;
									$model_animais->insert($DataAnimalAdicional);
								}

								$retorno = array(
									'status' => "sucesso",
									'retorno' => $serialize_response
								);
							}
						} catch (PagSeguroServiceException $e) {
							// Erro
							$retorno = array(
								'status' => "erro",
								'retorno' => $e->getMessage() . " teste"
							);
						}
					}
				}else{
					// Erro
					$retorno = array(
						'status'  => "erro",
						'retorno' => "Sender Hash não enviado para transação"
					);
				}
			}
		}else{
			// Erro
			$retorno = array(
				'status'  => "erro",
				'retorno' => "Tipo de pagamento inválido, tente novamente o processo de pagamento"
			);
		}

		return $retorno;
	}










    /**
     *
     * Envia Requisição para criar a transação
     *
     * O retorno do método register, por padrão, será um objeto com a resposta da requisição
     *
     */
    public function enviarTransacao($IdPedido, $FormaPagamento, $Parametros){
        // Adiciona o model
        $model_clientes             = new Admin_Model_Clientes();
        $model_clientes_enderecos   = new Admin_Model_Clientesenderecos();
        $model_cupons               = new Admin_Model_Cupons();
        $model_pedidos              = new Admin_Model_Pedidos();
        $model_pedidos_produtos     = new Admin_Model_Pedidosprodutos();

        $this->_carrinho            = new Zend_Session_Namespace("carrinho");
        $this->_tracking_ecommerce  = new Zend_Session_Namespace("tracking_ecommerce");
        $this->_endereco     		= new Zend_Session_Namespace("select_endereco");
        $this->_metodo_frete		= new Zend_Session_Namespace("metodo_frete");

        // Verifica se foi enviado a Forma de Pagamento
        if (!empty($FormaPagamento)) {
            // Caso seja pagamento com cartão de crédito
            if ($FormaPagamento == 'credit_card') {

                // Parâmetros cartão de crédito
                $cc_name            = $Parametros['cc-name'];
                $cc_number          = $Parametros['cc-number'];
                $cc_exp_month       = $Parametros['cc-exp_month'];
                $cc_exp_year        = $Parametros['cc-exp_year'];
                $cc_cvc             = $Parametros['cc-cvc'];
                $parcelas           = $Parametros['parcelas'];
                $parcelas_sem_juros = intval($this->session_config->dados->pagto_parcelas_sem_juros);
                $sender_hash        = $Parametros['sender_hash'];
                $card_token         = $Parametros['card_token'];
                $final_cartao       = substr(trim($cc_number), -4);
                $imagem_icon        = $Parametros['imgicon'];
                $AniversarioCartao  = $Parametros['cc-holder-birthday'];
                $bandeira           = ucfirst($Parametros['bandeira']);
                $metodo_pagamento   = 'Cartão ' . $bandeira;
                $tipodocumento      = $Parametros['tipodocumento'];
                $telefone           = $Parametros['telefone'];
                $documento          = $Parametros['documento'];
                $Documento          = str_replace(array(".", "-", '/'), "", $documento);

                // Verificação se Possuí código de desconto
                if(!empty($this->_pedido->valor_desconto) && $this->_pedido->valor_desconto > 0){
                    // Pega o Cumpom de desconto
                    $codigocupom = $this->_pedido->cupom;

                    // Verifica se está ativo o cupom informado
                    $model_cupons = new Admin_Model_Cupons();
                    $select_cupom = $model_cupons->select()
                        ->where("cupom = ?", $codigocupom)
                        ->where("ativo = 1")
                        ->order("idcupom DESC");

                    // Fetch
                    $cupom = $model_cupons->fetchRow($select_cupom);

                    // Verifica o tipo do DESCONTO (Frete, Porcentagem ou Valor Fixo)
                    switch ($cupom->tipo) {
                        case 'frete':
                            $valor_desconto = $this->_pedido->valor_frete;
                            break;

                        default:
                            $valor_desconto = $valor_total * ($cupom->valor/100);
                    }
                }else{
                    $valor_desconto 		= 0;
                }


                // Confirma se o CARD TOKEN foi gerado e enviado corretamento
                if (!empty($card_token)) {
                    // Pega os dados do Telefone
                    $parse_telefone = explode(' ', $telefone);
                    if (count($parse_telefone) > 0) {
                        $ddd_pagamento = str_replace( array(")", "("), "", $parse_telefone[0]);
                        $telefone_pagamento = str_replace(array("-", "_"), "", $parse_telefone[1]);
                    } else {
                        $ddd_pagamento = "";
                        $telefone_pagamento = $this->_cliente->telefone;
                    }

                    if($this->_endereco->cobranca->idendereco){
                        //Busca os dados do Endereço de Cobrança
                        $DadosCobranca = $model_clientes_enderecos->select('*')->where("idcliente = ?", $this->_cliente->idcliente)->where("idcliente_endereco = ?", $this->_endereco->cobranca->idendereco);
                        $DadosCobranca = $model_clientes_enderecos->fetchRow($DadosCobranca);
                    }

                    if($this->_endereco->entrega->idendereco){
                        //Busca os dados do Endereço de Entrega
                        $DadosEntrega = $model_clientes_enderecos->select('*')->where("idcliente = ?", $this->_cliente->idcliente)->where("idcliente_endereco = ?", $this->_endereco->entrega->idendereco);
                        $DadosEntrega = $model_clientes_enderecos->fetchRow($DadosEntrega);
                    }


                    print_r($DadosEntrega);
                    die();


                    // Verifica se existe o pedido no BD deste cliente
                    if ($this->_tracking_ecommerce->idpedido > 0) {
                        // Seleciona os dados do pedido no bd
                        $pedido_bd = $model_pedidos->select('*')->where("idpedido = ?", $this->_tracking_ecommerce->idpedido);
                        $pedido_bd = $model_pedidos->fetchRow($pedido_bd);

                        if (count($pedido_bd) > 0) {
                            $existepedido = true;
                            $valor_total_final = $pedido_bd->valor_pedido;
                        } else {
                            $existepedido = false;
                        }
                    } else {
                        $existepedido = false;
                    }


                    // Caso exista o Pedido tudo certo, prossegue para o pagamento
                    if($existepedido){

                        $payment = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();

                        // Seleciona os dados do Cliente
                        $DadosCliente = $model_clientes->select('*')->where("idcliente = ?", $this->_cliente->idcliente);
                        $DadosCliente = $model_clientes->fetchRow($DadosCliente);

                        // Define dados básicos
                        $payment->setCurrency("BRL");
                        $payment->setReference($this->_tracking_ecommerce->idpedido);
                        $payment->setNotificationUrl($this->dominio . '/pagseguro_transacao');
                        $payment->setSender()->setName($DadosCliente->nome);
                        $payment->setSender()->setEmail($DadosCliente->email);

                        //Define o Valor do Desconto
                        //$payment->setExtraAmount(($valor_desconto));

                        $valorProdutos = 0;

                        // Adciona os Produtos no "Carrinho" do Pagseguro
                        $produtos_carrinho = $this->_carrinho->produtos;
                        $selectProdutos = $model_pedidos_produtos->select()->where("idpedido = ?", $this->_tracking_ecommerce->idpedido);
                        $Produtos = $model_pedidos_produtos->fetchAll($selectProdutos)->toArray();
                        foreach ($Produtos as $Produto) {
                            $valorProdutos += intval($Produto['quantidade'])*$Produto['preco_venda'];
                            $payment->addItems()->withParameters($Produto['idproduto'], $Produto['titulo'], intval($Produto['quantidade']), $Produto['preco_venda']);
                        }


                        if (getenv('APPLICATION_ENV') != "production") {
                            // *********************************************************************************
                            // ** Ambiente de teste Pagseguro, e-mail deve ser @sandbox.pagseguro.com.br *******
                            // *********************************************************************************
                            $payment->setSender()->setName("gazetamarista Digital");
                            $payment->setSender()->setEmail("c09564454053279162710@sandbox.pagseguro.com.br"); // Comprador Teste, disponível no painel do sandbox do pagseguro
                            // *********************************************************************************
                        }


                        // Define dados do TELEFONE
                        if ($DadosCliente->telefone) {
                            //Caso tenha mais de um telefone, Pega apenas o primeiro
                            if (strpos($DadosCliente->telefone, '/') !== false) {
                                $Telefones = explode("/", $DadosCliente->telefone);
                                $DDD = substr(str_replace(array('(', ')', '-', ' '), "", $Telefones[0]), 0, 2);
                                $Telefone = substr(str_replace(array('(', ')', '-', ' ', '_'), "", $Telefones[0]), 2);
                            } else {
                                $DDD = substr(str_replace(array('(', ')', '-', ' '), "", $DadosCliente->telefone), 0, 2);
                                $Telefone = substr(str_replace(array('(', ')', '-', ' ', '_'), "", $DadosCliente->telefone), 2);
                            }
                            $payment->setSender()->setPhone()->withParameters($DDD, $Telefone);
                        }else  if ($DadosCliente->celular) {
                            $DDD = substr(str_replace(array('(', ')', '-', ' '), "", $DadosCliente->celular), 0, 2);
                            $Telefone = substr(str_replace(array('(', ')', '-', ' '), "", $DadosCliente->celular), 2);

                            $payment->setSender()->setPhone()->withParameters($DDD, $Telefone);
                        }


                        $CPF = str_replace(array(".", "-", '/'), "", $DadosCliente->documento);
                        $payment->setSender()->setDocument()->withParameters('CPF', $CPF);
                        $payment->setSender()->setHash($sender_hash);
                        $payment->setSender()->setIp($this->_request->getServer('REMOTE_ADDR'));


                        // Define Dados do DONO DO CARTÃO
                        //$payment->setHolder()->setBirthdate($AniversarioCartao);
                        $payment->setHolder()->setName($cc_name); // Equals in Credit Card
                        $payment->setHolder()->setPhone()->withParameters($DDD, $Telefone);
                        $payment->setHolder()->setDocument()->withParameters('CPF', $Documento);


                        if ($DadosEntrega) {
                            $payment->setShipping()->setAddress()->withParameters(
                                $DadosEntrega->endereco,
                                $DadosEntrega->numero,
                                $DadosEntrega->bairro,
                                str_replace('-', "", $DadosEntrega->cep),
                                $DadosEntrega->cidade,
                                $DadosEntrega->estado,
                                'BRA',
                                $DadosEntrega->complemento
                            );
                        }else if ($DadosCobranca) {
                            $payment->setShipping()->setAddress()->withParameters(
                                $DadosCobranca->endereco,
                                $DadosCobranca->numero,
                                $DadosCobranca->bairro,
                                str_replace('-', "", $DadosCobranca->cep),
                                $DadosCobranca->cidade,
                                $DadosCobranca->estado,
                                'BRA',
                                $DadosCobranca->complemento
                            );
                        }else{
                            print_r(' Digite um endereço de cobrança');
                            die();
                        }

                        if ($DadosCobranca) {
                            $payment->setBilling()->setAddress()->withParameters(
                                $DadosCobranca->endereco,
                                $DadosCobranca->numero,
                                $DadosCobranca->bairro,
                                str_replace('-', "", $DadosCobranca->cep),
                                $DadosCobranca->cidade,
                                $DadosCobranca->estado,
                                'BRA',
                                $DadosCobranca->complemento
                            );
                        }else{
                            $payment->setBilling()->setAddress()->withParameters(
                                $DadosEntrega->endereco,
                                $DadosEntrega->numero,
                                $DadosEntrega->bairro,
                                str_replace('-', "", $DadosEntrega->cep),
                                $DadosEntrega->cidade,
                                $DadosEntrega->estado,
                                'BRA',
                                $DadosEntrega->complemento
                            );
                        }



                        // Set credit card token
                        $payment->setToken($card_token);
                        $payment->setSender()->setHash($sender_hash);

                        // Dados de FRETE
                        if ($this->_metodo_frete->metodo_frete['codigo'] == "41106") {
                            $payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::PAC);
                        } else if ($this->_metodo_frete->metodo_frete['codigo'] == "40010") {
                            $payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::SEDEX);
                        } else {
                            $payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::NOT_SPECIFIED);
                        }
                        $payment->setShipping()->setCost()->withParameters($this->_metodo_frete->metodo_frete['valor']);

                        $ValorTotal = ($valorProdutos + $this->_metodo_frete->metodo_frete['valor']) - $pedido_bd->valor_desconto ;

                        // Buscar Parcelas via PHP por segurança
                        if(intval($parcelas_sem_juros) >= 2){
                            // Só pode ser calculado caso seja mais de 2 parcelas (Seo cliente pagar em 1 vez ele não está parcelando, portanto 1 não é válido)
                            $Parcelas = $this->buscarParcelas(array('amount' => $ValorTotal, 'card_brand' => $Parametros['bandeira'] , 'max_installment_no_interest' => intval($parcelas_sem_juros)));
                        }else{
                            $Parcelas = $this->buscarParcelas(array('amount' => $ValorTotal, 'card_brand' => $Parametros['bandeira']));
                        }


                        foreach ( $Parcelas as $Parcela) {
                            if( intval($parcelas) == $Parcela->getQuantity()){
                                $ParcelasQtd    = $Parcela->getQuantity();
                                $ParcelasValor  = $Parcela->getAmount();
                                $ParcelasTotal  = $Parcela->getTotalAmount();
                            }
                        }

                        $payment->setInstallment()->withParameters(intval($ParcelasQtd), $ParcelasValor);


                        //$payment->setInstallment()->withParameters(1, '887.35');
                        $payment->setMode('DEFAULT');




                        try {
                            //Registra o Pagamento
                            $retorno = $payment->register(\PagSeguro\Configuration\Configure::getAccountCredentials());

                            /*
                            *    POSSÍVEIS STATUS DE RETORNO DO PAGSEGURO
                            *    1 = Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
                            *    2 = Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
                            *    3 = Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
                            *    4 = Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
                            *    5 = Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
                            *    6 = Devolvida: o valor da transação foi devolvido para o comprador.
                            *    7 = Cancelada: a transação foi cancelada sem ter sido finalizada.
                            *    8 = Debitado: o valor da transação foi devolvido para o comprador.
                            *    9 = Retenção temporária: o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
                            */

                            return $retorno;

                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    }
                }
            }
        }
    }




    /**
	 * Consulta código de notificação
	 *
	 * O PagSeguro pode enviar notificações ao seu sistema (POST) indicando a ocorrência de algum evento que requer sua atenção
	 *
	 */
    public function consultarNotificacao($notificationType, $notificationCode) {
    	// Caso seja uma notificação de Transação
		// Atenção Notificação de transação também estão relacionadas as Assinatura
		if(!empty($notificationCode) && $notificationType != "preApproval") {
    		try {
    			// Requisição ao pagSeguro
				$response = PagSeguroNotificationService::checkTransaction( $this->credentials, $notificationCode );
				$serialize_response = serialize($response);

				//Array com Dados da transação
				$transaction = array(
					'data_transacao' 	=> $response->getDate(),
					'data_ultimo_evento'=> $response->getLastEventDate(),
					'code_transacao'	=> $response->getCode(),
					'reference' 		=> $response->getReference(),
					'type '				=> $response->getType()->getValue(),
					'status' 			=> $response->getStatus()->getValue()
				);

				// Verifica se retornou corretamente
				if(!empty($transaction['reference'])) {
					// Caso seja assinatura (Prefixo ASS na Referencia) busca o ID no Banco
					if (strpos($transaction['reference'], 'ASS') !== false) {
						$model_assinatura = new Admin_Model_Clubeassinaturas();
						$fetch_status = $model_assinatura->fetchRow(array("ref_assinatura = ?" => $transaction['reference']));
						$idclubeassinatura = $fetch_status->idclubeassinatura;
					}else{
						// Quebra a referência
						$arr_ref = explode("**", $transaction['reference']);
						if(count($arr_ref) > 1) {
							// Remove o prefixo da referencia
							$idpedido = str_replace("REF", "", str_replace("teste", "", $arr_ref[0]));
						}else{
							// Remove o prefixo da referencia
							$idpedido = str_replace("REF", "", str_replace("teste", "", $transaction['reference']));
						}
					}

					// Verifica o id do status no banco de dados
					switch ($transaction['status']) {
						// Pagseguro - Aguardando pagamento
						case 1:
							$idstatus_pedido = 1; // Em andamento
							$txt_status = "Em andamento";
							$tipo_status = "Pendente"; // Assinatura
							break;

						// Pagseguro - Paga, Pagseguro - Disponível
						case 3:
						case 4:
							$idstatus_pedido = 22; // Aprovado
							$txt_status = "Aprovado";
							$tipo_status = "Ativo"; // Assinatura
							break;

						// Pagseguro - Em análise, Pagseguro - Em disputa, Pagseguro - Em contestação
						case 2:
						case 5:
						case 9:
							$idstatus_pedido = 15; // Análise em andamento
							$txt_status = "Análise em andamento";
							$tipo_status = "Pendente"; // Assinatura
							break;

						// Pagseguro - Devolvida, Pagseguro - Cancelada, Pagseguro - Chargeback debitado
						case 6:
						case 7:
						case 8:
							$idstatus_pedido = 7; // Cancelado
							$txt_status = "Cancelado";
							$tipo_status = "Inativo"; // Assinatura
							break;

						default:
							$idstatus_pedido = 1; // Em andamento
							$txt_status = "Em andamento";
							$tipo_status = "Pendente"; // Assinatura
							break;
					}


					if ($idpedido) {
						// Monta array do pedido com dados principais
						$pagto = array(
							'idpedido'  	  => $idpedido,
							'transaction' 	  => $transaction,
							'status' 	  	  => $txt_status,
							'idstatus_pedido' => $idstatus_pedido
						);
					}else{
						// Monta array da assinatura com dados principais
						$pagto = array(
							'idclubeassinatura' => $idclubeassinatura,
							'transaction' 	  => $transaction,
							'status' 	  	  => $tipo_status,
							'idstatus_pedido' => $idstatus_pedido
						);
					}

					$retorno = array(
		    			'status' 	=> "sucesso",
		    			'pagto' 	=> $pagto,
		    			'response'  => $response,
		    			'retorno' 	=> $serialize_response
		    		);
		    	}else{
		    		// Erro
					$retorno = array(
	    				'status'   => "erro",
	    				'response' => $response,
	    				'retorno'  => $serialize_response
	    			);
		    	}
			}catch (PagSeguroServiceException $e) {
				// Erro
				$retorno = array(
    				'status'  => "erro",
    				'retorno' => $e->getMessage()
    			);
			}
    	}else{
			/*
			*
			 * Caso seja uma notificação de Assinatura
			 * No caso de uma transação dentro da assinatura retornar algum status que altere o status atual da Assinatura, ele envia duas notificações simultanêas
			 * 1 - Relacionada a transação
		 	 * 2 - Relacionada a Assinatura
			 * Ex: Caso a transação retorne como "PAGA" a Assinatura automaticamente retorna como "Ativo"
			 * Apenas iremos alterar o status da assinatura caso o status seja diferente do atual
			 * OBS: Status inicial da Assinatura é "Ativo"
			 *
			*/
			$result = PagSeguroPreApprovalSearchService::findByNotification($this->credentials, $notificationCode);
			$serialize_response = serialize($result);


			if (strpos($result->getReference(), 'ASS') !== false){
				$model_assinatura = new Admin_Model_Clubeassinaturas();
				$fetch_status = $model_assinatura->fetchRow(array("ref_assinatura = ?" => $result->getReference()));
				$idclubeassinatura = $fetch_status->idclubeassinatura;
			}

			// Verifica o id do status no banco de dados
			switch ($result->getStatus()->getValue()) {
				// Pagseguro - PENDING
				case 1:
					$txt_status = "Pendente";
					break;

				// Pagseguro - ACTIVE
				case 2:
					$txt_status = "Ativo";
					break;

				// Pagseguro - CANCELLED
				case 3:
					$txt_status = "Inativo";
					break;

				// Pagseguro - CANCELLED_BY_RECEIVER
				case 4:
					$txt_status = "Inativo";
					break;

				// Pagseguro - CANCELLED_BY_SENDER
				case 5:
					$txt_status = "Inativo";
					break;

				default:
					$txt_status = "Pendente";
					break;
			}

			$retorno = array(
				'status' 			=> "sucesso",
				'idclubeassinatura' => $idclubeassinatura,
				'txt_status'		=> $txt_status,
				'tipo'				=> $notificationType,
				'response' 			=> $result,
				'retorno' 			=> $serialize_response
			);
    	}

    	// Retorna o array
    	return $retorno;
    }


	/**
	 * Consulta código da assinatura
	 *
	 * Sempre que precisar, você pode consultar dados de uma assinatura específica utilizando seu código identificador
	 *
	 */
	public function consultarAssinatura($preApprovalCode) {
		if(!empty($preApprovalCode)) {
			try {
				// Requisição ao pagSeguro
				$response = PagSeguroPreApprovalSearchService::searchByCode( $this->credentials, $preApprovalCode );

				$serialize_response = serialize($response);

				// Sucesso
				$retorno = array(
					'status'   	=> "sucesso",
					'tipo'		=>	"preApproval",
					'response' 	=> $response,
					'retorno'  	=> $serialize_response
				);
			}catch (PagSeguroServiceException $e) {
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
	 * Consulta código da transação
	 *
	 * Sempre que precisar, você pode consultar dados de uma transação específica utilizando seu código identificador
	 *
	 */
    public function consultarTransacao($transactionCode) {
    	if(!empty($transactionCode)) {
    		try {
    			// Requisição ao pagSeguro
				$response = PagSeguroTransactionSearchService::searchByCode( $this->credentials, $transactionCode );

				$serialize_response = serialize($response);

				// Sucesso
				$retorno = array(
	    			'status'   => "sucesso",
	    			'response' => $response,
	    			'retorno'  => $serialize_response
	    		);
			}catch (PagSeguroServiceException $e) {
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
	 * Consulta código de referência
	 *
	 * Você pode buscar transações com base em um código de referência
	 *
	 */
    public function consultarReferencia($referenceCode) {
    	if(!empty($referenceCode)) {
    		try{
  				// Requisição ao pagSeguro
			  	$response = PagSeguroTransactionSearchService::searchByReference( $this->credentials, $referenceCode, $initialDate = '', $finalDate = '', $pageNumber = '',  $maxPageResults = '' );

			  	$retorno = simplexml_load_string($response);

			}catch (PagSeguroServiceException $e) {
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
    			'retorno' => "Código de referência é obrigatório"
    		);
    	}

    	// Retorna json
		return json_encode($retorno);
    }

    /**
	 * Consulta transações concluídas por intervalo de datas
	 *
	 * Para facilitar seu controle financeiro e seu estoque, você pode solicitar uma lista com histórico das transações da sua loja
	 *
	 */
    public function consultarConcluidasData($initialDate, $finalDate) {
    	if(!empty($initialDate) && !empty($finalDate)) {
    		try{
  				// Requisição ao pagSeguro
			  	$response = PagSeguroTransactionSearchService::searchByDate( $this->credentials, $pageNumber = '',  $maxPageResults = '', $initialDate = '', $finalDate = '' );

			  	$retorno = simplexml_load_string($response);

			}catch (PagSeguroServiceException $e) {
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
    			'retorno' => "Intervalo de dados é obrigatório"
    		);
    	}

    	// Retorna json
		return json_encode($retorno);
    }

     /**
	 * Consulta transações abandonadas por intervalo de datas
	 *
	 * A consulta destas transações é útil para que você identifique quais transações não foram concluídas devido ao
	 * abandono do fluxo de pagamento e tente fazer algum processo de recuperação junto ao comprador
	 *
	 */
    public function consultarAbandonadasData($initialDate, $finalDate) {
    	if(!empty($initialDate) && !empty($finalDate)) {
    		try{
  				// Requisição ao pagSeguro
			  	$response = PagSeguroTransactionSearchService::searchAbandoned( $this->credentials, $pageNumber = '',  $maxPageResults = '', $initialDate = '', $finalDate = '' );

			  	$retorno = simplexml_load_string($response);

			}catch (PagSeguroServiceException $e) {
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
    			'retorno' => "Intervalo de dados é obrigatório"
    		);
    	}

    	// Retorna json
		return json_encode($retorno);
    }

    /**
	 * Solicitar estorno de transação
	 *
	 * Sempre que precisar você pode solicitar o estorno parcial ou total de uma transação previamente paga
	 *
	 */
    public function estornarTransacao($transactionCode, $refundAmount = '') {
    	//$refundAmount = "100.50"; // opcional para valor parcial

		if(!empty($transactionCode)) {
			try{
				// Requisição ao pagSeguro
				$response = PagSeguroRefundService::createRefundRequest( $this->credentials, $transactionCode, $refundAmount );

				$retorno = simplexml_load_string($response);

			}catch (PagSeguroServiceException $e) {
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
	 * Solicitar cancelamento de transação
	 *
	 * Sempre que precisar você pode solicitar o cancelamento de uma transação que ainda esteja sendo processada
	 *
	 */
    public function cancelarTransacao($transactionCode) {
    	if(!empty($transactionCode)) {
    		try{
    			// Requisição ao pagSeguro
			    $response = PagSeguroCancelService::createRequest($this->credentials, $transactionCode);

			    $retorno = simplexml_load_string($response);

			}catch (PagSeguroServiceException $e) {
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
	 * Solicitar cancelamento de transação
	 *
	 * Sempre que precisar você pode solicitar o cancelamento de uma transação que ainda esteja sendo processada
	 *
	 */
	public function cancelarAssinatura($preApprovalCode) {
		if(!empty($preApprovalCode)) {
			try {

				$response = PagSeguroPreApprovalService::cancelPreApproval($this->credentials, $preApprovalCode);
				$serialize_response = json_decode($response, true);

				if ($response == 'Unauthorized') {
					// Erro
					$retorno = array(
						'status' => "erro",
						'retorno' => $serialize_response
					);
				} else {
					$retorno = array(
						'status' => "sucesso",
						'retorno' => $serialize_response
					);
				}
			} catch (PagSeguroServiceException $e) {
//				if ($e->getErrors()[0]->getCode() == 17022){
//					// Erro
//					$retorno = array(
//						'status' => "sucesso",
//						'retorno' => "Cancelado com Sucesso!"
//					);
//				}else{
					// Erro
					$retorno = array(
						'status' => "erro",
						'retorno' => $e->getMessage()
					);
				//}
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

    /**
     *
     */
    public static function infoTransaction($tipoinfo, $code) {
    	// Armazena informações gerais
		$dadostatus['info'] = "";

		// Tipo de transação
		$dadostatus['info']['tipotransacao'][1] = "Pagamento";
		$dadostatus['info']['tipotransacao'][11] = "Assinatura";

		// Status da transação
		$dadostatus['info']['statustransacao'][1] = "Aguardando pagamento";
		$dadostatus['info']['statustransacao'][2] = "Em análise";
		$dadostatus['info']['statustransacao'][3] = "Paga";
		$dadostatus['info']['statustransacao'][4] = "Disponível";
		$dadostatus['info']['statustransacao'][5] = "Em disputa";
		$dadostatus['info']['statustransacao'][6] = "Devolvida";
		$dadostatus['info']['statustransacao'][7] = "Cancelada";
		$dadostatus['info']['statustransacao'][8] = "Chargeback debitado";
		$dadostatus['info']['statustransacao'][9] = "Em contestação";

		// Meio de pagamento
		$dadostatus['info']['formapagamento'][1] = "Cartão de crédito";
		$dadostatus['info']['formapagamento'][2] = "Boleto";
		$dadostatus['info']['formapagamento'][3] = "Débito online (TEF)";
		$dadostatus['info']['formapagamento'][4] = "Saldo PagSeguro";
		$dadostatus['info']['formapagamento'][5] = "Oi Paggo *";
		$dadostatus['info']['formapagamento'][7] = "Depósito em conta";

		// Método de pagamento
		$dadostatus['info']['metodopagamento'][101] = "Crédito Visa";
		$dadostatus['info']['metodopagamento'][102] = "Crédito MasterCard";
		$dadostatus['info']['metodopagamento'][103] = "Crédito American Express";
		$dadostatus['info']['metodopagamento'][104] = "Crédito Diners";
		$dadostatus['info']['metodopagamento'][105] = "Crédito Hipercard";
		$dadostatus['info']['metodopagamento'][106] = "Crédito Aura";
		$dadostatus['info']['metodopagamento'][107] = "Crédito Elo";
		$dadostatus['info']['metodopagamento'][108] = "Crédito PLENOCard*";
		$dadostatus['info']['metodopagamento'][109] = "Crédito PersonalCard";
		$dadostatus['info']['metodopagamento'][110] = "Crédito JCB";
		$dadostatus['info']['metodopagamento'][111] = "Crédito Discover";
		$dadostatus['info']['metodopagamento'][112] = "Crédito BrasilCard";
		$dadostatus['info']['metodopagamento'][113] = "Crédito FORTBRASIL";
		$dadostatus['info']['metodopagamento'][114] = "Crédito CARDBAN*";
		$dadostatus['info']['metodopagamento'][115] = "Crédito VALECARD";
		$dadostatus['info']['metodopagamento'][116] = "Crédito Cabal";
		$dadostatus['info']['metodopagamento'][117] = "Crédito Mais!";
		$dadostatus['info']['metodopagamento'][118] = "Crédito Avista";
		$dadostatus['info']['metodopagamento'][119] = "Crédito GRANDCARD";
		$dadostatus['info']['metodopagamento'][120] = "Crédito Sorocred";
		$dadostatus['info']['metodopagamento'][201] = "Boleto Bradesco*";
		$dadostatus['info']['metodopagamento'][202] = "Boleto Santander";
		$dadostatus['info']['metodopagamento'][301] = "Débito online Bradesco";
		$dadostatus['info']['metodopagamento'][302] = "Débito online Itaú";
		$dadostatus['info']['metodopagamento'][303] = "Débito online Unibanco*";
		$dadostatus['info']['metodopagamento'][304] = "Débito online Banco do Brasil";
		$dadostatus['info']['metodopagamento'][305] = "Débito online Banco Real*";
		$dadostatus['info']['metodopagamento'][306] = "Débito online Banrisul";
		$dadostatus['info']['metodopagamento'][307] = "Débito online HSBC";
		$dadostatus['info']['metodopagamento'][401] = "Saldo PagSeguro";
		$dadostatus['info']['metodopagamento'][501] = "Oi Paggo*";
		$dadostatus['info']['metodopagamento'][701] = "Depósito em conta - Banco do Brasil";
		$dadostatus['info']['metodopagamento'][702] = "Depósito em conta - HSBC";

		// Tipo de frete
		$dadostatus['info']['tipofrete'][1] = "Encomenda normal (PAC)";
		$dadostatus['info']['tipofrete'][2] = "SEDEX";
		$dadostatus['info']['tipofrete'][3] = "Tipo de frete não especificado";

		// Retorna informação
		return $dadostatus['info'][$tipoinfo][$code];
    }

    /**
     * Retorna os dados separados do $response (retorno do método payment->register)
     * @param  [type] $transaction [description]
     * @return [type]              [description]
     */
    public static function printTransactionReturn($transaction) {
        if($transaction) {
            echo "<h2>Retorno da transa&ccedil;&atilde;o com Cart&atilde;o de Cr&eacute;dito.</h2>";
            echo "<p><strong>Date: </strong> ".$transaction->getDate() ."</p> ";
            echo "<p><strong>lastEventDate: </strong> ".$transaction->getLastEventDate()."</p> ";
            echo "<p><strong>code: </strong> ".$transaction->getCode() ."</p> ";
            echo "<p><strong>reference: </strong> ".$transaction->getReference() ."</p> ";
            echo "<p><strong>type: </strong> ".$transaction->getType()->getValue() ."</p> ";
            echo "<p><strong>status: </strong> ".$transaction->getStatus()->getValue() ."</p> ";
            echo "<p><strong>paymentMethodType: </strong> ".$transaction->getPaymentMethod()->getType()->getValue() ."</p> ";
            echo "<p><strong>paymentModeCode: </strong> ".$transaction->getPaymentMethod()->getCode()->getValue() ."</p> ";
            echo "<p><strong>grossAmount: </strong> ".$transaction->getGrossAmount() ."</p> ";
            echo "<p><strong>discountAmount: </strong> ".$transaction->getDiscountAmount() ."</p> ";
            echo "<p><strong>feeAmount: </strong> ".$transaction->getFeeAmount() ."</p> ";
            echo "<p><strong>netAmount: </strong> ".$transaction->getNetAmount() ."</p> ";
            echo "<p><strong>extraAmount: </strong> ".$transaction->getExtraAmount() ."</p> ";
            echo "<p><strong>installmentCount: </strong> ".$transaction->getInstallmentCount() ."</p> ";
            echo "<p><strong>itemCount: </strong> ".$transaction->getItemCount() ."</p> ";
            echo "<p><strong>Items: </strong></p>";
            foreach ($transaction->getItems() as $item) {
                echo "<p><strong>id: </strong> ". $item->getId() ."</br> ";
                echo "<strong>description: </strong> ". $item->getDescription() ."</br> ";
                echo "<strong>quantity: </strong> ". $item->getQuantity() ."</br> ";
                echo "<strong>amount: </strong> ". $item->getAmount() ."</p> ";
            }

            echo "<p><strong>senderName: </strong> ".$transaction->getSender()->getName() ."</p> ";
            echo "<p><strong>senderEmail: </strong> ".$transaction->getSender()->getEmail() ."</p> ";
            echo "<p><strong>senderPhone: </strong> ".$transaction->getSender()->getPhone()->getAreaCode() . " - " .
                 $transaction->getSender()->getPhone()->getNumber() . "</p> ";
            echo "<p><strong>Shipping: </strong></p>";
            echo "<p><strong>street: </strong> ".$transaction->getShipping()->getAddress()->getStreet() ."</p> ";
            echo "<p><strong>number: </strong> ".$transaction->getShipping()->getAddress()->getNumber()  ."</p> ";
            echo "<p><strong>complement: </strong> ".$transaction->getShipping()->getAddress()->getComplement()  ."</p> ";
            echo "<p><strong>district: </strong> ".$transaction->getShipping()->getAddress()->getDistrict()  ."</p> ";
            echo "<p><strong>postalCode: </strong> ".$transaction->getShipping()->getAddress()->getPostalCode()  ."</p> ";
            echo "<p><strong>city: </strong> ".$transaction->getShipping()->getAddress()->getCity()  ."</p> ";
            echo "<p><strong>state: </strong> ".$transaction->getShipping()->getAddress()->getState()  ."</p> ";
            echo "<p><strong>country: </strong> ".$transaction->getShipping()->getAddress()->getCountry()  ."</p> ";
        }
      echo "<pre>";
    }




    /**
     *
     * Pega a Quantidade de parcelas disponíveis
     *
     * Buscar a quantidade de parcelas, de acordo com o valor e a bandeira do cartão
     * OBS: a Bandeira do cartão deve ser buscada pelo Javascript do PAGSEGURO
     *
     */
    public function buscarParcelas($Parametros){
        /**
         *    Exemplo de Array
         *
         *    //$Parametros = [
         *        'amount' => 30.00, Required (Valor total)
         *        'card_brand' => 'visa', Optional (Marca do cartão de crédito, caso não seja específicado, retornará todas as marcas de cartão e opções de parcelamentos.)
         *        'max_installment_no_interest' => 2 Optional (Quantidade de parcelas sem juros)
         *    //];
         *
         */

        try {
            $result = \PagSeguro\Services\Installment::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials(),
                $Parametros
            );

            return $result->getInstallments();
        } catch (Exception $e) {
            die($e->getMessage());
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
				'Content-Type: application/json',
				'Accept: application/vnd.pagseguro.com.br.v3+json;charset=' . $charset,
				'lib-description: php:' . PagSeguroLibrary::getVersion(),
				'language-engine-description: php:' . PagSeguroLibrary::getPHPVersion()
			),
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_CONNECTTIMEOUT => $timeout,
			//CURLOPT_TIMEOUT => $timeout
		);

		if (!is_null(PagSeguroLibrary::getModuleVersion())) {
			array_push($options[CURLOPT_HTTPHEADER], 'module-description: ' . PagSeguroLibrary::getModuleVersion());
		}

		if (!is_null(PagSeguroLibrary::getCMSVersion())) {
			array_push($options[CURLOPT_HTTPHEADER], 'cms-description: ' . PagSeguroLibrary::getCMSVersion());
		}

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
