<?php

/**
 * Modelo da tabela de logs
 *
 * @name Admin_Model_Logs
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Logs extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "logs";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idlog";

	/**
	 * Armazena se bloqueia manipulação dos dados
	 *
	 * @access protected
	 * @name $_somenteview
	 * @var string
	 */
	protected $_somenteView = true;

	/**
	 * Parâmetros para esconder botão 'Remover'
	 *
	 * @access protected
	 * @name $_esconderBtnRemover
	 * @var boolean
	 */
	protected $_esconderBtnRemover = true;

	/**
	 * Armazena se bloqueia exportar xls no list
	 *
	 * @access protected
	 * @name $_gerarXls
	 * @var string
	 */
	protected $_gerarXls = true;
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		//
		$this->setCampo("idusuario", "Usuário");
		$this->setCampo("nomeusuario", "Nome Usuário");
		$this->setCampo("modulo", "Módulo");
		$this->setCampo("tabela", "Tabela");
		$this->setCampo("json_data_antes", "Conteúdo antigo");
		$this->setCampo("json_data", "Conteúdo");
		$this->setCampo("acao_executada", "Ação Executada");
		$this->setCampo("browser_sistema", "Browser/Sistema");
		$this->setCampo("data_execucao", "Data Execução");
		$this->setCampo("ip", "IP");
		
		// Seta o campo de descrição da tabela
		$this->setDescription("tabela");

		// Seta visibilidade dos campos
        $this->setVisibility("idusuario", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("nomeusuario", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("modulo", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("tabela", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("json_data_antes", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("json_data", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("acao_executada", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("browser_sistema", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("data_execucao", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("ip", TRUE, TRUE, FALSE, TRUE);

        // Seta autocomplete
		$this->setAutocomplete("idusuario", "Admin_Model_Usuarios");
		
		// Continua o carregamento do model
		parent::init();
	}
}
