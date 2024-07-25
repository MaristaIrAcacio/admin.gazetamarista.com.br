<?php

/**
 * Modelo
 *
 * @name Admin_Model_Materias
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Chargespendente extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "charges";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idCharges";

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
		$this->setCampo("titulo", "Título", "Será usado no SEO da charge");
		$this->setCampo("descricao", "Descrição", "Será usado no SEO da charge");
		$this->setCampo("imagem", "Charge", "[.png .jpg.]");
		$this->setCampo("autorId", "");
		$this->setCampo("colaborador1Id", "Colaborador 1");
		$this->setCampo("colaborador2Id", "Colaborador 2");
		$this->setCampo("colaborador3Id", "Colaborador 3");
		$this->setCampo("status", "Status");
		$this->setCampo("apontamentos", "Apontamentos");
		$this->setCampo("dataPublicacao", "");
		$this->setCampo("criadoEm", "");
		$this->setCampo("atualizadoEm", "");

		// Seta o campo de descrição da tabela
		$this->setDescription("imagem");

		// Seta visibilidade dos campos
		$this->setVisibility("titulo", TRUE, TRUE, TRUE, TRUE);
		$this->setVisibility("descricao", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor' => ''));
		$this->setVisibility("imagem", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("autorId", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("colaborador1Id", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("colaborador2Id", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("colaborador3Id", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("status", FALSE, FALSE, FALSE, TRUE);
		$this->setVisibility("apontamentos", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("dataPublicacao", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("criadoEm", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("atualizadoEm", FALSE, FALSE, FALSE, FALSE);

		// Seta autocomplete
		$this->setAutocomplete("colaborador1Id", "Admin_Model_Usuarios");	
		$this->setAutocomplete("colaborador2Id", "Admin_Model_Usuarios");	
		$this->setAutocomplete("colaborador3Id", "Admin_Model_Usuarios");	
		
		// Seta os Modificadores
		$this->setModifier("imagem", array(
			'type' => "file",
			'preview' => "common/uploads/charges",
			'destination' => APPLICATION_PATH . "/../common/uploads/charges",
            'extension' => array('jpg', 'jpeg', 'png')
		));

		// Continua o carregamento do model
		parent::init();
	}
}
