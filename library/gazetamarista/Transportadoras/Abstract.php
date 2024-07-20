<?php
/**
 * Classe abstrata para o calculo de fretes
 * 
 * @name gazetamarista_Transportadoras_Abstract
 */
abstract class gazetamarista_Transportadoras_Abstract {
	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = NULL;
	
	/**
	 * Armazena o cep de destino
	 *
	 * @access protected
	 * @name $_cep_destino
	 * @var string
	 */
	protected $_cep_destino = NULL;
	
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
	 * Armazena os métodos de envio
	 *
	 * @access protected
	 * @name $_metodos_envio
	 * @var array
	 */
	protected $_metodos_envio = array();
	
	/**
	 * Armazena os produtos
	 *
	 * @access protected
	 * @name $_produtos
	 * @var Zend_Db_Table_Rowset
	 */
	protected $_produtos = NULL;
	
	/**
	 * Armazena o objeto de execução do banco de dados
	 *
	 * @access protected
	 * @name $_model
	 * @var Zend_Db_Adapter
	 */
	protected $_model = NULL;
	
	/**
	 * Inicializa a classe de pagamento
	 *
	 * @name __construct
	 * @param string $cep CEP de destino
	 * @param array $metodos_envio Vetor com o código dos métodos de envio
	 * @param array $produtos Vetor com o código dos produtos e a quantidade
	 */
	public function __construct($cep, $metodos_envio, $produtos) {
		// Busca o objeto para execução da query
		$this->_model = Zend_Registry::get("db");
		
		// Armazena o cep de destino
		$this->_cep_destino = $cep;
		
		// Armazena os metodos de envio
		$this->_metodos_envio = $metodos_envio;
		
		// Armazena os produtos
		$this->_produtos = $produtos;
		
		// Monta o arquivo de configuração
		$filename = APPLICATION_PATH . "/configs/transportadoras/" . strtolower(str_replace(" ", "_", $this->_name)) . ".ini";
				
		// Busca as configurações do arquivo ini
		if(file_exists($filename)) {
			$this->_config = new Zend_Config_Ini($filename, "config");
		}
		
		// Armazena o request
		$fc = Zend_Controller_Front::getInstance ();
		$this->_request = $fc->getRequest();
		
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
}