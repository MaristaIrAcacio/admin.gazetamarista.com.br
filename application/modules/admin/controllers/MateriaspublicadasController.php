<?php

/**
 * Controlador
 *
 * @name Admin_MateriasController
 */
class Admin_MateriaspublicadasController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_MateriasPublicado
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_MateriasPublicado();
		
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

		// Resgata o id do usuário da session
		$this->session = new Zend_Session_Namespace("loginadmin");
		$id = $this->session->logged_usuario['idusuario'];

		// Monta a query
		$select
			->where("status = ?", "publicado")
			->where("autorId = ?", $id)
			->order("atualizadoEm DESC");

		// Continua a execução
		return $select;
	}
}