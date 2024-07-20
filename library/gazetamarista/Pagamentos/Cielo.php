<?php

/**
 * Classe de pagamentos pela cielo
 *
 * @name gazetamarista_Pagamentos_Cielo
 */
class gazetamarista_Pagamentos_Cielo extends gazetamarista_Pagamentos_Abstract {

    /**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "cielo";

    private $logger;
    private $_application_config;
	private $_modules;
	private $cliente;
    private $session_config;

    public $gateway_url = "https://qasecommerce.cielo.com.br";
    public $gateway_email = "";
    public $gateway_merchantId = "";
    public $gateway_merchantKey = "";

    public $_VERSAO = "3.1.3";
    public $_ENCODING = "ISO-8859-1";


    /**
	 * Inicializa a classe de pagamento Cielo
	 *
	 * @name init
	 */
	public function init() {
		// Sessão de configuração
		$this->session_config = new Zend_Session_Namespace("configuracao");
		$settings = $this->session_config->dados;

		// Armazena as configurações globais
		$this->_application_config = Zend_Registry::get("config");
		$this->_modules = Zend_Registry::get("modulos");

		// Função de bloquear injection
		$this->sanitize = new gazetamarista_Sanitize();

		// Verifica configuração da loja
    	if($settings->pagto_ativo) {
            // Define variáveis
            if($settings->pagto_ambiente == 'sandbox') {
                if(!empty($settings->pagto_sandbox_merchant_id) && !empty($settings->pagto_sandbox_merchant_key)) {
                    $this->gateway_ambiente     = $settings->pagto_ambiente;
                    $this->gateway_email        = $settings->pagto_sandbox_email;
                    $this->gateway_merchantId   = $settings->pagto_sandbox_merchant_id;
                    $this->gateway_merchantKey  = $settings->pagto_sandbox_merchant_key;
                }else{
                    throw new Exception("Dados da Cielo incorretos, confirme no painel de configuração.");
                }
            }else{
                if(!empty($settings->pagto_production_merchant_id) && !empty($settings->pagto_production_merchant_key)) {
                    $this->gateway_ambiente     = $settings->pagto_ambiente;
                    $this->gateway_email        = $settings->pagto_production_email;
                    $this->gateway_merchantId   = $settings->pagto_production_merchant_id;
                    $this->gateway_merchantKey  = $settings->pagto_production_merchant_key;
                }else{
                    throw new Exception("Dados da Cielo incorretos, confirme no painel de configuração.");
                }
            }
        }else{
    		throw new Exception("Sistema inativo, verifique configuração da loja.");
    	}

        // Chama a biblioteca
        require_once(APPLICATION_PATH."/../library/gazetamarista/Library/Cielo/vendor/autoload.php");

    	// Configure o ambiente
        if($this->gateway_ambiente == 'production') {
            $this->environment = \Cielo\API30\Ecommerce\Environment::production();
        }else{
            $this->environment = \Cielo\API30\Ecommerce\Environment::sandbox();
        }

        // Configure seu merchant
        $this->merchant = new \Cielo\API30\Merchant($this->gateway_merchantId, $this->gateway_merchantKey);

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
	}

	/**
	 *
	 * Envia Requisição para criar a transação
	 *
	 * Boleto/Cartão
	 * Bandeira do cartão (Visa / Master / Amex / Elo / Aura / JCB / Diners / Discover / Hipercard / Hiper)
     * Boletos Bradesco e Banco do Brasil
	 */
    public function sendSale() {
        // Parâmetros pagamento
        $tipo_pagto     = $this->_arrPagto['tipo'];
        $cc_name        = $this->_arrPagto['card_nome'];
        $cc_number      = $this->_arrPagto['card_numero'];
        $cc_validade    = $this->_arrPagto['card_validade'];
        $cc_cvv         = $this->_arrPagto['card_cvv'];
        $parcelas       = $this->_arrPagto['card_parcela'];
        $valortotal     = str_replace('.', '', $this->_arrPagto['valor_plano']);
        $recorrente     = $this->_arrPagto['recorrente'];
        $renovar_plano  = $this->_arrPagto['renovar_plano'];

        // Result
        $retorno = array();

        // Somente número do cartão
        $somenteNumCartao = preg_replace('/[^0-9]/', '', $cc_number);

        // Bandeira
        $brand_card = $this->card_brand($somenteNumCartao);

        // Número cartão
        $inicioCartao   = substr($somenteNumCartao, 0, 6);
        $finalCartao    = substr($somenteNumCartao, -4);
        $cartaoNum      = $inicioCartao.'******'.$finalCartao;

        // Validade cartão
        $vencimento_arr = explode("/", $cc_validade);
        if(count($vencimento_arr) > 0) {
            $mesCartao = $vencimento_arr[0];
            $anoCartao = '20' . $vencimento_arr[1];
        }

        // Crie uma instância de Sale informando o ID
        $sale = new \Cielo\API30\Ecommerce\Sale($this->_idassinatura);

        // Crie uma instância de Customer, dados do cliente
        $customer = $sale->customer($this->_assinatura->nome_pagamento)
            ->setIdentity($this->_assinatura->documento_pagamento)
            ->setIdentityType('CPF')
            ->address()->setZipCode(str_replace('-', '', $this->_assinatura->cep_pagamento))
                ->setCountry('BRA')
                ->setState($this->_assinatura->estado_pagamento)
                ->setCity($this->_assinatura->cidade_pagamento)
                ->setDistrict($this->_assinatura->bairro_pagamento)
                ->setStreet($this->_assinatura->endereco_pagamento)
                ->setNumber($this->_assinatura->numero_pagamento);

        // Tipo
        if($tipo_pagto == "cartao") {
            // CARTAO DE CREDITO
            $payment = $sale->payment($valortotal, $parcelas);
            $payment->setType(\Cielo\API30\Ecommerce\Payment::PAYMENTTYPE_CREDITCARD)
                ->creditCard($cc_cvv, $this->varBrand($brand_card))
                ->setExpirationDate($mesCartao.'/'.$anoCartao)
                ->setCardNumber($somenteNumCartao)
                ->setHolder($cc_name);

            if($recorrente) {
                // Pagamento recorrente (validar período da recorrência)
                if($this->_assinatura->dias_validade == 30) {
                    $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_MONTHLY);
                }elseif($this->_assinatura->dias_validade == 60) {
                    $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_BIMONTHLY);
                }elseif($this->_assinatura->dias_validade == 90) {
                    $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_QUARTERLY);
                }elseif($this->_assinatura->dias_validade == 180) {
                    $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_SEMIANNUAL);
                }elseif($this->_assinatura->dias_validade == 360) {
                    $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_ANNUAL);
                }else{
                    $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_MONTHLY);
                }
            }
        }else{
            // BOLETO
            $payment = $sale->payment($valortotal)
                ->setType(\Cielo\API30\Ecommerce\Payment::PAYMENTTYPE_BOLETO)
                ->setAddress('Rua Teste - Londrina PR') // Endereço do Cedente
                ->setBoletoNumber('1234567') // Nosso numero
                ->setAssignor('gazetamarista Sites') // Nome do Cedente
                ->setDemonstrative('Pagar o boleto até a data de vencimento')
                ->setExpirationDate(date('d/m/Y', strtotime('+5 days')))
                ->setIdentification('4545456656565') // Documento de identificação do Cedente
                ->setInstructions('Esse é um boleto que foi gerado do sistema'); // Instruções do Boleto
        }

        // Crie o pagamento na Cielo
        try {
            // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
            $sale = (new \Cielo\API30\Ecommerce\CieloEcommerce($this->merchant, $this->environment))->createSale($sale);

            // ID do pagamento, TID e demais dados retornados pela Cielo
            $paymentArray       = $sale->getPayment();
            $paymentStatus      = $sale->getPayment()->getStatus();
            $paymentTid         = $sale->getPayment()->getTid();
            $paymentId          = $sale->getPayment()->getPaymentId();
            $paymentType        = $sale->getPayment()->getType();
            if($recorrente) {
                $recurrentPaymentId = $sale->getPayment()->getRecurrentPayment()->getRecurrentPaymentId();
            }

            if($tipo_pagto == "cartao") {
                if($paymentStatus == 1) {
                    // Com o ID do pagamento, podemos fazer sua captura
                    $saleCapture = (new \Cielo\API30\Ecommerce\CieloEcommerce($this->merchant, $this->environment))->captureSale($paymentId, $valortotal, 0);

                    $CaptureStatus         = $saleCapture->getStatus();
                    $CaptureReturnCode     = $saleCapture->getReturnCode();
                    $CaptureReturnMessage  = $saleCapture->getReturnMessage();
                }

                // Monta dados de retorno
                $array_return = array(
                    'MerchantOrderId'       => $sale->getMerchantOrderId(),
                    'Installments'          => $sale->getPayment()->getInstallments(),
                    'Capture'               => $sale->getPayment()->getCapture(),
                    'Type'                  => $paymentType,
                    'Amount'                => $sale->getPayment()->getAmount(),
                    'CapturedAmount'        => $sale->getPayment()->getCapturedAmount(),
                    'AuthorizationCode'     => $sale->getPayment()->getAuthorizationCode(),
                    'PaymentId'             => $paymentId,
                    'Tid'                   => $paymentTid,
                    'SaleStatus'            => $paymentStatus,
                    'SaleReturnCode'        => $sale->getPayment()->getReturnCode(),
                    'SaleReturnMessage'     => $sale->getPayment()->getReturnMessage(),
                    'CaptureStatus'         => $CaptureStatus,
                    'CaptureReturnCode'     => $CaptureReturnCode,
                    'CaptureReturnMessage'  => $CaptureReturnMessage,
                    'RecurrentPaymentId'    => $recurrentPaymentId,
                    'PaymentArray'          => $paymentArray
                );
            }else{
                // Boleto

                // Monta dados de retorno
                $array_return = array(
                    'MerchantOrderId'       => $sale->getMerchantOrderId(),
                    'Type'                  => $paymentType,
                    'Amount'                => $sale->getPayment()->getAmount(),
                    'Url'                   => $sale->getPayment()->getUrl(),
                    'Provider'              => $sale->getPayment()->getProvider(),
                    'BoletoNumber'          => $sale->getPayment()->getBoletoNumber(),
                    'DigitableLine'         => $sale->getPayment()->getDigitableLine(),
                    'PaymentId'             => $paymentId,
                    'SaleStatus'            => $paymentStatus,
                    'SaleReturnCode'        => $sale->getPayment()->getReturnCode()
                );
            }

            if($array_return['CaptureStatus'] == 2 || !empty($array_return['Url'])) {
                // SUCESSO
                $retorno['retorno']         = $array_return;
                $retorno['recorrente']      = $recorrente && !empty($recurrentPaymentId) ? 1 : 0;
                $retorno['renovar_plano']   = $renovar_plano;
                $retorno['status']          = "sucesso";
            }else{
                // ERRO
                $retorno['retorno']         = $array_return;
                $retorno['recorrente']      = $recorrente;
                $retorno['renovar_plano']   = $renovar_plano;
                $retorno['status']          = "erro";
                $retorno['msgTitulo']       = "Pagamento não realizado.";
                if(!empty($CaptureReturnCode)) {
                    // Erro capture
                    $retorno['msgMensagem'] = $CaptureReturnMessage . " (".$CaptureReturnCode.")";
                }else{
                    // Erro sale
                    if($paymentStatus > 0) {
                        $retorno['msgMensagem'] = $this->getErroStatus($paymentStatus);
                    }
                }
            }
        } catch (\Cielo\API30\Ecommerce\Request\CieloRequestException $e) {
            // ERRO, erros de integração
            $retorno['retorno']         = $e->getCode() . ': ' . $e->getMessage();
            $retorno['recorrente']      = $recorrente;
            $retorno['renovar_plano']   = $renovar_plano;
            $retorno['status']          = "erro";
        }

        // Salva log e atualiza tabela pagto
        $this->status($retorno['status'], $retorno);

        // Return
        return $retorno;
    }

    /**
	 *
	 * Envia Requisição para criar a transação com token de cartão
     * Pagamento recorrente ou não
	 *
	 * Cartão tokenizado
	 * Bandeira do cartão (Visa / Master / Amex / Elo / Aura / JCB / Diners / Discover / Hipercard / Hiper)
     *
	 */
    public function sendSaleCardToken() {
        // Parâmetros pagamento
        $card_idcartao  = $this->_arrPagto['card_idcartao'];
        $card_bandeira  = $this->_arrPagto['card_bandeira'];
        $cc_token       = $this->_arrPagto['card_token'];
        $cc_cvv         = $this->_arrPagto['card_cvv'];
        $parcelas       = $this->_arrPagto['card_parcela'];
        $valortotal     = str_replace('.', '', $this->_arrPagto['valor_plano']);
        $recorrente     = $this->_arrPagto['recorrente'];
        $renovar_plano  = $this->_arrPagto['renovar_plano'];

        // Result
        $retorno = array();

        // Crie uma instância de Sale informando o ID
        $sale = new \Cielo\API30\Ecommerce\Sale($this->_idassinatura);

        // Crie uma instância de Customer, dados do cliente
        $customer = $sale->customer($this->_assinatura->nome_pagamento)
            ->setIdentity($this->_assinatura->documento_pagamento)
            ->setIdentityType('CPF')
            ->address()->setZipCode(str_replace('-', '', $this->_assinatura->cep_pagamento))
                ->setCountry('BRA')
                ->setState($this->_assinatura->estado_pagamento)
                ->setCity($this->_assinatura->cidade_pagamento)
                ->setDistrict($this->_assinatura->bairro_pagamento)
                ->setStreet($this->_assinatura->endereco_pagamento)
                ->setNumber($this->_assinatura->numero_pagamento);

        // CARTAO DE CREDITO COM TOKEN
        $payment = $sale->payment($valortotal, $parcelas);
        $payment->setType(\Cielo\API30\Ecommerce\Payment::PAYMENTTYPE_CREDITCARD)
            ->creditCard($cc_cvv, $this->varBrand($card_bandeira))
            ->setCardToken($cc_token);

        if($recorrente) {
            // Pagamento recorrente (validar período da recorrência)
            if($this->_assinatura->dias_validade == 30) {
                $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_MONTHLY);
            }elseif($this->_assinatura->dias_validade == 60) {
                $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_BIMONTHLY);
            }elseif($this->_assinatura->dias_validade == 90) {
                $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_QUARTERLY);
            }elseif($this->_assinatura->dias_validade == 180) {
                $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_SEMIANNUAL);
            }elseif($this->_assinatura->dias_validade == 360) {
                $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_ANNUAL);
            }else{
                $payment->recurrentPayment(true)->setInterval(\Cielo\API30\Ecommerce\RecurrentPayment::INTERVAL_MONTHLY);
            }
        }

        // Crie o pagamento na Cielo
        try {
            // Configure o SDK com seu merchant e o ambiente apropriado para criar a venda
            $sale = (new \Cielo\API30\Ecommerce\CieloEcommerce($this->merchant, $this->environment))->createSale($sale);

            // ID do pagamento, TID e demais dados retornados pela Cielo
            $paymentArray       = $sale->getPayment();
            $paymentStatus      = $sale->getPayment()->getStatus();
            $paymentTid         = $sale->getPayment()->getTid();
            $paymentId          = $sale->getPayment()->getPaymentId();
            $paymentType        = $sale->getPayment()->getType();
            if($recorrente) {
                $recurrentPaymentId = $sale->getPayment()->getRecurrentPayment()->getRecurrentPaymentId();
            }

            if($paymentStatus == 1) {
                // Com o ID do pagamento, podemos fazer sua captura
                $saleCapture = (new \Cielo\API30\Ecommerce\CieloEcommerce($this->merchant, $this->environment))->captureSale($paymentId, $valortotal, 0);

                $CaptureStatus         = $saleCapture->getStatus();
                $CaptureReturnCode     = $saleCapture->getReturnCode();
                $CaptureReturnMessage  = $saleCapture->getReturnMessage();
            }

            // Monta dados de retorno
            $array_return = array(
                'MerchantOrderId'       => $sale->getMerchantOrderId(),
                'Installments'          => $sale->getPayment()->getInstallments(),
                'Capture'               => $sale->getPayment()->getCapture(),
                'Type'                  => $paymentType,
                'Amount'                => $sale->getPayment()->getAmount(),
                'CapturedAmount'        => $sale->getPayment()->getCapturedAmount(),
                'AuthorizationCode'     => $sale->getPayment()->getAuthorizationCode(),
                'PaymentId'             => $paymentId,
                'Tid'                   => $paymentTid,
                'SaleStatus'            => $paymentStatus,
                'SaleReturnCode'        => $sale->getPayment()->getReturnCode(),
                'SaleReturnMessage'     => $sale->getPayment()->getReturnMessage(),
                'CaptureStatus'         => $CaptureStatus,
                'CaptureReturnCode'     => $CaptureReturnCode,
                'CaptureReturnMessage'  => $CaptureReturnMessage,
                'RecurrentPaymentId'    => $recurrentPaymentId,
                'PaymentArray'          => $paymentArray
            );

            if($array_return['CaptureStatus'] == 2 || !empty($array_return['Url'])) {
                // SUCESSO
                $retorno['retorno']         = $array_return;
                $retorno['idcartao']        = $card_idcartao;
                $retorno['recorrente']      = $recorrente && !empty($recurrentPaymentId) ? 1 : 0;
                $retorno['renovar_plano']   = $renovar_plano;
                $retorno['status']          = "sucesso";
            }else{
                // ERRO
                $retorno['retorno']         = $array_return;
                $retorno['idcartao']        = $card_idcartao;
                $retorno['recorrente']      = $recorrente;
                $retorno['renovar_plano']   = $renovar_plano;
                $retorno['status']          = "erro";
                $retorno['msgTitulo']       = "Pagamento não realizado.";
                if(!empty($CaptureReturnCode)) {
                    // Erro capture
                    $retorno['msgMensagem'] = $CaptureReturnMessage . " (".$CaptureReturnCode.")";
                }else{
                    // Erro sale
                    if($paymentStatus > 0) {
                        $retorno['msgMensagem'] = $this->getErroStatus($paymentStatus);
                    }
                }
            }
        } catch (\Cielo\API30\Ecommerce\Request\CieloRequestException $e) {
            // ERRO, erros de integração
            $retorno['retorno']         = $e->getCode() . ': ' . $e->getMessage();
            $retorno['idcartao']        = $card_idcartao;
            $retorno['recorrente']      = $recorrente;
            $retorno['renovar_plano']   = $renovar_plano;
            $retorno['status']          = "erro";
        }

        // Salva log e atualiza tabela pagto
        $this->status($retorno['status'], $retorno);

        // Return
        return $retorno;
    }

    /**
     *  Salvar Dados do Cartão no ID do Cliente
     *
     *  @access public
     *  @name saveCardClient
     *  @param array $parametros
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
        $somenteNumCartao = preg_replace('/[^0-9]/', '', $parametros['numerocartao']);

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
            // Validar na Cielo o cartão (gerar token)

            // Crie uma instância do objeto que irá retornar o token do cartão
            $card = new \Cielo\API30\Ecommerce\CreditCard();
            $card->setCustomerName($session_cliente->dados->nome_completo);
            $card->setCardNumber($somenteNumCartao);
            $card->setHolder($parametros['nomeimpresso']);
            $card->setExpirationDate($mesCartao.'/'.$anoCartao);
            $card->setBrand($this->varBrand($brand_card));

            try {
                // Configure o SDK com seu merchant e o ambiente apropriado para recuperar o cartão
                $card = (new \Cielo\API30\Ecommerce\CieloEcommerce($this->merchant, $this->environment))->tokenizeCard($card);

                // Get the token
                $cardToken = $card->getCardToken();

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

                // Se não existir cartão ainda, já fixa como 'padrão'
                $possui_cartoes = (new Admin_Model_Clientescartoes())->fetchAll(array('idcliente = ?' => $session_cliente->dados->idcliente));
                if(count($possui_cartoes) > 0) {
                    $principal_card = 0;
                }else{
                    $principal_card = 1;
                }

                // Array dados
                $data_insert = array(
                    'idcliente'     => $session_cliente->dados->idcliente,
                    'token'         => $cardToken,
                    'nome'          => $parametros['nomeimpresso'],
                    'validade_mes'  => $mesCartao,
                    'validade_ano'  => $anoCartao,
                    'validade'      => $parametros['vencimento'],
                    'numero_cartao' => $cartaoNum,
                    'final_cartao'  => $finalCartao,
                    'cpf_titular'   => $parametros['cpftitular'],
                    'marca'         => strtolower($brand_card),
                    'cadastrado_em' => date("Y-m-d H:i:s"),
                    'principal'     => $principal_card,
                    'validado'      => 1,
                    'retorno'       => json_encode($retorno)
                );

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
     * Buscar dados de pagamento
     */
    public function getSale() {
        // Inicia resposta
        $retorno = array();

        if(!$this->_assinatura) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Assinatura não encontrada.";
            return $retorno;
        }

        // Objeto retornado da Cielo no pagamento
        $paymentId = !$this->_assinatura->cobranca_recorrente ? $this->_assinatura->code_assinatura : 0;

        // Crie uma instância de Sale informando o PAYMENTID
        $saleGet = (new \Cielo\API30\Ecommerce\CieloEcommerce($this->merchant, $this->environment))->getSale($paymentId);

        //Zend_Debug::dump($this->_assinatura);
        Zend_Debug::dump($saleGet);
        exit;
    }

    /**
     * Cancelar pagamento
     */
    public function cancelSale() {
        Zend_Debug::dump($this->_assinatura);
        exit;

        // Objeto retornado da Cielo no pagamento
        $paymentId = $sale->getPayment()->getPaymentId();
        $paymentValor = 9900;

        // Crie uma instância de Sale informando o ID
        $sale = new \Cielo\API30\Ecommerce\Sale($this->_idassinatura);

        $sale = (new \Cielo\API30\Ecommerce\CieloEcommerce($this->merchant, $this->environment))->cancelSale($paymentId, $paymentValor);
    }

    /**
     * Buscar dados de pagamento recorrente
     */
    public function getSaleRecurrent() {
        // Inicia resposta
        $retorno = array();

        if(!$this->_assinatura) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Assinatura não encontrada.";
            return $retorno;
        }

        // Objeto retornado da Cielo no pagamento recorrente
        $recurrentPaymentId = $this->_assinatura->code_assinatura;

        $url = $this->environment->getApiURL().'1'.'/RecurrentPayment/'.$recurrentPaymentId;

        $headers = array(
            'Content-Type' => 'application/json','Accept-Encoding: gzip',
            'User-Agent: CieloEcommerce/3.0 PHP SDK',
            'MerchantId' => $this->gateway_merchantId,
            'MerchantKey' => $this->gateway_merchantKey,
            'RequestId: ' . uniqid()
        );

        $streamOpts = array(
            'ssl' => array(
                'verify_peer' => false,
                'allow_self_signed' => true
            )
        );

        $client = new Zend_Http_Client();
        $client->setUri($url);
        $client->setHeaders($headers);
        $adapter = new Zend_Http_Client_Adapter_Socket();
        $client->setAdapter($adapter);
        $adapter->setStreamContext($streamOpts);

		// Faz a requisição
		$response        = $client->request("GET");
		$responseBody    = $response->getBody();
		$responseMessage = $response->getMessage();
        $responseStatus  = $response->getStatus();

        if($responseStatus == '200') {
            // SUCESSO
            $retorno['status']  = "sucesso";
            $retorno['retorno'] = $response;
            $retorno['recurrentPaymentId'] = $recurrentPaymentId;
        }else{
            // ERRO
            $retorno['status']      = "erro";
            $retorno['retorno']     = $response;
            $retorno['recurrentPaymentId'] = $recurrentPaymentId;
            $retorno['msgTitulo']   = "Dados não encontrados. Entre em contato conosco";
            $retorno['msgMensagem'] = $responseMessage . " (".$responseStatus.")";
        }

        // Return
        return $retorno;
    }

    /**
     * Desativar um pagamento recorrente
     */
    public function deactivateRecurrent() {
        // Inicia resposta
        $retorno = array();

        if(!$this->_assinatura) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Assinatura não encontrada.";
            return $retorno;
        }

        // Objeto retornado da Cielo no pagamento recorrente
        $recurrentPaymentId = $this->_assinatura->cobranca_recorrente ? $this->_assinatura->code_assinatura : '';

        if(empty($recurrentPaymentId)) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Recorrência não encontrada.";
            return $retorno;
        }

        $url = $this->environment->getApiURL().'1'.'/RecurrentPayment/'.$recurrentPaymentId.'/Deactivate';

        $headers = array(
            'Content-Type' => 'application/json','Accept-Encoding: gzip',
            'User-Agent: CieloEcommerce/3.0 PHP SDK',
            'MerchantId' => $this->gateway_merchantId,
            'MerchantKey' => $this->gateway_merchantKey,
            'RequestId: ' . uniqid()
        );

        $streamOpts = array(
            'ssl' => array(
                'verify_peer' => false,
                'allow_self_signed' => true
            )
        );

        $client = new Zend_Http_Client();
        $client->setUri($url);
        $client->setHeaders($headers);
        $adapter = new Zend_Http_Client_Adapter_Socket();
        $client->setAdapter($adapter);
        $adapter->setStreamContext($streamOpts);

		// Faz a requisição
		$response        = $client->request("PUT");
		$responseBody    = $response->getBody();
		$responseMessage = $response->getMessage();
        $responseStatus  = $response->getStatus();

        if($responseStatus == '200') {
            // SUCESSO
            $retorno['status']  = "sucesso";
            $retorno['retorno'] = $response;
            $retorno['recurrentPaymentId'] = $recurrentPaymentId;
        }else{
            // ERRO
            $retorno['status']      = "erro";
            $retorno['retorno']     = $response;
            $retorno['recurrentPaymentId'] = $recurrentPaymentId;
            $retorno['msgTitulo']   = "Problema ao cancelar a cobrança recorrente. Entre em contato conosco.";
            $retorno['msgMensagem'] = $responseMessage . " (".$responseStatus.")";
        }

        // Return
        return $retorno;
    }

    /**
     * Reativar um pagamento recorrente
     */
    public function reactivateRecurrent() {
        // Inicia resposta
        $retorno = array();

        if(!$this->_assinatura) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Assinatura não encontrada.";
            return $retorno;
        }

        // Objeto retornado da Cielo no pagamento recorrente
        $recurrentPaymentId = $this->_assinatura->cobranca_recorrente ? $this->_assinatura->code_assinatura : '';

        if(empty($recurrentPaymentId)) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Recorrência não encontrada.";
            return $retorno;
        }

        $url = $this->environment->getApiURL().'1'.'/RecurrentPayment/'.$recurrentPaymentId.'/Reactivate';

        $headers = array(
            'Content-Type' => 'application/json','Accept-Encoding: gzip',
            'User-Agent: CieloEcommerce/3.0 PHP SDK',
            'MerchantId' => $this->gateway_merchantId,
            'MerchantKey' => $this->gateway_merchantKey,
            'RequestId: ' . uniqid()
        );

        $streamOpts = array(
            'ssl' => array(
                'verify_peer' => false,
                'allow_self_signed' => true
            )
        );

        $client = new Zend_Http_Client();
        $client->setUri($url);
        $client->setHeaders($headers);
        $adapter = new Zend_Http_Client_Adapter_Socket();
        $client->setAdapter($adapter);
        $adapter->setStreamContext($streamOpts);

		// Faz a requisição
		$response        = $client->request("PUT");
		$responseBody    = $response->getBody();
		$responseMessage = $response->getMessage();
        $responseStatus  = $response->getStatus();

        if($responseStatus == '200') {
            // SUCESSO
            $retorno['status']  = "sucesso";
            $retorno['retorno'] = $response;
            $retorno['recurrentPaymentId'] = $recurrentPaymentId;
        }else{
            // ERRO
            $retorno['status']      = "erro";
            $retorno['retorno']     = $response;
            $retorno['recurrentPaymentId'] = $recurrentPaymentId;
            $retorno['msgTitulo']   = "Problema ao reativar a cobrança recorrente. Entre em contato conosco";
            $retorno['msgMensagem'] = $responseMessage . " (".$responseStatus.")";
        }

        // Return
        return $retorno;
    }

    /**
     * Alterar cartão de pagamento recorrente
     */
    public function alterCardRecurrent() {
        // Inicia resposta
        $retorno = array();

        if(!$this->_assinatura) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Assinatura não encontrada.";
            return $retorno;
        }

        // Objeto retornado da Cielo no pagamento recorrente
        $recurrentPaymentId = $this->_assinatura->cobranca_recorrente ? $this->_assinatura->code_assinatura : '';

        if(empty($recurrentPaymentId)) {
            // ERRO
            $retorno['status']  = "erro";
            $retorno['retorno'] = "Recorrência não encontrada.";
            return $retorno;
        }

        // Parâmetros pagamento
        $cc_token           = $this->_arrPagto['card_token'];
        $cc_name            = $this->_arrPagto['card_nome'];
        $cc_number          = $this->_arrPagto['card_numero'];
        $cc_validade        = $this->_arrPagto['card_validade'];
        $cc_brand           = $this->_arrPagto['card_bandeira'];
        $cc_security_code   = "";
        $parcelas           = 1;
        $valortotal         = str_replace('.', '', $this->_assinatura->valor_plano);

        // Result
        $retorno = array();

        // Somente número do cartão
        $somenteNumCartao = preg_replace('/[^0-9]/', '', $cc_number);

        // Validade cartão
        $vencimento_arr = explode("/", $cc_validade);
        if(count($vencimento_arr) > 0) {
            $mesCartao = $vencimento_arr[0];
            $anoCartao = '20' . $vencimento_arr[1];
        }

        $url = $this->environment->getApiURL().'1'.'/RecurrentPayment/'.$recurrentPaymentId.'/Payment';

        $headers = array(
            'Content-Type' => 'application/json','Accept-Encoding: gzip',
            'User-Agent: CieloEcommerce/3.0 PHP SDK',
            'MerchantId' => $this->gateway_merchantId,
            'MerchantKey' => $this->gateway_merchantKey,
            'RequestId: ' . uniqid()
        );

        $streamOpts = array(
            'ssl' => array(
                'verify_peer' => false,
                'allow_self_signed' => true
            )
        );

        $client = new Zend_Http_Client();
        $client->setUri($url);
        $client->setHeaders($headers);
        $adapter = new Zend_Http_Client_Adapter_Socket();
        $client->setAdapter($adapter);
        $adapter->setStreamContext($streamOpts);

        // Dados da requisição PUT
        $data_put = array(
            "Type"           => "CreditCard",
            "Amount"         => $valortotal,
            "Installments"   => $parcelas,
            "Country"        => "BRA",
            "Currency"       => "BRL",
            "CreditCard"     => array('')
        );

        // Dados cartão
        $data_put['CreditCard'] = array(
            "Brand"          => $this->varBrand($cc_brand),
            "Holder"         => $cc_name,
            "CardNumber"     => $somenteNumCartao,
            "ExpirationDate" => $mesCartao."/".$anoCartao
        );

        $jsonRequest = json_encode($data_put);

		// Faz a requisição
		$response        = $client->setRawData($jsonRequest, 'application/json')->request("PUT");
		$responseBody    = $response->getBody();
		$responseMessage = $response->getMessage();
        $responseStatus  = $response->getStatus();

        if($responseStatus == '200') {
            // SUCESSO
            $retorno['status']  = "sucesso";
            $retorno['data']    = date("Y-m-d H:i:s");
            $retorno['retorno'] = json_encode(json_decode($responseBody));
            $retorno['recurrentPaymentId'] = $recurrentPaymentId;
        }else{
            // ERRO
            $retorno['status']      = "erro";
            $retorno['data']        = date("Y-m-d H:i:s");
            $retorno['put']         = $jsonRequest;
            $retorno['retorno']     = json_encode(json_decode($responseBody));
            $retorno['recurrentPaymentId'] = $recurrentPaymentId;
            $retorno['msgTitulo']   = "Problema ao alterar cartão de cobrança recorrente. Entre em contato conosco";
            $retorno['msgMensagem'] = $responseMessage . " (".$responseStatus.")";
        }

        // Return
        return $retorno;
    }

    /**
     * Retorna a função creditCard::brand Cielo
     *
     * @param string $brand
     *
     * @return string
     */
    public function varBrand($brand='') {
        $funcaoBrand = '';
        switch (mb_strtoupper($brand)) {
            case "VISA": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::VISA;
                break;
            case "MASTERCARD":
            case "MASTER": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::MASTER;
                break;
            case "AMEX": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::AMEX;
                break;
            case "ELO": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::ELO;
                break;
            case "AURA": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::AURA;
                break;
            case "JCB": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::JCB;
                break;
            case "DINERS": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::DINERS;
                break;
            case "DISCOVER": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::DISCOVER;
                break;
            case "HIPERCARD": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::HIPERCARD;
                break;
            case "HIPER": $funcaoBrand = \Cielo\API30\Ecommerce\CreditCard::HIPER;
                break;
            default: $funcaoBrand = "n/a";
                break;
        }

        return $funcaoBrand;
    }

    /**
     * Erros do 'returnCode'
     */
    public function getErroCode() {
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
     * Erros do 'status'
     */
    public function getErroStatus($SaleStatus=null) {
        // Array status
        $arrStatus = array(
            0 => "Aguardando atualização de status.", // NotFinished
            1 => "Pagamento apto a ser capturado ou definido como pago.", // Authorized
            2 => "Pagamento confirmado e finalizado.", // PaymentConfirmed
            3 => "Pagamento negado por Autorizador.", // Denied
            10 => "Pagamento cancelado.", // Voided
            11 => "Pagamento cancelado após 23:59 do dia de autorização.", // Refunded
            12 => "Aguardando Status de instituição financeira.", // Pending
            13 => "Pagamento cancelado por falha no processamento ou por ação do AF.", // Aborted
            20 => "Recorrência agendada.", // Scheduled
        );

        // Retorno
        return $arrStatus[$SaleStatus];

        //        CÓDIGO	STATUS	MEIO DE PAGAMENTO	DESCRIÇÃO
        //        0	NotFinished	ALL	Aguardando atualização de status
        //        1	Authorized	ALL	Pagamento apto a ser capturado ou definido como pago
        //        2	PaymentConfirmed	ALL	Pagamento confirmado e finalizado
        //        3	Denied	CC + CD + TF	Pagamento negado por Autorizador
        //        10	Voided	ALL	Pagamento cancelado
        //        11	Refunded	CC + CD	Pagamento cancelado após 23:59 do dia de autorização
        //        12	Pending	ALL	Aguardando Status de instituição financeira
        //        13	Aborted	ALL	Pagamento cancelado por falha no processamento ou por ação do AF
        //        20	Scheduled	CC	Recorrência agendada
    }

    // EXEMPLO RETORNO DA CIELO
//    {
//    "retorno" :
//        {
//        "MerchantOrderId" : "20",
//        "Installments" : 1,
//        "Capture" : FALSE,
//        "Type" : "CreditCard",
//        "Amount" : 2900,
//        "CapturedAmount" : NULL,
//        "AuthorizationCode" : NULL,
//        "PaymentId" : "1e000efb-2a57-4f13-af3b-d3e67c9c942e",
//        "Tid" : "0511035209531",
//        "SaleStatus" : 3,
//        "SaleReturnCode" : "05",
//        "SaleReturnMessage" : "Not Authorized",
//        "CaptureStatus" : NULL,
//        "CaptureReturnCode" : NULL,
//        "CaptureReturnMessage" : NULL,
//        "RecurrentPaymentId" : NULL,
//        "PaymentArray" :
//                {
//                "serviceTaxAmount" : 0,
//                "installments" : 1,
//                "interest" : 0,
//                "capture" : FALSE,
//                "authenticate" : FALSE,
//                "recurrent" : FALSE,
//                "recurrentPayment" :
//                            {
//                            "authorizeNow" : TRUE,
//                            "recurrentPaymentId" : NULL,
//                            "nextRecurrency" : NULL,
//                            "startDate" : NULL,
//                            "endDate" : NULL,
//                            "interval" : 1,
//                            "amount" : NULL,
//                            "country" : NULL,
//                            "createDate" : NULL,
//                            "currency" : NULL,
//                            "currentRecurrencyTry" : NULL,
//                            "provider" : NULL,
//                            "recurrencyDay" : NULL,
//                            "successfulRecurrences" : NULL,
//                            "links" :[],
//                            "recurrentTransactions" :[],
//                            "reasonCode" : 7,
//                            "reasonMessage" : "Denied",
//                            "status" : NULL
//                            },
//                "creditCard" :
//                            {
//                            "cardNumber" : NULL,
//                            "holder" : NULL,
//                            "expirationDate" : NULL,
//                            "securityCode" : NULL,
//                            "saveCard" : FALSE,
//                            "brand" : "Master",
//                            "cardToken" : "6277dc4e-e30b-4775-9c3c-e1c01432790a",
//                            "customerName" : NULL,
//                            "links" :{}
//                            },
//                "debitCard" : NULL,
//                "authenticationUrl" : NULL,
//                "tid" : "0511035209531",
//                "proofOfSale" : NULL,
//                "authorizationCode" : NULL,
//                "softDescriptor" : "",
//                "returnUrl" : NULL,
//                "provider" : "Simulado",
//                "paymentId" : "1e000efb-2a57-4f13-af3b-d3e67c9c942e",
//                "type" : "CreditCard",
//                "amount" : 2900,
//                "receivedDate" : "2022-05-11 15:52:09",
//                "capturedAmount" : NULL,
//                "capturedDate" : NULL,
//                "voidedAmount" : NULL,
//                "voidedDate" : NULL,
//                "currency" : "BRL",
//                "country" : "BRA",
//                "returnCode" : "05",
//                "returnMessage" : "Not Authorized",
//                "status" : 3,
//                "links" :[{ "Method" : "GET",
//                "Rel" : "self",
//                "Href" : "https:\/\/apiquerysandbox.cieloecommerce.cielo.com.br\/1\/sales\/1e000efb-2a57-4f13-af3b-d3e67c9c942e" }],
//                "extraDataCollection" : NULL,
//                "expirationDate" : NULL,
//                "url" : NULL,
//                "number" : NULL,
//                "boletoNumber" : NULL,
//                "barCodeNumber" : NULL,
//                "digitableLine" : NULL,
//                "address" : NULL,
//                "assignor" : NULL,
//                "demonstrative" : NULL,
//                "identification" : NULL,
//                "instructions" : NULL
//                }
//        },
//        "idcartao" : "7239",
//        "recorrente" : "1",
//        "status" : "erro",
//        "msgTitulo" : "Pagamento n\u00e3o realizado.",
//        "msgMensagem" : "Pagamento negado por Autorizador."
//    }
}