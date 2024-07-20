<?php

/**
 * Modelo da tabela
 *
 * @name Admin_Model_Proposito
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Proposito extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "proposito";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idproposito";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("titulo", "Título");
		$this->setCampo("descricao", "Descrição");

		// Seta o campo de descrição da tabela
		$this->setDescription("titulo");

		// Seta visibilidade dos campos
        $this->setVisibility("titulo", TRUE, TRUE, TRUE, FALSE);
		$this->setVisibility("descricao", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor' => ''));

		// Continua o carregamento do model
		parent::init();
	}
}
