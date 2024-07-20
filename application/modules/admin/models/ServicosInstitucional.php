<?php

/**
 * Modelo da tabela
 *
 * @name Admin_Model_Blogs
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_ServicosInstitucional extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "servicos_institucional";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idservicoGeral";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("banner", "Banner Desktop", "1920x1080px [.jpg, .png]");
		$this->setCampo("banner_mobile", "Banner Mobile", "900x500px [.jpg, .png]");
		$this->setCampo("descricao", "Descrição");
		
		// Seta o campo de descrição da tabela
		$this->setDescription("descricao");

		// Seta visibilidade dos campos
		$this->setVisibility("banner", TRUE, TRUE, TRUE, TRUE);
		$this->setVisibility("banner_mobile", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("descricao", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor-big' => ''));


		// Seta os modificadores
		$this->setModifier("banner", array(
			'type' => "file",
			'preview' => "common/uploads/servicos/",
			'destination' => APPLICATION_PATH . "/../common/uploads/servicos/",
            'extension' => array('jpg', 'jpeg', 'png')
		));

		$this->setModifier("banner_mobile", array(
			'type' => "file",
			'preview' => "common/uploads/servicos/",
			'destination' => APPLICATION_PATH . "/../common/uploads/servicos/",
            'extension' => array('jpg', 'jpeg', 'png')
		));

		// Continua o carregamento do model
		parent::init();
	}
}
