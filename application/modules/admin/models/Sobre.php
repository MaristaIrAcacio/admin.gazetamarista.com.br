<?php

/**
 * Modelo da tabela
 *
 * @name Admin_Model_Sobre
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Sobre extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "sobre";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idsobre";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("descricao1", "Descrição 1");
		$this->setCampo("descricao2", "Descrição 2");
		$this->setCampo("thumb_desktop", "Thumb do vídeo - desktop", "1920x1080px [.jpg .png .jpeg]");
		$this->setCampo("thumb_mobile", "Thumb do vídeo - mobile", "400x660px [.jpg .png .jpeg]");
		$this->setCampo("link_video", "Vídeo home", "Link Youtube");	

		// Seta o campo de descrição da tabela
		$this->setDescription("descricao1");

		// Seta visibilidade dos campos
		$this->setVisibility("descricao1", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor' => ''));
		$this->setVisibility("descricao2", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor' => ''));
        $this->setVisibility("home_video", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("thumb_desktop", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("thumb_mobile", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("link_video", TRUE, TRUE, FALSE, FALSE);

		// Seta os modificadores
		$this->setModifier("thumb_desktop", array(
			'type' => "file",
			'preview' => "common/uploads/sobre",
			'destination' => APPLICATION_PATH . "/../common/uploads/sobre"
		));

		$this->setModifier("thumb_mobile", array(
			'type' => "file",
			'preview' => "common/uploads/sobre",
			'destination' => APPLICATION_PATH . "/../common/uploads/sobre"
		));
		
		// Continua o carregamento do model
		parent::init();
	}
}
