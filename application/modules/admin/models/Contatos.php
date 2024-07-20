<?php

/**
 * Modelo
 *
 * @name Admin_Model_Contatos
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Contatos extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "contatos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idcontato";

	/**
	 * Armazena se bloqueia exportar xls no list
	 *
	 * @access protected
	 * @name $_gerarXls
	 * @var string
	 */
	protected $_gerarXls = true;

	/**
	 * Armazena se bloqueia manipulação dos dados
	 *
	 * @access protected
	 * @name $_somenteview
	 * @var string
	 */
	protected $_somenteView = true;
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("assunto", "Assunto");
		$this->setCampo("nome", "Nome completo");
		$this->setCampo("email", "E-mail");
		$this->setCampo("celular", "Celular");
		$this->setCampo("mensagem", "Mensagem");
		$this->setCampo("data", "Data");
		$this->setCampo("ip", "IP");

		// Seta o campo de descrição da tabela
		$this->setDescription("nome");

		// Seta visibilidade dos campos
		$this->setVisibility("assunto", TRUE, TRUE, TRUE, TRUE);
		$this->setVisibility("nome", TRUE, TRUE, TRUE, TRUE);
		$this->setVisibility("email", TRUE, TRUE, TRUE, TRUE);
		$this->setVisibility("celular", TRUE, TRUE, TRUE, FALSE, FALSE, array('class' => 'no-mask'));
		$this->setVisibility("mensagem", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("data", TRUE, TRUE, FALSE, TRUE);
		$this->setVisibility("ip", FALSE, FALSE, FALSE, FALSE);
		
		// Continua o carregamento do model
		parent::init();
	}
}
