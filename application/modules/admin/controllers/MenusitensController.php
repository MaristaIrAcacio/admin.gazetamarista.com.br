<?php

/**
 * Controlador dos menus
 *
 * @name Admin_MenusitensController
 */
class Admin_MenusitensController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Menusitens
	 */
	protected $_model = NULL;

	/**
	 *
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Menusitens();
		
		//
		parent::init();
	}
}
