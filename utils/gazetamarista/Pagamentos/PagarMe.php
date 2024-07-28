<?php
/**
 * Classe de pagamentos por pagSeguro
 *
 * @name gazetamarista_Pagamentos_Pagseguro
 */
class gazetamarista_Pagamentos_PagarMe extends gazetamarista_Pagamentos_Abstract {

	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "pagarme";

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
		$this->sanitize = new gazetamarista_Sanitize();

        // Chama a biblioteca do Pagar.me
        require_once(APPLICATION_PATH."/../library/gazetamarista/Library/PagarMe/vendor/autoload.php");

        $pagarMe = new \PagarMe\Sdk\PagarMe('ak_test_ju7VxE7EDzOd6ozlOwkk05slFLO34Z');

        $amount = 1000;
        $postbackUrl = 'https://localhost/medclass.org.br/painel/pagamento';
        $metadata = ['idProduto' => 13933139];

        $customer = new \PagarMe\Sdk\Customer\Customer([
                'name' => 'John Dove',
                'email' => 'john@site.com',
                'document_number' => '09130141095',
                'documentType' => 'cpf',
                'Type' => 'individual',
                'address' => [
                    'street'        => 'rua teste',
                    'street_number' => 42,
                    'neighborhood'  => 'centro',
                    'zipcode'       => '01227200',
                    'complementary' => 'Apto 42',
                    'city'          => 'São Paulo',
                    'state'         => 'SP',
                    'country'       => 'Brasil'
                ],
                'phone' => [
                    'ddd'    => "15",
                    'number' =>"987523421"
                ],
                'born_at' => '15021994',
                'sex' => 'M'
            ]
        );


        $transaction2 = $pagarMe->transaction()->boletoTransaction(
            $amount,
            $customer,
            $postbackUrl,
            $metadata
        );


        print_r($transaction);
        die();


	}


    public function TesteAssinatura($parametros = ''){

    }




    /**
     *
     * Envia Requisição para criar a ASSINATURA (TODA ASSINATURA DEVE FAZER PARTE DE UM PLANO DE ASSINATURAS)
     *
     * O retorno do método register, por padrão, será um objeto com a resposta da requisição
     *
     */
    public function enviarAssinatura($parametros = ''){
        // Adiciona o model
        $model_clientes = new Admin_Model_Clientes();
        $model_planos = new Admin_Model_Planos();
        $model_assinaturas = new Admin_Model_Assinaturas();
        $model_pagtos = new Admin_Model_Pagtos();
        $model_cupons = new Admin_Model_Cupons();

        if (!empty($parametros['metodopagamento'])) {

            // Tipo de pagamento cartão de crédito
            if ($parametros['metodopagamento'] == 'credit_card') {

                // Parâmetros cartão de crédito
                $cc_name = $parametros['cc-name'];
                $cc_number = $parametros['cc-number'];
                $cc_exp = $parametros['cc-exp'];
                $cc_cvc = $parametros['cc-cvc'];
                $parcelas = $parametros['parcelas'];
                $parcelas_sem_juros = 0;
                $parcelas = 0;
                $card_token = $parametros['card_token'];
                $final_cartao = substr(trim($cc_number), -4);
                $imagem_icon = $parametros['imgicon'];
                $bandeira = ucfirst($parametros['bandeira']);
                $metodo_pagamento = 'Cartão ' . $bandeira;
                $documento = $parametros['documento'];

                // Outros Parametros
                $sender_hash = $parametros['sender_hash'];
                $quantidade = "1";
                $tipodocumento = "CPF";
                $cupom_desconto = $parametros['cupom_desconto'];

                if (!empty($sender_hash)) {
                    $parse_telefone = explode(' ', $this->_cliente->telefone);
                    if (count($parse_telefone) > 0) {
                        $ddd_pagamento = str_replace(")", "", str_replace("(", "", $parse_telefone[0]));
                        $telefone_pagamento = str_replace("-", "", $parse_telefone[1]);
                    } else {
                        $ddd_pagamento = "";
                        $telefone_pagamento = $this->_cliente->telefone;
                    }

                    // Dados do pagamento
                    $nome_pagamento = $cc_name;
                    $nascimento_pagamento = date_format(date_create($parametros['data_nascimento']), "d/m/Y");
                    $sexo_pagamento = "";
                    $email_pagamento = $this->_assinatura->email_pagamento;
                    $endereco_pagamento = $this->_assinatura->endereco_pagamento;
                    $numero_pagamento = $this->_assinatura->numero_pagamento;
                    $complemento_pagamento = $this->_assinatura->complemento_pagamento;
                    $bairro_pagamento = $this->_assinatura->bairro_pagamento;
                    $cep_pagamento = $this->_assinatura->cep_pagamento;
                    $cidade_pagamento = $this->_assinatura->cidade_pagamento;
                    $estado_pagamento = $this->_assinatura->estado_pagamento;
                    $CPF = str_replace(array(".", "-"), "", $documento);
                    $cpf_pagamento = $CPF;
                    $valor_total_final = $this->_assinatura->valor_plano;

                    if (getenv('APPLICATION_ENV') != "production") {
                        // *********************************************************************************
                        // ** Ambiente de teste Pagseguro, e-mail deve ser @sandbox.pagseguro.com.br *******
                        // $email_pagamento = "gazetamarista@sandbox.pagseguro.com.br";
                        $explode_configemails[0] = "henrique.carlos@gazetamarista.com.br";
                        $email_pagamento = "c09564454053279162710@sandbox.pagseguro.com.br"; // Comprador Teste, disponível no painel do sandbox do pagseguro
                        // *********************************************************************************
                    }

                    // Busca Dados do PLANO (Validade do Plano)
                    $select = $model_planos->select()->where("idplano = ?", $this->_assinatura->idplano);
                    $DadosPlano = $model_planos->fetchRow($select)->toArray();
                    $Validade_plano = $DadosPlano["validade_meses"];

                    // Definindo a Validade do Plano (Periodicidade de Cobrança)
                    if ($Validade_plano === "1") {
                        $PeriodicidadePlano = "Monthly";
                    } else if ($Validade_plano === "2") {
                        $PeriodicidadePlano = "Bimonthly";
                    } else if ($Validade_plano === "3") {
                        $PeriodicidadePlano = "Trimonthly";
                    } else if ($Validade_plano === "6") {
                        $PeriodicidadePlano = "Semiannually";
                    } else if ($Validade_plano === "12") {
                        $PeriodicidadePlano = "Yearly";
                    }


                    // Caso tenha CUPOM DE DESCONTO
                    if ($cupom_desconto) {
                        $vlr_desconto = 0.00;
                        $Hoje = date('Y-m-d', strtotime('today'));
                        // Busca Dados do CUPOM
                        $selectDesconto = $model_cupons
                            ->select()
                            ->where("cod_cupom = ?", $cupom_desconto)
                            ->where("validade_inicio <= ?",  $Hoje)
                            ->where("validade_final >= ?",  $Hoje);;

                        $DadosDesconto = $model_cupons->fetchRow($selectDesconto);
                        if($DadosDesconto){
                            $DadosDesconto = $DadosDesconto->toArray();
                            $ValidaDesconto = TRUE;

                            $QtdDesconto = $DadosDesconto["desconto"];
                            $TipoDesconto = $DadosDesconto["tipo_cupom"];

                            if ($TipoDesconto == "Porcentagem") {
                                $vlr_desconto = ($QtdDesconto * $this->_assinatura->valor_plano) / 100;
                                $valor_total_final = ($this->_assinatura->valor_plano - $vlr_desconto);
                            } else {
                                $vlr_desconto = $QtdDesconto;
                                $valor_total_final = $this->_assinatura->valor_plano;
                            }

                        }else{
                            // Erro - Cupom não encontrado
                            $retorno = array(
                                'status' => "erro",
                                'retorno' => "Cupom de Desconto Inválido."
                            );

                            $ValidaDesconto = FALSE;
                        }
                    }else{
                        $ValidaDesconto = TRUE;
                    }

                    //Verificação se está tudo certo com o CUPOM DE DESCONTO
                    if($ValidaDesconto){
                        // Variável que recebe o código da assinatura de pagamento recorrente
                        $preApprovalCode = null;

                        // Recupera os PLANOS DE ASSINATURAS já criadas por pagamento recorrente
                        $model_pagseguroassinaturas = new Admin_Model_Pagseguroassinaturas();

                        // Percorre os PLANOS DE ASSINATURAS do pagseguro cadastradas
                        if ($TipoDesconto == 'Período de dias FREE') {
                            //Busca pelo valor e pela quantidade de dias de trial
                            $select_pagseguroassinaturas =
                                $model_pagseguroassinaturas
                                    ->select()
                                    ->where("valor = ?", number_format($valor_total_final, 2, ".", ""))
                                    ->where("desconto_dias = ?", $vlr_desconto);
                        } else {
                            //Busca pelo valor do plano
                            $select_pagseguroassinaturas = $model_pagseguroassinaturas
                                ->select()
                                ->where("valor = ?", number_format($valor_total_final, 2, ".", ""))
                                ->where("desconto_dias IS NULL");
                        }

                        // Fetch all
                        $assinatura_pagseguro = $model_pagseguroassinaturas->fetchRow($select_pagseguroassinaturas);

                        // Se não existe um PLANO DE ASSINATURA criada, cria um novo
                        if (!$assinatura_pagseguro) {

                            /****************************
                             * Pre Approval information (PLANO DE ASSINATURAS) *
                             ****************************/
                            $preApprovalRequest = new \PagSeguro\Domains\Requests\DirectPreApproval\Plan();

                            // Adicionando item na requisição de pagamento
                            $AssinaturaId = $this->_assinatura->idassinatura;
                            $TituloPlano = $this->_assinatura->titulo_plano;
                            $QtdPlano = $quantidade;
                            $PeridiocidadePlano = $this->planos;

                            // Definindo a Validade do Plano (Periodicidade de Cobrança)
                            if ($Validade_plano === "1") {
                                $PeriodicidadePlano = "Monthly";
                            } else if ($Validade_plano === "2") {
                                $PeriodicidadePlano = "Bimonthly";
                            } else if ($Validade_plano === "3") {
                                $PeriodicidadePlano = "Trimonthly";
                            } else if ($Validade_plano === "6") {
                                $PeriodicidadePlano = "Semiannually";
                            } else if ($Validade_plano === "12") {
                                $PeriodicidadePlano = "Yearly";
                            }

                            //Caso tenha Cupom de Desconto e seja TRIAL, Adiciona ao plano a quantidade de dias
                            if ($TipoDesconto == 'Período de dias FREE') {
                                $preApprovalRequest->setPreApproval()->setTrialPeriodDuration(intval($vlr_desconto));
                            }

                            if ($valor_total_final == '799.00') {
                                $preApprovalRequest->setPreApproval()->setExpiration()->withParameters(12, 'MONTHS');
                            }

                            // Referenciando a transação do PagSeguro
                            $preApprovalRequest->setReference("REF" . strtotime('today'));
                            $preApprovalRequest->setPreApproval()->setCharge('auto');
                            $preApprovalRequest->setPreApproval()->setName($TituloPlano . " MEDCLASS");
                            $preApprovalRequest->setPreApproval()->setAmountPerPayment(number_format($valor_total_final, 2, ".", ""));
                            $preApprovalRequest->setPreApproval()->setPeriod($PeriodicidadePlano);

                            // Requisição no sistema do PagSeguro.
                            // O retorno do método register, por padrão, será um objeto com a resposta da requisição
                            try {
                                // Requisição ao pagSeguro
                                $response = $preApprovalRequest->register($this->credentials);
                                $serialize_response = serialize($response);

                                if ($response == 'Unauthorized') {
                                    // Erro
                                    $retorno = array('status' => "erro", 'retorno' => $serialize_response);
                                } else {
                                    $preApprovalCode = $response->code;

                                    // Insere as informações no banco
                                    if ($TipoDesconto != "Período de dias FREE") {
                                        $model_pagseguroassinaturas->insert(array(
                                            'code' => $response->code,
                                            'periodicidade' => $PeriodicidadePlano,
                                            'referencia' => "REF" . strtotime('today'),
                                            'valor' => number_format($valor_total_final, 2, ".", "")
                                        ));
                                    } else {
                                        //Caso tenha TRIAL adiciona o valor em dias.
                                        $model_pagseguroassinaturas->insert(array(
                                            'code' => $response->code,
                                            'desconto_dias' => $vlr_desconto,
                                            'periodicidade' => $PeriodicidadePlano,
                                            'referencia' => "REF" . strtotime('today'),
                                            'valor' => number_format($valor_total_final, 2, ".", "")
                                        ));
                                    }
                                }
                            } catch (PagSeguroServiceException $e) {
                                // Erro
                                $retorno = array(
                                    'status' => "erro",
                                    'retorno' => $e->getMessage()
                                );
                            }
                        } else {
                            //Caso possua um PLANO com essas informações - Busca o CÓDIGO
                            $preApprovalCode = $assinatura_pagseguro['code'];
                        }




                        // Se existe o PLANO DE ASSINATURAS
                        if ($preApprovalCode != '') {
                            // Criamos a Assinatura e inserimos no plano.

                            //Arquivo para LOG
                            \PagSeguro\Configuration\Configure::setLog(true, '/var/www/git/pagseguro/pagseguro-php-sdk/Log.log');

                            //Setamos uma nova Assinatura e incluímos no plano
                            $Pagamento = new \PagSeguro\Domains\Requests\DirectPreApproval\Accession();
                            $Pagamento->setPlan($preApprovalCode);
                            $Pagamento->setReference('REF ' . $this->_assinatura->idassinatura);

                            //Dados do Comprador
                            $Pagamento->setSender()->setName($nome_pagamento);
                            $Pagamento->setSender()->setEmail($email_pagamento);
                            $Pagamento->setSender()->setHash($sender_hash);
                            $Pagamento->setSender()->setIp($ip);
                            $documento = new \PagSeguro\Domains\DirectPreApproval\Document(); //Dados do Documento - CPF
                            $documento->withParameters('CPF', $CPF); //Dados do Documento - CPF
                            $Pagamento->setSender()->setPhone()->withParameters($ddd_pagamento, $telefone_pagamento);
                            $Pagamento->setSender()->setDocuments($documento);
                            // Endereço do Comprador (Seguindo ordem -  $street, $number, $district, $postalCode, $city, $state, $country)
                            $Pagamento->setSender()->setAddress()->withParameters($endereco_pagamento, $numero_pagamento, $bairro_pagamento, $cep_pagamento, $cidade_pagamento, $estado_pagamento, 'BRA');

                            //Dados de Pagamento
                            $Pagamento->setPaymentMethod()->setCreditCard()->setToken($card_token);
                            $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setName($nome_pagamento);
                            $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setBirthDate($nascimento_pagamento);
                            $document = new \PagSeguro\Domains\DirectPreApproval\Document(); //Dados do Documento - CPF
                            $document->withParameters('CPF', $CPF); //Dados do Documento - CPF
                            $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setDocuments($document);
                            $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setPhone()->withParameters($ddd_pagamento, $telefone_pagamento);
                            // Endereço de Cobrança.
                            $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setBillingAddress()->withParameters($endereco_pagamento, $numero_pagamento, $bairro_pagamento, $cep_pagamento, $cidade_pagamento, $estado_pagamento, 'BRA');

                            try {
                                // Requisição ao pagSeguro
                                $response = $Pagamento->register($this->credentials);

                                //Retorna CODIGO DA ASSINATURA
                                $code_assinatura = $response->code;

                                if ($response == 'Unauthorized') {
                                    // Erro
                                    $retorno = array(
                                        'status' => "erro",
                                        'payment' => json_encode($directpaymentRequest),
                                        'response' => $response,
                                        'retorno' => $serialize_response
                                    );

                                    $txt_status = "Erro pagamento";
                                } else {
                                    //Buscamos informações da assinatura
                                    $queryPreApproval = new \PagSeguro\Domains\Requests\DirectPreApproval\QueryPaymentOrder($code_assinatura);

                                    try {
                                        $response = $queryPreApproval->register($this->credentials);

                                        // Sucesso
                                        $data_transacao = $response->date;
                                        $data_ultimo_evento = $response->paymentOrders->lastEventDate;
                                        $code_transacao = $response->paymentOrders->code;
                                        $dataPagamento = $response->paymentOrders->schedulingDate;
                                        $status = $response->paymentOrders->status;
                                        $ValorTotal = $response->paymentOrders->amount;

                                        $OrdemPagamento = $response->paymentOrders;
                                        $Code_pagamento = 0;


                                        foreach ($OrdemPagamento as $Ordem) {

                                            if ($TipoDesconto != "Período de dias FREE") {

                                                if ($Ordem->status == 2) { // Pagamento está sendo PROCESSADO
                                                    $Code_pagamento = $Ordem->transactions[0]->code;
                                                    // Pagto Ok
                                                    $transaction = array(
                                                        'data_transacao' => $Ordem->transactions[0]->date,
                                                        'data_ultimo_evento' => $Ordem->lastEventDate,
                                                        'code_transacao' => $Ordem->transactions[0]->code,
                                                        'type' => $Ordem->transactions[0]->date,
                                                        'status' => $Ordem->transactions[0]->status,
                                                        'reference' => $Ordem->amount,
                                                        'valorpago' => $Ordem->grossAmount,
                                                        'periodicidade' => $PeriodicidadePlano
                                                    );


                                                    // Verifica se retornou corretamente
                                                    if (!empty($transaction['reference'])) {
                                                        // Verifica o id do status no banco de dados
                                                        switch ($transaction['status']) {
                                                            // Pagseguro - Aguardando pagamento
                                                            case 1:
                                                                $txt_status = "Em andamento";
                                                                $status_assinatura = "Pendente";
                                                                break;
                                                            // Pagseguro - Paga, Pagseguro - Disponível
                                                            case 3:
                                                            case 4:
                                                                $txt_status = "Aprovado";
                                                                $status_assinatura = "Ativo";
                                                                break;
                                                            // Pagseguro - Em análise, Pagseguro - Em disputa, Pagseguro - Em contestação
                                                            case 2:
                                                            case 5:
                                                            case 9:
                                                                $txt_status = "Análise em andamento";
                                                                $status_assinatura = "Pendente";
                                                                break;
                                                            // Pagseguro - Devolvida, Pagseguro - Cancelada, Pagseguro - Chargeback debitado
                                                            case 6:
                                                            case 7:
                                                            case 8:
                                                                $txt_status = "Cancelado";
                                                                $status_assinatura = "Inativo";
                                                                break;
                                                            default:
                                                                $txt_status = "Em andamento";
                                                                $status_assinatura = "Pendente";
                                                                break;
                                                        }

                                                        // Monta array do pagto com dados principais
                                                        $pagto = array(
                                                            'idassinatura' => $this->_idassinatura,
                                                            'transaction' => $transaction,
                                                            'status' => $txt_status
                                                        );

                                                        // Sucesso
                                                        $retorno = array(
                                                            'status' => "sucesso",
                                                            'pagto' => $pagto,
                                                            'finalcard' => $final_cartao,
                                                            'bandeira' => $bandeira,
                                                            'imgbandeira' => $imagem_icon,
                                                            'retorno' => $serialize_response
                                                        );
                                                    }
                                                }
                                            } else {
                                                //$Code_pagamento = $Ordem->transactions[0]->code;
                                                // Pagto Ok
                                                $transaction = array(
                                                    'data_transacao' => $Ordem->transactions[0]->date,
                                                    'data_ultimo_evento' => $Ordem->lastEventDate,
                                                    'data_agendamento' => $Ordem->schedulingDate,
                                                    'status' => $Ordem->status,
                                                    'reference' => $Ordem->amount,
                                                    'valorpago' => $Ordem->grossAmount,
                                                    'periodicidade' => $PeriodicidadePlano
                                                );

                                                // Verifica o id do status no banco de dados
                                                switch ($transaction['status']) {
                                                    // Pagseguro - Aguardando pagamento
                                                    case 1:
                                                        $txt_status = "Agendado";
                                                        $status_assinatura = "Ativo";
                                                        break;
                                                    // Pagseguro - Paga, Pagseguro - Disponível
                                                    case 3:
                                                    case 4:
                                                        $txt_status = "Aprovado";
                                                        $status_assinatura = "Ativo";
                                                        break;
                                                    // Pagseguro - Em análise, Pagseguro - Em disputa, Pagseguro - Em contestação
                                                    case 2:
                                                    case 5:
                                                    case 9:
                                                        $txt_status = "Análise em andamento";
                                                        $status_assinatura = "Pendente";
                                                        break;
                                                    // Pagseguro - Devolvida, Pagseguro - Cancelada, Pagseguro - Chargeback debitado
                                                    case 6:
                                                    case 7:
                                                    case 8:
                                                        $txt_status = "Cancelado";
                                                        $status_assinatura = "Inativo";
                                                        break;
                                                    default:
                                                        $txt_status = "Em andamento";
                                                        $status_assinatura = "Pendente";
                                                        break;
                                                }

                                                // Monta array do pagto com dados principais
                                                $pagto = array(
                                                    'idassinatura' => $this->_idassinatura,
                                                    'cupom_desconto' => $cupom_desconto,
                                                    'transaction' => $transaction,
                                                    'status' => $txt_status
                                                );

                                                // Sucesso
                                                $retorno = array(
                                                    'status' => "sucesso",
                                                    'pagto' => $pagto,
                                                    'finalcard' => $final_cartao,
                                                    'bandeira' => $bandeira,
                                                    'imgbandeira' => $imagem_icon,
                                                    'retorno' => $serialize_response
                                                );

                                            }
                                        }

                                    } catch (Exception $e) {
                                        die($e->getMessage());
                                    }
                                }
                            } catch (Exception $e) {
                                // Erro
                                $retorno = array(
                                    'status' => "erro",
                                    'retorno' => $e->getMessage()
                                );
                            }
                        }
                    } else {
                        // Erro
                        $retorno = array(
                            'status' => "erro",
                            'retorno' => "Cupom de Desconto Inválido"
                        );
                    }
                } else {
                    // Erro
                    $retorno = array(
                        'status' => "erro",
                        'retorno' => "Sender Hash não enviado para transação"
                    );
                }
            } else {
                // Erro
                $retorno = array(
                    'status' => "erro",
                    'retorno' => "Tipo de pagamento inválido, tente novamente o processo de pagamento"
                );
            }
        } else {
            // Erro
            $retorno = array(
                'status' => "erro",
                'retorno' => "Metodo de pagamento inválido, tente novamente o processo de pagamento"
            );
        }

        // Insere pagto
        $arr_pagto['idassinatura'] = $this->_idassinatura;
        $arr_pagto['valor_pago'] = $valor_total_final;
        $arr_pagto['parcelas'] = $parcelas;
        $arr_pagto['code_transacao'] = $transaction['code_transacao'];
        $arr_pagto['forma_pagto'] = $forma_pagamento;
        $arr_pagto['status_pagto'] = $txt_status;
        $arr_pagto['observacao'] = "Execução pagSeguro";
        $arr_pagto['meta_dados'] = json_encode($retorno);
        $arr_pagto['data_execucao'] = date("Y-m-d H:i:s");
        $arr_pagto['identificacao'] = 'pagseguro - enviar transação';

        // Insert
        $model_pagtos->insert($arr_pagto);

        // Atualiza a assinatura com o valorpago e status atual
        $model_assinaturas->update(
            array("valorpago" => $valor_total_final, "status" => $status_assinatura, "code_assinatura" => $code_assinatura),
            array('idassinatura = ?' => $this->_idassinatura)
        );

        return $retorno;
    }








    /**
	 *
	 * Envia Requisição para criar a transação
	 *
	 * O retorno do método register, por padrão, será um objeto com a resposta da requisição
	 *
	 */
    public function enviarTransacao($parametros = ''){
        // Adiciona o model
        $model_clientes = new Admin_Model_Clientes();
        $model_planos = new Admin_Model_Planos();
        $model_assinaturas = new Admin_Model_Assinaturas();
        $model_pagtos = new Admin_Model_Pagtos();
        $model_cupons = new Admin_Model_Cupons();

        if (!empty($parametros['metodopagamento'])) {

            // Tipo de pagamento cartão de crédito
            if ($parametros['metodopagamento'] == 'credit_card') {

                // Parâmetros cartão de crédito
                $cc_name = $parametros['cc-name'];
                $cc_number = $parametros['cc-number'];
                $cc_exp = $parametros['cc-exp'];
                $cc_cvc = $parametros['cc-cvc'];
                $parcelas = $parametros['parcelas'];
                $parcelas_sem_juros = 0;
                $parcelas = 0;
                $card_token = $parametros['card_token'];
                $final_cartao = substr(trim($cc_number), -4);
                $imagem_icon = $parametros['imgicon'];
                $bandeira = ucfirst($parametros['bandeira']);
                $metodo_pagamento = 'Cartão ' . $bandeira;
                $documento = $parametros['documento'];

                // Parametros
                $sender_hash = $parametros['sender_hash'];
                $quantidade = "1";
                $tipodocumento = "CPF";
                $cupom_desconto = $parametros['cupom_desconto'];

                if (!empty($sender_hash)) {
                    $parse_telefone = explode(' ', $this->_cliente->telefone);
                    if (count($parse_telefone) > 0) {
                        $ddd_pagamento = str_replace(")", "", str_replace("(", "", $parse_telefone[0]));
                        $telefone_pagamento = str_replace("-", "", $parse_telefone[1]);
                    } else {
                        $ddd_pagamento = "";
                        $telefone_pagamento = $this->_cliente->telefone;
                    }

                    // Dados do pagamento
                    $nome_pagamento = $cc_name;
                    $nascimento_pagamento = date_format(date_create($parametros['data_nascimento']), "d/m/Y");
                    $sexo_pagamento = "";
                    $email_pagamento = $this->_assinatura->email_pagamento;
                    $endereco_pagamento = $this->_assinatura->endereco_pagamento;
                    $numero_pagamento = $this->_assinatura->numero_pagamento;
                    $complemento_pagamento = $this->_assinatura->complemento_pagamento;
                    $bairro_pagamento = $this->_assinatura->bairro_pagamento;
                    $cep_pagamento = $this->_assinatura->cep_pagamento;
                    $cidade_pagamento = $this->_assinatura->cidade_pagamento;
                    $estado_pagamento = $this->_assinatura->estado_pagamento;
                    $CPF = str_replace(array(".", "-"), "", $documento);
                    $cpf_pagamento = $CPF;
                    $valor_total_final = $this->_assinatura->valor_plano;

                    if (getenv('APPLICATION_ENV') != "production") {
                        // *********************************************************************************
                        // ** Ambiente de teste Pagseguro, e-mail deve ser @sandbox.pagseguro.com.br *******
                        // $email_pagamento = "gazetamarista@sandbox.pagseguro.com.br";
                        $explode_configemails[0] = "henrique.carlos@gazetamarista.com.br";
                        $email_pagamento = "c09564454053279162710@sandbox.pagseguro.com.br"; // Comprador Teste, disponível no painel do sandbox do pagseguro
                        // *********************************************************************************
                    }

                    // Busca Dados do PLANO (Validade do Plano)
                    $select = $model_planos->select()->where("idplano = ?", $this->_assinatura->idplano);
                    $DadosPlano = $model_planos->fetchRow($select)->toArray();
                    $Validade_plano = $DadosPlano["validade_meses"];

                    // Caso tenha CUPOM DE DESCONTO
                    if ($cupom_desconto) {
                        $vlr_desconto = 0.00;
                        $Hoje = date('Y-m-d', strtotime('today'));
                        // Busca Dados do CUPOM
                        $selectDesconto = $model_cupons
                            ->select()
                            ->where("cod_cupom = ?", $cupom_desconto)
                            ->where("validade_inicio >= ?",  $Hoje)
                            ->where("validade_final <= ?",  $Hoje);

                        $DadosDesconto = $model_cupons->fetchRow($selectDesconto)->toArray();
                        //if($DadosDesconto){
                            print_r($DadosDesconto);
                            die();
                        //}else{
                        //    print_r("Cupom de Desconto não encontrado.");
                        //    die();
                        //}

                        $QtdDesconto = $DadosDesconto["desconto"];
                        $TipoDesconto = $DadosDesconto["tipo_cupom"];

                        $row_cupom = $model_cupons->fetchRow(array('cupom = ?' => $desconto_cupom->nome));
                        if ($row_cupom) {
                            // Contabiliza a qtd e data de utilização
                            $data_upcupom = array();
                            $data_upcupom['qtd_utilizacao'] = $row_cupom->qtd_utilizacao + 1;
                            $model_cupons->update($data_upcupom, array('idcupom = ?' => $row_cupom->idcupom));
                        }



                        if ($TipoDesconto == "Porcentagem") {
                            $vlr_desconto = ($QtdDesconto * $this->_assinatura->valor_plano) / 100;
                            $valor_total_final = ($this->_assinatura->valor_plano - $vlr_desconto);
                        } else {
                            $vlr_desconto = $QtdDesconto;
                            $valor_total_final = $this->_assinatura->valor_plano;
                        }
                    }

                    // Variável que recebe o código da assinatura de pagamento recorrente
                    $preApprovalCode = null;

                    // Recupera os PLANOS DE ASSINATURAS já criadas por pagamento recorrente
                    $model_pagseguroassinaturas = new Admin_Model_Pagseguroassinaturas();

                    // Percorre os PLANOS DE ASSINATURAS do pagseguro cadastradas
                        if ($TipoDesconto == 'Período de dias FREE') {
                            //Busca pelo valor e pela quantidade de dias de trial
                            $select_pagseguroassinaturas =
                                $model_pagseguroassinaturas
                                    ->select()
                                    ->where("valor = ?", number_format($valor_total_final, 2, ".", ""))
                                    ->where("desconto_dias = ?", $vlr_desconto);
                        } else {
                            //Busca pelo valor do plano
                            $select_pagseguroassinaturas = $model_pagseguroassinaturas->select()->where("valor = ?", number_format($valor_total_final, 2, ".", ""));
                        }

                    // Fetch all
                    $assinatura_pagseguro = $model_pagseguroassinaturas->fetchRow($select_pagseguroassinaturas);


                    // Se não existe um PLANO DE ASSINATURA criada, cria uma nova por webservice
                    if (!$assinatura_pagseguro) {


                        /****************************
                         * Pre Approval information *
                         ****************************/

                        $preApprovalRequest = new \PagSeguro\Domains\Requests\DirectPreApproval\Plan();

                        // Adicionando item na requisição de pagamento
                        $AssinaturaId = $this->_assinatura->idassinatura;
                        $TituloPlano = $this->_assinatura->titulo_plano;
                        $QtdPlano = $quantidade;
                        $PeridiocidadePlano = $this->planos;

                        // Definindo a Validade do Plano (Periodicidade de Cobrança)
                        if ($Validade_plano === "1") {
                            $PeriodicidadePlano = "Monthly";
                        } else if ($Validade_plano === "2") {
                            $PeriodicidadePlano = "Bimonthly";
                        } else if ($Validade_plano === "3") {
                            $PeriodicidadePlano = "Trimonthly";
                        } else if ($Validade_plano === "6") {
                            $PeriodicidadePlano = "Semiannually";
                        } else if ($Validade_plano === "12") {
                            $PeriodicidadePlano = "Yearly";
                        }

                        //Caso tenha Cupom de Desconto e seja TRIAL, Adiciona ao plano a quantidade de dias
                        if ($TipoDesconto == 'Período de dias FREE') {
                            $preApprovalRequest->setPreApproval()->setTrialPeriodDuration(intval($vlr_desconto));
                        }

                        // Referenciando a transação do PagSeguro
                        $preApprovalRequest->setReference("REF" . strtotime('today'));
                        $preApprovalRequest->setPreApproval()->setCharge('auto');
                        $preApprovalRequest->setPreApproval()->setName($TituloPlano . " MEDCLASS");
                        $preApprovalRequest->setPreApproval()->setAmountPerPayment(number_format($valor_total_final, 2, ".", ""));
                        $preApprovalRequest->setPreApproval()->setPeriod($PeriodicidadePlano);

                        // Requisição no sistema do PagSeguro.
                        // O retorno do método register, por padrão, será um objeto com a resposta da requisição
                        try {
                            // Requisição ao pagSeguro
                            $response = $preApprovalRequest->register($this->credentials);
                            $serialize_response = serialize($response);


                            if ($response == 'Unauthorized') {
                                // Erro
                                $retorno = array('status' => "erro", 'retorno' => $serialize_response);
                            } else {
                                $preApprovalCode = $response->code;

                                // Insere as informações no banco
                                if ($TipoDesconto == "Porcentagem") {
                                    $model_pagseguroassinaturas->insert(array(
                                        'code' => $response->code,
                                        'periodicidade' => $PeriodicidadePlano,
                                        'referencia' => "REF" . strtotime('today'),
                                        'valor' => number_format($valor_total_final, 2, ".", "")
                                    ));
                                } else {
                                    $model_pagseguroassinaturas->insert(array(
                                        'code' => $response->code,
                                        'desconto_dias' => $vlr_desconto,
                                        'periodicidade' => $PeriodicidadePlano,
                                        'referencia' => "REF" . strtotime('today'),
                                        'valor' => number_format($valor_total_final, 2, ".", "")
                                    ));
                                }
                            }
                        } catch (PagSeguroServiceException $e) {
                            // Erro
                            $retorno = array(
                                'status' => "erro",
                                'retorno' => $e->getMessage() . " teste"
                            );
                        }

                    } else {
                        $preApprovalCode = $assinatura_pagseguro['code'];
                    }

                    // Se existe o codigo do plano de assinatura
                    if ($preApprovalCode != '') {

                        \PagSeguro\Configuration\Configure::setLog(true, '/var/www/git/pagseguro/pagseguro-php-sdk/Log.log');

                        $Pagamento = new \PagSeguro\Domains\Requests\DirectPreApproval\Accession();
                        $Pagamento->setPlan($preApprovalCode);
                        $Pagamento->setReference('REF ' . $this->_assinatura->idassinatura);

                        //Dados do Documento
                        $documento = new \PagSeguro\Domains\DirectPreApproval\Document();
                        $documento->withParameters('CPF', '07824622940'); //assinante

                        //Dados do Comprador
                        $Pagamento->setSender()->setName($nome_pagamento);
                        $Pagamento->setSender()->setEmail($email_pagamento);
                        $Pagamento->setSender()->setHash($sender_hash);
                        $Pagamento->setSender()->setIp($ip);
                        //$Pagamento->setSender()->setDocuments()->withParameters( 'CPF', '07824622940');
                        $Pagamento->setSender()->setPhone()->withParameters($ddd_pagamento, $telefone_pagamento);
                        $Pagamento->setSender()->setDocuments($documento);
                        // Endereço do Comprador (Seguindo ordem -  $street, $number, $district, $postalCode, $city, $state, $country)
                        $Pagamento->setSender()->setAddress()->withParameters($endereco_pagamento, $numero_pagamento, $bairro_pagamento, $cep_pagamento, $cidade_pagamento, $estado_pagamento, 'BRA');

                        //Dados de Pagamento
                        $Pagamento->setPaymentMethod()->setCreditCard()->setToken($card_token);
                        $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setName($nome_pagamento);
                        $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setBirthDate($nascimento_pagamento);
                        $document = new \PagSeguro\Domains\DirectPreApproval\Document();
                        $document->withParameters('CPF', '07824622940'); //cpf do titular do cartão de crédito
                        $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setDocuments($document);
                        $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setPhone()->withParameters($ddd_pagamento, $telefone_pagamento);
                        // Endereço de Cobrança.
                        $Pagamento->setPaymentMethod()->setCreditCard()->setHolder()->setBillingAddress()->withParameters($endereco_pagamento, $numero_pagamento, $bairro_pagamento, $cep_pagamento, $cidade_pagamento, $estado_pagamento, 'BRA');


                        try {
                            // Requisição ao pagSeguro
                            $response = $Pagamento->register($this->credentials);

                            if ($response == 'Unauthorized') {
                                // Erro
                                $retorno = array(
                                    'status' => "erro",
                                    'payment' => json_encode($directpaymentRequest),
                                    'response' => $response,
                                    'retorno' => $serialize_response
                                );

                                $txt_status = "Erro pagamento";
                            } else {

                                $queryPreApproval = new \PagSeguro\Domains\Requests\DirectPreApproval\QueryPaymentOrder($response->code);

                                try {
                                    $response = $queryPreApproval->register($this->credentials);

                                    // Sucesso
                                    $data_transacao = $response->date;
                                    $data_ultimo_evento = $response->paymentOrders->lastEventDate;
                                    $code_transacao = $response->paymentOrders->code;
                                    $dataPagamento = $response->paymentOrders->schedulingDate;
                                    $status = $response->paymentOrders->status;
                                    $ValorTotal = $response->paymentOrders->amount;

                                    $OrdemPagamento = $response->paymentOrders;
                                    $Code_pagamento = 0;
                                    foreach ($OrdemPagamento as $Ordem) {
                                        if ($Ordem->status == 2) { // Pagamento está sendo PROCESSADO
                                            $Code_pagamento = $Ordem->transactions[0]->code;
                                        }
                                    }


                                    try {
                                        $Transacao = \PagSeguro\Services\Transactions\Search\Code::search($this->credentials, $Code_pagamento);

                                        // Pagto Ok
                                        $transaction = array(
                                            'data_transacao' => $Transacao->getDate(),
                                            'data_ultimo_evento' => $Transacao->getLastEventDate(),
                                            'code_transacao' => $Transacao->getCode(),
                                            'type' => $Transacao->getType(),
                                            'status' => $Transacao->getStatus(),
                                            'reference' => $Transacao->getReference(),
                                            'paymentMethodType' => $Transacao->getPaymentMethod()->getType(),
                                            'paymentModeCode' => $Transacao->getPaymentMethod()->getCode(),
                                            'valorpago' => $Transacao->getGrossAmount()
                                        );

                                        // Captura o texto da forma de pagamento
                                        $forma_pagamento = $this->infoTransaction('metodopagamento', $transaction['paymentModeCode']);

                                        // Verifica se retornou corretamente
                                        if (!empty($transaction['reference'])) {
                                            // Verifica o id do status no banco de dados
                                            switch ($transaction['status']) {
                                                // Pagseguro - Aguardando pagamento
                                                case 1:
                                                    $txt_status = "Em andamento";
                                                    $status_assinatura = "Pendente";
                                                    break;
                                                // Pagseguro - Paga, Pagseguro - Disponível
                                                case 3:
                                                case 4:
                                                    $txt_status = "Aprovado";
                                                    $status_assinatura = "Ativo";
                                                    break;
                                                // Pagseguro - Em análise, Pagseguro - Em disputa, Pagseguro - Em contestação
                                                case 2:
                                                case 5:
                                                case 9:
                                                    $txt_status = "Análise em andamento";
                                                    $status_assinatura = "Pendente";
                                                    break;
                                                // Pagseguro - Devolvida, Pagseguro - Cancelada, Pagseguro - Chargeback debitado
                                                case 6:
                                                case 7:
                                                case 8:
                                                    $txt_status = "Cancelado";
                                                    $status_assinatura = "Inativo";
                                                    break;
                                                default:
                                                    $txt_status = "Em andamento";
                                                    $status_assinatura = "Pendente";
                                                    break;
                                            }

                                            // Monta array do pagto com dados principais
                                            $pagto = array(
                                                'idassinatura' => $this->_idassinatura,
                                                'transaction' => $transaction,
                                                'status' => $txt_status
                                            );

                                            // Sucesso
                                            $retorno = array(
                                                'status' => "sucesso",
                                                'pagto' => $pagto,
                                                'finalcard' => $final_cartao,
                                                'bandeira' => $bandeira,
                                                'imgbandeira' => $imagem_icon,
                                                'retorno' => $serialize_response
                                            );


                                        }

                                    } catch (Exception $e) {
                                        die($e->getMessage());
                                    }
                                } catch (Exception $e) {
                                    die($e->getMessage());
                                }
                            }
                        } catch (Exception $e) {
                            // Erro
                            $retorno = array(
                                'status' => "erro",
                                'retorno' => $e->getMessage() . " teste"
                            );
                        }
                    } else {
                        // Erro
                        $retorno = array(
                            'status' => "erro",
                            'retorno' => "Sender Hash não enviado para transação"
                        );
                    }
                } else {
                    // Erro
                    $retorno = array(
                        'status' => "erro",
                        'retorno' => "Tipo de pagamento inválido, tente novamente o processo de pagamento"
                    );
                }
            } else {
                // Erro
                $retorno = array(
                    'status' => "erro",
                    'retorno' => "Metodo de pagamento inválido, tente novamente o processo de pagamento"
                );
            }

            // Insere pagto
            $arr_pagto['idassinatura'] = $this->_idassinatura;
            $arr_pagto['valor_pago'] = $valor_total_final;
            $arr_pagto['parcelas'] = $parcelas;
            $arr_pagto['forma_pagto'] = $forma_pagamento;
            $arr_pagto['status_pagto'] = $txt_status;
            $arr_pagto['observacao'] = "Execução pagSeguro";
            $arr_pagto['meta_dados'] = json_encode($retorno);
            $arr_pagto['data_execucao'] = date("Y-m-d H:i:s");
            $arr_pagto['identificacao'] = 'pagseguro - enviar transação';

            // Insert
            $model_pagtos->insert($arr_pagto);


            // Atualiza a assinatura com o valorpago e status atual
            $model_assinaturas->update(
                array("valorpago" => $valor_total_final, "status" => $status_assinatura),
                array('idassinatura = ?' => $this->_idassinatura)
            );

            return $retorno;
        }
    }

    /**
	 * Consulta código de notificação
	 *
	 * O PagSeguro pode enviar notificações ao seu sistema (POST) indicando a ocorrência de algum evento que requer sua atenção
	 *
	 */
    public function consultarNotificacao($notificationCode, $notificationType) {

    	if(!empty($notificationCode)) {
            try {
                if (\PagSeguro\Helpers\Xhr::hasPost()) {
                    //Caso seja uma notificação de assinatura
                    if ($notificationType == "preApproval") {
                        $response = \PagSeguro\Services\PreApproval\Notification::check($this->credentials);

                        $assinatura = array(
                            'data_transacao' => $response->getDate(),
                            'code_transacao' => $response->getCode(),
                            'reference' => $response->getReference(),
                            'status' => $response->getStatus()
                        );

                        // Verifica se retornou corretamente
                        if (!empty($assinatura['reference'])) {
                            // Remove o prefixo da referencia
                            $idassinatura = str_replace("REF", "", $assinatura['reference']);

                            // Verifica o id do status no banco de dado
                            if ($assinatura['status'] == 'CANCELLED' || $assinatura['status'] == 'CANCELLED_BY_RECEIVER' || $assinatura['status'] == 'CANCELLED_BY_SENDER' || $assinatura['status'] == 'EXPIRED' || $assinatura['status'] == 'PAYMENT_METHOD_CHANGE') {
                                $txt_status = "Cancelado";
                                $status_assinatura = "Inativo";
                            }

                            // Monta array do pagto com dados principais
                            $pagto = array(
                                'idassinatura' => $idassinatura,
                                'transaction' => $assinatura,
                                'status' => $txt_status,
                                'status_assinatura' => $status_assinatura
                            );

                            // Sucesso
                            $retorno = array(
                                'status' => "sucesso",
                                'pagto' => $pagto,
                                'response' => $response,
                                'retorno' => $serialize_response
                            );


                        }

                    }else {

                        try {
                            if (\PagSeguro\Helpers\Xhr::hasPost()) {
                                $response = \PagSeguro\Services\Transactions\Notification::check(
                                    \PagSeguro\Configuration\Configure::getAccountCredentials()
                                );
                            } else {
                                throw new \InvalidArgumentException($_POST);
                            }
                            echo "<pre>";
                            print_r($response);
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }


                        $transaction = array(
                            'data_transacao' => $response->getDate(),
                            'data_ultimo_evento' => $response->getLastEventDate(),
                            'code_transacao' => $response->getCode(),
                            'reference' => $response->getReference(),
                            'type ' => $response->getType(),
                            'status' => $response->getStatus()
                        );

                        // Verifica se retornou corretamente
                        if (!empty($transaction['reference'])) {
                            // Remove o prefixo da referencia
                            $idassinatura = str_replace("REF", "", $transaction['reference']);

                            // Verifica o id do status no banco de dados
                            switch ($transaction['status']) {
                                // Pagseguro - Aguardando pagamento
                                case 1:
                                    $txt_status = "Em andamento";
                                    $status_assinatura = "Pendente";
                                    break;
                                // Pagseguro - Paga, Pagseguro - Disponível
                                case 3:
                                case 4:
                                    $txt_status = "Aprovado";
                                    $status_assinatura = "Ativo";
                                    break;
                                // Pagseguro - Em análise, Pagseguro - Em disputa, Pagseguro - Em contestação
                                case 2:
                                case 5:
                                case 9:
                                    $txt_status = "Análise em andamento";
                                    $status_assinatura = "Pendente";
                                    break;
                                // Pagseguro - Devolvida, Pagseguro - Cancelada, Pagseguro - Chargeback debitado
                                case 6:
                                case 7:
                                case 8:
                                    $txt_status = "Cancelado";
                                    $status_assinatura = "Inativo";
                                    break;
                                default:
                                    $txt_status = "Em andamento";
                                    $status_assinatura = "Pendente";
                                    break;
                            }

                            // Monta array do pagto com dados principais
                            $pagto = array(
                                'idassinatura' => $idassinatura,
                                'transaction' => $transaction,
                                'status' => $txt_status,
                                'status_assinatura' => $status_assinatura
                            );

                            // Sucesso
                            $retorno = array(
                                'status' => "sucesso",
                                'pagto' => $pagto,
                                'response' => $response,
                                'retorno' => $serialize_response
                            );
                        } else {
                            // Erro
                            $retorno = array(
                                'status' => "erro",
                                'response' => $response,
                                'retorno' => $serialize_response
                            );
                        }
                    }
                } else {
                    throw new \InvalidArgumentException($_POST);
                }

            } catch (Exception $e) {
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
    			'retorno' => "Código de notificação é obrigatório"
    		);
    	}

    	// Retorna o array
    	return $retorno;
    }



    /**
     * Consulta código da Assinatura
     *
     * Sempre que precisar, você pode consultar dados de uma transação específica utilizando seu código identificador
     *
     */
    public function consultarAssinatura($AssinaturaCode) {
        if(!empty($AssinaturaCode)) {
            $queryPreApproval = new \PagSeguro\Domains\Requests\DirectPreApproval\QueryPaymentOrder($AssinaturaCode);

            try {
                $response = $queryPreApproval->register($this->credentials);

                $OrdemPagamento = $response->paymentOrders;
                $result = sizeof($OrdemPagamento);




                foreach ($OrdemPagamento as $Ordem) {
                    print_r($Ordem);

                }


                die();
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
	 * Consulta código da transação
	 *
	 * Sempre que precisar, você pode consultar dados de uma transação específica utilizando seu código identificador
	 *
	 */
    public function consultarTransacao($transactionCode) {
    	if(!empty($transactionCode)) {

            try {
                $response = \PagSeguro\Services\Transactions\Search\Code::search(
                    \PagSeguro\Configuration\Configure::getAccountCredentials(),
                    $transactionCode
                );
                echo "<pre>";
                print_r($response);
            } catch (Exception $e) {
                die($e->getMessage());
            }


            die();

    		try {
    			// Requisição ao pagSeguro
                $response = \PagSeguro\Services\Transactions\Search\Code::search($this->credentials, $transactionCode);

                print_r($response);
                die();
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
     * Solicitar cancelamento de Assinatura
     *
     * Sempre que precisar você pode solicitar o cancelamento de uma Assinatura
     *
     */
    public function cancelarAssinatura($preApprovalCode, $idAssinatura) {
        if(!empty($preApprovalCode)) {
            try{
                // Requisição ao pagSeguro
                $status = new \PagSeguro\Domains\Requests\DirectPreApproval\Cancel();
                $status->setPreApprovalCode($preApprovalCode);
                $response = $status->register($this->credentials);

                $model_assinaturas = new Admin_Model_Assinaturas();

                $model_assinaturas->update(
                    array("status" => "Inativo"),
                    array( "idassinatura = ?" => $idAssinatura)
                );

                $model_pagtos = new Admin_Model_Pagtos();

                $select_assinatura = $model_pagtos->select()
                    ->from("pagtos", array('*'))
                    ->where("idassinatura = ?", $idAssinatura)
                    ->order("idpagto DESC")
                    ->setIntegrityCheck(FALSE);

                // Fetch
                $AllPagtos = $model_pagtos->fetchAll($select_assinatura);

                //$AllPagtos = $model_pagtos->fetchAll(array('idassinatura = ?' => ));

                foreach ($AllPagtos as $Pagto) {
                    if ($Pagto['status_pagto'] == "Agendado") {
                        $model_pagtos->update(
                            array("status_pagto" => "Cancelado"),
                            array( "idpagto = ?" => $Pagto['idpagto'])
                        );
                    }else if ($Pagto['code_transacao'] && $Pagto['status_pagto'] != "Cancelado" && $Pagto['status_pagto'] != "Aprovado") {

                        $response = \PagSeguro\Services\Transactions\Search\Code::search($this->credentials, $Pagto['code_transacao']);

                        if ($response->getStatus() == 1 || $response->getStatus() == 2){
                            try {
                                $cancel = \PagSeguro\Services\Transactions\Cancel::create($this->credentials, $Pagto['code_transacao']);

                                $model_pagtos->update(
                                    array("status_pagto" => "Cancelado"),
                                    array( "idpagto = ?" => $Pagto['idpagto'])
                                );

                            } catch (Exception $e) {
                                die($e->getMessage());
                            }
                        }
                    }

                }

                //$model_assinaturas->update(
                //    array("status" => "Inativo"),
                //    array( "idassinatura = ?" => $idAssinatura)
                //);
                //$retorno = simplexml_load_string($response);

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
        return json_encode($response);
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
    	// Inicia o array
    	$dadostatus = array();

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
            var_dump($transaction);
//            echo "<h2>Retorno da transa&ccedil;&atilde;o com Cart&atilde;o de Cr&eacute;dito.</h2>";
//            echo "<p><strong>Date: </strong> ".$transaction->getDate() ."</p> ";
//            echo "<p><strong>lastEventDate: </strong> ".$transaction->getLastEventDate()."</p> ";
//            echo "<p><strong>code: </strong> ".$transaction->getCode() ."</p> ";
//            echo "<p><strong>reference: </strong> ".$transaction->getReference() ."</p> ";
//            echo "<p><strong>type: </strong> ".$transaction->getType()->getValue() ."</p> ";
//            echo "<p><strong>status: </strong> ".$transaction->getStatus()->getValue() ."</p> ";
//            echo "<p><strong>paymentMethodType: </strong> ".$transaction->getPaymentMethod()->getType()->getValue() ."</p> ";
//            echo "<p><strong>paymentModeCode: </strong> ".$transaction->getPaymentMethod()->getCode()->getValue() ."</p> ";
//            echo "<p><strong>grossAmount: </strong> ".$transaction->getGrossAmount() ."</p> ";
//            echo "<p><strong>discountAmount: </strong> ".$transaction->getDiscountAmount() ."</p> ";
//            echo "<p><strong>feeAmount: </strong> ".$transaction->getFeeAmount() ."</p> ";
//            echo "<p><strong>netAmount: </strong> ".$transaction->getNetAmount() ."</p> ";
//            echo "<p><strong>extraAmount: </strong> ".$transaction->getExtraAmount() ."</p> ";
//            echo "<p><strong>installmentCount: </strong> ".$transaction->getInstallmentCount() ."</p> ";
//            echo "<p><strong>itemCount: </strong> ".$transaction->getItemCount() ."</p> ";
//            echo "<p><strong>Items: </strong></p>";
//            foreach ($transaction->getItems() as $item) {
//                echo "<p><strong>id: </strong> ". $item->getId() ."</br> ";
//                echo "<strong>description: </strong> ". $item->getDescription() ."</br> ";
//                echo "<strong>quantity: </strong> ". $item->getQuantity() ."</br> ";
//                echo "<strong>amount: </strong> ". $item->getAmount() ."</p> ";
//            }
//
//            echo "<p><strong>senderName: </strong> ".$transaction->getSender()->getName() ."</p> ";
//            echo "<p><strong>senderEmail: </strong> ".$transaction->getSender()->getEmail() ."</p> ";
//            echo "<p><strong>senderPhone: </strong> ".$transaction->getSender()->getPhone()->getAreaCode() . " - " .
//                 $transaction->getSender()->getPhone()->getNumber() . "</p> ";
//            echo "<p><strong>Shipping: </strong></p>";
//            echo "<p><strong>street: </strong> ".$transaction->getShipping()->getAddress()->getStreet() ."</p> ";
//            echo "<p><strong>number: </strong> ".$transaction->getShipping()->getAddress()->getNumber()  ."</p> ";
//            echo "<p><strong>complement: </strong> ".$transaction->getShipping()->getAddress()->getComplement()  ."</p> ";
//            echo "<p><strong>district: </strong> ".$transaction->getShipping()->getAddress()->getDistrict()  ."</p> ";
//            echo "<p><strong>postalCode: </strong> ".$transaction->getShipping()->getAddress()->getPostalCode()  ."</p> ";
//            echo "<p><strong>city: </strong> ".$transaction->getShipping()->getAddress()->getCity()  ."</p> ";
//            echo "<p><strong>state: </strong> ".$transaction->getShipping()->getAddress()->getState()  ."</p> ";
//            echo "<p><strong>country: </strong> ".$transaction->getShipping()->getAddress()->getCountry()  ."</p> ";
        }
      echo "<pre>";
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
