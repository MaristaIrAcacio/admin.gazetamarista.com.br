<?php

/**
 * Controlador
 *
 * @name Admin_MateriasController
 */
class Admin_ChargesController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Charges
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Charges();
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

		// Resgata o id do usuário da session
		$id = $this->session->logged_usuario['idusuario'];
		
		// Monta a query
		$select
			->where("autorId = ?", $id)
			->order("titulo ASC");

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

		// Troca para Pendente o status
		$data['status'] = "pendente";

		// Resgata o id do usuário da session
		$id = $this->session->logged_usuario['idusuario'];
		$data['autorId'] = $id;
		
		// Retorna os dados para o framework
		return $data;
	}




}