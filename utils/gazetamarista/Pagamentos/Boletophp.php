<?php
/**
 * Classe de pagamentos por boleto bancário (Boleto PHP)
 *
 * @name gazetamarista_Pagamentos_Boletophp
 */
class gazetamarista_Pagamentos_Boletophp extends gazetamarista_Pagamentos_Abstract {
	
	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "boletophp";
	
	/**
	 * Inicializa a classe de pagamento
	 *
	 * @name init
	 */
	public function init() {
		// Armazena as configurações globais
		$this->_application_config = Zend_Registry::get("config");
		$this->_modules = Zend_Registry::get("modulos");
	}
	
	/**
	 * Verifica se o boleto ainda é valido
	 * 
	 * @name validate
	 */
	public function validate() {
		// Recupera a data da criação
		$tmp = explode(" ", $this->_pedido->data_criacao);
		$data = strtotime($tmp[0] . " 23:59:59");
		
		// Calcula os dias uteis
		$data_venc = $data + ($this->_config->validade * 86400);
		
		// Verifica se o boleto é valido
		if(time() > $data_venc) {
			throw new Exception("Este boleto não está mais disponível");
		}else{
			return TRUE;
		}
	}
	
	/**
	 * Efetua o pagamento
	 * 
	 * @name pagamento
	 * @return boolean
	 */
	public function pagamento() {
		// Verifica se o método de pagamento e boleto
		if($this->_idmetodo_pagamento == 1410) {
			// Monta os parametros
			$param = array(
				'status' => 'processado',
				'processamento' => date("Y-m-d H:i:s")
			);
			
			// Armazena o log do pedido
			$this->status(6, json_encode($param), "boleto");
			
			// Retorna a confirmação
			return TRUE;
		}
	}
	
	/**
	 * Confirmação de captura
	 * 
	 * @name captura
	 * @return boolean
	 */
	public function captura() {
		return TRUE;
	}
	
	/**
	 * Gera o boleto
	 * 
	 * @name gerar
	 */
	public function gerar() {
		// Cria o model dos status do pedido
		$model = new Admin_Model_Pedidosstatus();
		
		// Busca o ultimo status do pedido
		$row = $model->fetchRow(array('idpedido = ?' => $this->_idpedido), "data_execucao DESC");
		switch($row->idstatus_pedido) {
			case 2:
			case 3:
			case 4:
			case 5:
			case 7:
			case 8:
			case 9:
			case 10:
			case 11:
				die("Este boleto não está mais disponível");
				break;
		}
		
		// $row = $model->fetchRow(array('idpedido = ?' => $this->_idpedido, "identificacao = 'boletophp'"), "data_execucao DESC");
		// $meta_data = json_decode($row->meta_dados);
		
		// // Verifica se o boleto ja foi pago
		// if($meta_data->status == "pago") {
		// 	die("Boleto ja foi pago");
		// }
		
		// Monta os parametros
		$param = array(
			'status' => 'gerado'
		);
		
		// Armazena o log de status do pedido
		$this->status(1, json_encode($param), "boleto");
		
		// Verifica se o arquivo existe
		$boleto_filename = APPLICATION_PATH . "/../library/gazetamarista/Library/boletophp/boleto_" . $this->_config->boleto . ".php";
		if(!file_exists($boleto_filename)) {
			throw new Zend_Exception("Não foi possível encontrar o arquivo do boleto.");
		}
		
		// Ajusta as variaveis
		$_application_config = $this->_application_config;
		
		// inclui as funções para geração do boleto
		include($boleto_filename);
		include(APPLICATION_PATH . "/../library/gazetamarista/Library/boletophp/include/funcoes_" . $this->_config->boleto . ".php"); 
		include(APPLICATION_PATH . "/../library/gazetamarista/Library/boletophp/include/layout_" . $this->_config->boleto . ".php");
	}
}