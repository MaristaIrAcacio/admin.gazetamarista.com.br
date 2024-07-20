<?php

/**
 * Modelo da tabela
 *
 * @name Admin_Model_SobreInstitucional
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_SobreInstitucional extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "sobre_institucional";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idsobreInstitucional";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("titulo", "Título");
		$this->setCampo("descricao1", "Descrição 1");
		$this->setCampo("banner_desktop", "Banner desktop", "1600x600px [.jpg, .png]");
		$this->setCampo("banner_mobile", "Banner mobile", "400x400px [.jpg, .png]");
		$this->setCampo("descricao2", "Descrição 2");

		$this->setCampo("imagem1", "Imagem 1", "800x500px [.jpg, .png]");
		$this->setCampo("imagem2", "Imagem 2", "800x500px [.jpg, .png]");
		
		// Seta o campo de descrição da tabela
		$this->setDescription("titulo");

		// Seta visibilidade dos campos
        $this->setVisibility("titulo", TRUE, TRUE, TRUE, FALSE);
        $this->setVisibility("banner_desktop", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("banner_mobile", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("descricao1", TRUE, TRUE, TRUE, FALSE, FALSE, array('data-ckeditor' => ''));
		$this->setVisibility("descricao2", TRUE, TRUE, TRUE, FALSE, FALSE, array('data-ckeditor' => ''));
        $this->setVisibility("imagem1", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("imagem2", TRUE, TRUE, FALSE, FALSE);

		// Seta os modificadores
		$this->setModifier("banner_desktop", array(
			'type' => "file",
			'preview' => "common/uploads/sobre",
			'destination' => APPLICATION_PATH . "/../common/uploads/sobre"
		));

		$this->setModifier("banner_mobile", array(
			'type' => "file",
			'preview' => "common/uploads/sobre",
			'destination' => APPLICATION_PATH . "/../common/uploads/sobre"
		));

		$this->setModifier("imagem1", array(
			'type' => "file",
			'preview' => "common/uploads/sobre",
			'destination' => APPLICATION_PATH . "/../common/uploads/sobre"
		));

		$this->setModifier("imagem2", array(
			'type' => "file",
			'preview' => "common/uploads/sobre",
			'destination' => APPLICATION_PATH . "/../common/uploads/sobre"
		));

		// Continua o carregamento do model
		parent::init();
	}
}
