<?php
/**
 * Classe abstrata de métodos de fraude
 * 
 * @name gazetamarista_Fraudes_Abstract
 */
abstract class gazetamarista_Fraudes_Abstract {
	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = NULL;
	
	/**
	 * Armazena as configurações do arquivo ini
	 *
	 * @access protected
	 * @name $_config
	 * @var Zend_Controller_Request_Abstract
	 */
	protected $_config = NULL;
	
	/**
	 * Armazena o request
	 *
	 * @access protected
	 * @name $_request
	 * @var Zend_Http_Response
	 */
	protected $_request = NULL;
	
	/**
	 * Armazena o id do pedido
	 *
	 * @access protected
	 * @name $_idpedido
	 * @var integer
	 */
	protected $_idpedido = array();
	
	/**
	 * Armazena as informações do pedido
	 *
	 * @access protected
	 * @name $_pedido
	 * @var Zend_Db_Table_Row
	 */
	protected $_pedido = array();
	
	/**
	 * Inicializa a classe de pagamento
	 *
	 * @name __construct
	 * @param integer $idpedido Id do pedido à efetuar o pagamento
	 */
	public function __construct($idpedido) {
		// Monta o arquivo de configuração
		$filename = APPLICATION_PATH . "/configs/fraudes/" . strtolower(str_replace(" ", "_", $this->_name)) . ".ini";
				
		// Busca as configurações do arquivo ini
		if(file_exists($filename)) {
			$this->_config = new Zend_Config_Ini($filename, "config");
		}
		
		// Armazena o request
		$fc = Zend_Controller_Front::getInstance ();
		$this->_request = $fc->getRequest();
		
		// Recupera as informações do pedido
		$this->_idpedido = $idpedido;
		$model = new Admin_Model_Pedidos();
                $select = $model->select()
                            ->from(array(
                                'p' => 'pedidos'
                            ))
                            ->join(array(
                                'c' => 'clientes'
                            ), 'p.idcliente = c.idcliente')
                            ->where('p.idpedido = ?', $this->_idpedido)
                            ->setIntegrityCheck(false);
		$this->_pedido = $model->fetchRow($select);
		
		// Armazena a forma de pagamento
		$this->_idmetodo_pagamento = $this->_request->getParam("forma_pagamento", 0);
		
		// Cria o método para inicialização personalizada
		$this->init();
	}
	
	/**
	 * Método para inicialização personalizada
	 *
	 * @name init
	 */
	public function init() {
	}
	
	/**
	 * Efetua a verificação da fraude
	 * 
	 * @name analise
	 * @return boolean
	 */
	public function analise() {
		return TRUE;
	}
	
	/**
	 * Efetua a verificação do status
	 *
	 * @name getstatus
	 * @return boolean
	 */
	public function getstatus() {
		return TRUE;
	}
	
	/**
	 * Salva logs do status
	 * 
	 * @access protected
	 * @name status
	 * @param int $status Id do status do pedido
	 * @param int $meta_dados JSON dos dados
	 * @param string $dados Conteudo do retorno
	 */
	protected function status($status, $meta_dados, $dados) {
		// Cria o model dos status
		$model = new Admin_Model_Pedidosstatus();
		
		// Monta o vetor de dados para inserir
		$data_update 					= array();
		$data_update['idpedido'] 		= $this->_idpedido;
		$data_update['idstatus_pedido'] = $status;
		$data_update['data_execucao'] 	= date("Y-m-d H:i:s");
		$data_update['meta_dados'] 		= $meta_dados;
		$data_update['dados'] 			= utf8_encode($dados);
		$data_update['identificacao'] 	= strtolower(str_replace(" ", "_", $this->_name));
		
		// Insere o novo status do pedido
		$model->insert($data_update);

		$modelPedidos = new Admin_Model_Pedidos();
		$modelPedidos->update($data_update, array('idpedido = ?' => $this->_idpedido));
			
		// Retorna ao controlador principal
		return TRUE;
	}
}