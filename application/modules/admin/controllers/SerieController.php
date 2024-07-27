<?php

/**
 * Controlador dos Perfis de admin
 *
 * @name Admin_PerfisController
 */
class Admin_SerieController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_serie
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_serie();
		
		// Continua o carregamento do controlador
		parent::init();
	}
}