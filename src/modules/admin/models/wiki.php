<?php

/**
 * Modelo
 *
 * @name Admin_Model_Wiki
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Wiki extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "gm_wiki";

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
		$this->setCampo("categoria", "Categoria da Wiki");
		$this->setCampo("titulo", "Título");
		$this->setCampo("conteudo", "Conteúdo");
		$this->setCampo("data_criacao", "Data de Criação");
		$this->setCampo("data_modificacao", "Data de Modificação");
		$this->setCampo("autor", "Autor");

		// Seta o campo de descrição da tabela
		$this->setDescription("titulo");

		// Seta visibilidade dos campos
		$this->setVisibility("categoria", TRUE, TRUE, TRUE, FALSE);
		$this->setVisibility("titulo", TRUE, TRUE, TRUE, TRUE);
		$this->setVisibility("conteudo", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor-big' => ''));
		$this->setVisibility("data_criacao", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("data_modificacao", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("autor", FALSE, FALSE, FALSE, FALSE);

		// Seta autocomplete
		$this->setAutocomplete("categoria", "Admin_Model_Wikicategoria");
		
		// Continua o carregamento do model
		parent::init();
	}
}
