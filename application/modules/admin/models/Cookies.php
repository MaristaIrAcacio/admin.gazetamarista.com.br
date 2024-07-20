<?php

/**
 * Modelo da tabela de cookies
 *
 * @name Admin_Model_Cookies
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Cookies extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "cookies";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idcookie";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("ip", "ip");
		$this->setCampo("data", "data");

		// Seta visibilidade dos campos
		$this->setVisibility("ip", TRUE, TRUE, TRUE, TRUE);
		$this->setVisibility("data", TRUE, TRUE, FALSE, TRUE);
		
		// Continua o carregamento do model
		parent::init();
	}
}