<?php

/**
 * Modelo da tabela de menus_itens
 *
 * @name Admin_Model_Menusitens
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Serie extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "gm_serie";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idserie";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		//
		$this->setCampo("item", "Descrição");
		$this->setVisibility("item", TRUE, TRUE, TRUE, TRUE);
		$this->setDescription("item");
		
		//
		parent::init();
	}
}
