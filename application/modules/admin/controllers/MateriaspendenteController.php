<?php

/**
 * Controlador
 *
 * @name Admin_MateriaspendenteController
 */
class Admin_MateriaspendenteController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_MateriasPendente
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_MateriasPendente();
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
			->where("status = ?", "pendente")
			->order("atualizadoEm DESC");

		// Continua a execução
		return $select;
	}

	/**
	 * Hook para a edição do usuário
	 * 
	 * @name doBeforeUpdate
	 * @param array $data Valores à serem editados
	 */
	public function doBeforeUpdate($data) {
		
		// Verifica se está marcado como rascunho
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


}