<?php

/**
 * Modelo da tabela de erros
 *
 * @name Admin_Model_Erros
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Erros extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "gm_erros";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "iderro";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Campos
		$this->setCampo("data_execucao", "Data Execução");
		$this->setCampo("mensagem", "Mensagem");
		$this->setCampo("parametros", "Parâmetros");
		$this->setCampo("browser_sistema", "Browser/Sistema");
		$this->setCampo("idusuario", "Ação Usuário");
		$this->setCampo("trace", "Trace");
		$this->setCampo("ip", "IP");
		
		// Seta o campo de descrição da tabela
		$this->setDescription("data_execucao");
		
		// Continua o carregamento do model
		parent::init();
	}
}