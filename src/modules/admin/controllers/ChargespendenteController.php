<?php

/**
 * Controlador
 *
 * @name Admin_MateriasController
 */
class Admin_ChargespendenteController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Chargespendente
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Chargespendente();
		$this->session = new Zend_Session_Namespace("loginadmin");
		
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
			->where('status = ?', "pendente")
			->order("titulo ASC");

		// Lógica de Visualização das Notificações
		(new Admin_Model_Notificacao())->delete("tipo = 'nova_charge_pendente'");

		return $select;
	}

	/**
	 * Hook para a edição do usuário
	 * 
	 * @name doBeforeUpdate
	 * @param array $data Valores à serem editados
	 */
	public function doBeforeUpdate($data) {
		
		$apontamentos       = $this->_request->getParam("apontamentos", "");

		if ($apontamentos && !empty($apontamentos)) {
			$data['apontamentos'] = $_POST['apontamentos'];
			$data['status'] = "rejeitado";
		} else {
			// Altera para publicada a notícia
			$data['status'] = "publicado";

			// Salva a hora da publicação
			$data['dataPublicacao'] = date('Y-m-d H:i:s');
		};

		// Retorna os dados para o framework
		return $data;
	}

	/**
	 * Hook executado antes a população do formulario
	 *
	 * @name doBeforePopulate
	 * @param array $data Vetor dos dados do formulario
	 * @return array
	 */
	public function doBeforePopulate($data) {
	
		// Joga os apontamentos para a view para serem renderizados
		$this->view->apontamentos = $data['apontamentos'];

		// Retorna os dados
		return $data;
	}



}