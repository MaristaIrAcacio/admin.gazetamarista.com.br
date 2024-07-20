<?php

/**
 * Controlador
 *
 * @name Admin_SobreController
 */
class Admin_SobreController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Sobre
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model 		= new Admin_Model_Sobre();

		// Busca a sessão do login
		$this->session  = new Zend_Session_Namespace("loginadmin");
		$this->messages = new Zend_Session_Namespace("messages");
		
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
		// Redireciona
		$this->_redirect("/admin/sobre/form/idsobre/1");
	}

	/**
	 * Ação executada após a atualização do registro
	 *
	 * @name doAfterUpdate
	 */
	public function doAfterUpdate() {
		// Busca o id do registro editado
		$id = $this->_request->getParam("idsobre", 0);

		// Executa o mesmo método que o insert
		$this->doAfterInsert($id);
	}

}
