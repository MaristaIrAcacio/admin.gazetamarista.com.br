<?php

/**
 * Controlador
 *
 * @name Admin_ConfiguracoesController
 */
class Admin_ConfiguracoesController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Configuracoes
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Configuracoes();

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
		$this->_redirect("/admin/configuracoes/form/idconfiguracao/1");
	}

	/**
	 * Hook executado antes a população do formulario
	 *
	 * @name doBeforePopulate
	 * @param array $data Vetor dos dados do formulario
	 * @return array
	 */
	public function doBeforePopulate($data) {
		// Busca o id
		$idconfiguracao = $this->_request->getParam("idconfiguracao", 0);

		if($idconfiguracao == 0) {
		    // Redireciona
		    $this->_redirect("/admin/configuracoes/form/idconfiguracao/1");
        }
	
		// Assina na view o id
		$this->view->idconfiguracao = $idconfiguracao;
		$this->view->idperfil = $this->session->logged_usuario['idperfil'];

		// Retorna os dados
		return $data;
	}
}