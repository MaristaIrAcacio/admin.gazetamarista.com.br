<?php

/**
 * Modelo
 *
 * @name Admin_Model_Wikicategoria
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Wikicategoria extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "gm_wiki_categorias";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "id";

	/**
	 * Armazena se bloqueia exportar xls no list
	 *
	 * @access protected
	 * @name $_gerarXls
	 * @var string
	 */
	protected $_gerarXls = false;

	/**
	 * Armazena se bloqueia manipulação dos dados
	 *
	 * @access protected
	 * @name $_somenteview
	 * @var string
	 */
	protected $_somenteView = false;
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("nome", "Nome da Categoria");
		// Seta o campo de descrição da tabela
		$this->setDescription("nome");

		// Seta visibilidade dos campos
		$this->setVisibility("nome", TRUE, TRUE, TRUE, TRUE);

		
		// Continua o carregamento do model
		parent::init();
	}
}
