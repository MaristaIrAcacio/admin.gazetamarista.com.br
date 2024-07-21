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
			->order("ultimaAlteracao DESC");

		// Continua a execução
		return $select;
	}

	/**
	 * Hook para ser executado antes do insert
	 *
	 * @access protected
	 * @name doBeforeInsert
	 * @param array $data Vetor com os valores à serem inseridos
	 * @return array
	 */
	protected function doBeforeInsert($data) {
		
		// Verifica se está marcado como rascunho
		$isRascunho = $data['isRascunho'];

		if ($isRascunho == 1) {
			$data['status'] = "rascunho";
		} else {
			$data['status'] = "pendente";
		};

		// Resgata o id do usuário da session
		$id = $this->session->logged_usuario['idusuario'];
		$data['autorId'] = $id;
		
		// Retorna os dados para o framework
		return $data;
	}

	/**
	 * Hook para a edição do usuário
	 * 
	 * @name doBeforeUpdate
	 * @param array $data Valores à serem editados
	 */
	public function doBeforeUpdate($data) {
		// Verifica se está marcado como rascunho
		$isRascunho = $data['isRascunho'];

		if ($isRascunho == 1) {
			$data['status'] = "rascunho";
		} else {
			$data['status'] = "pendente";
		};

		// Retorna os dados para o framework
		return $data;
	}


}