<?php

/**
 * Controlador
 *
 * @name Admin_BlogscategoriasController
 */
class Admin_BlogscategoriasController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Blogscategorias
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Blogscategorias();
		
		// Continua o carregamento do controlador
		parent::init();
	}
	
	/**
	 * Hook para listagem
	 *
	 * @name doBeforeList
	 * @param Zend_Db_Table_Select
	 * @return Zend_Db_Table_Select
	 */
	public function doBeforeList($select) {
		// Monta a query
		$select
            ->order("ordenacao ASC")
			->order("blogcategoria ASC");
		
		// Continua a execução
		return $select;
	}
}
