<?php
/**
 * Classe abstrata de métodos de pagamento
 * 
 * @name gazetamarista_Pagamentos_Abstract
 */
abstract class gazetamarista_Pagamentos_Abstract {
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
	 * Armazena o id da assinatura
	 *
	 * @access protected
	 * @name $_idassinatura
	 * @var integer
	 */
	protected $_idassinatura = array();
	
	/**
	 * Armazena as informações da assinatura
	 *
	 * @access protected
	 * @name $_assinatura
	 * @var Zend_Db_Table_Row
	 */
	protected $_assinatura = array();
	
	/**
	 * Armazena as informações do cliente
	 *
	 * @access protected
	 * @name $_cliente
	 * @var Zend_Db_Table_Row
	 */
	protected $_cliente = array();

	/**
	 * Armazena o método de pagamento
	 *
	 * @access protected
	 * @name $_metodo_pagamento
	 * @var Zend_Db_Table_Row
	 */
	protected $_metodo_pagamento = array();

	/**
	 * Array com dados de pagamento
	 *
	 * @access protected
	 * @name $_arrPagto
	 * @var Zend_Db_Table_Row
	 */
	protected $_arrPagto = array();
	
	/**
	 * Inicializa a classe de pagamento
	 *
	 * @name __construct
	 * @param integer $idassinatura Id da assinatura à efetuar o pagamento
     * @param array $arrPagto Array com dados de pagamento
	 */
	public function __construct($idassinatura=null, $arrPagto=null) {
        // Armazena o request
		$fc = Zend_Controller_Front::getInstance ();
		$this->_request = $fc->getRequest();

        if($idassinatura > 0) {
            // Id
            $this->_idassinatura = $idassinatura;

            // Recupera as informações da assinatura
            $this->_assinatura = (new Admin_Model_Assinaturas())->fetchRow(array('idassinatura = ?' => $this->_idassinatura));

            // Recupera as informações do cliente da assinatura
            $this->_cliente = $this->_assinatura->findParentRow("Admin_Model_Clientes");

            // Armazena a forma de pagamento
            $this->_metodo_pagamento = $this->_request->getParam("forma_pagamento", 0);
        }

        // Dados de pagamento
		$this->_arrPagto = $arrPagto;
		
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
	 * Efetua o pagamento
	 * 
	 * @name pagamento
	 * @return boolean
	 */
	public function pagamento() {
		return TRUE;
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
	 * Salva logs do status
	 * 
	 * @access protected
	 * @name status
	 * @param string $status Status do pagto
	 * @param array $meta_dados JSON dos dados
	 */
	protected function status($status=null, $meta_dados=null) {
	    // Status pagto
        if($status == "sucesso") {
		    $status_pagto = "Aprovado";
		    $status_assinatura = "Ativo";
        }else{
		    $status_pagto = "Recusado";
		    $status_assinatura = "Cancelado";
        }

		// Monta o vetor de dados pagto
		$data_pagto                       = array();
		$data_pagto['idassinatura']       = $this->_idassinatura;
		$data_pagto['valor_pago']         = $this->_assinatura->valor_plano;
		$data_pagto['code_transacao']     = $meta_dados['retorno']['Tid'];
		$data_pagto['forma_pagto']        = 'CreditCard';
		$data_pagto['idcliente_cartao']   = $meta_dados['idcartao'];
		$data_pagto['status_pagto']       = $status_pagto;
		$data_pagto['meta_dados']         = json_encode($meta_dados);
		$data_pagto['data_execucao']      = date("Y-m-d H:i:s");
		$data_pagto['identificacao']      = strtolower(str_replace(" ", "_", $this->_name));

		// Monta o vetor de dados assinatura
		$data_assinatura = array(
		    'cobranca_recorrente' => $meta_dados['recorrente'],
            'status' => $status_assinatura
        );
		
		// Insere o novo status do pagto
		(new Admin_Model_Pagtos())->insert($data_pagto);

		// Atualiza tabela de assinatura
		(new Admin_Model_Assinaturas())->update($data_assinatura, array('idassinatura = ?' => $this->_idassinatura));
			
		// Retorna ao controlador principal
		return TRUE;
	}
}