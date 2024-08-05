<?php

/**
 * Controlador das categorias da wiki
 *
 * @name Admin_WikicategoriaController
 */
class Admin_WikicategoriaController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Wikicategoria
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Wikicategoria();
		
		// Continua o carregamento do controlador
		parent::init();
	}
}