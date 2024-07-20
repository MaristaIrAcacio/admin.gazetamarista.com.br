<?php

/**
 * Modelo da tabela
 *
 * @name Admin_Model_Blogs
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Servicos extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "servicos";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idservico";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("titulo", "Título");
		$this->setCampo("descricao", "Descrição");
		$this->setCampo("banner", "Banner Desktop", "1900x900px [.jpg, .png]");
		$this->setCampo("banner_mobile", "Banner Mobile", "900x500px [.jpg, .png]");
		$this->setCampo("ordenacao", "Ordenacao", "Ex. 1, 2, 6, 12");
		$this->setCampo("meta_title", "Título SEO", "Será usado o título caso não definido.");
		$this->setCampo("meta_description", "Descrição SEO");
		$this->setCampo("ativo", "Ativo?");
		
		// Seta o campo de descrição da tabela
		$this->setDescription("titulo");

		// Seta visibilidade dos campos
		$this->setVisibility("titulo", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("descricao", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor-big' => ''));
		$this->setVisibility("banner", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("banner_mobile", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("ordenacao", TRUE, TRUE, TRUE, TRUE);
		$this->setVisibility("meta_title", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("meta_description", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("ativo", TRUE, TRUE, TRUE, TRUE);


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
