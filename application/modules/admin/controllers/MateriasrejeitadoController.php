<?php

/**
 * Controlador
 *
 * @name Admin_MateriasrejeitadoController
 */
class Admin_MateriasrejeitadoController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_MateriasRejeitado
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_MateriasRejeitado();
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
			// Busca apenas as matérias com os status "Rejeitado"
			->where("status = ?", "rejeitado")
			// Busca apenas as matérias escritas pelo usuário logado por meio do Id do Usuário salvo na sessão durante o Login
			->where("autorId = ?", $id)
			->order("atualizadoEm DESC");

		// Continua a execução
		return $select;
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

	/**
	 * Hook para a edição do usuário
	 * 
	 * @name doBeforeUpdate
	 * @param array $data Valores à serem editados
	 */
	public function doBeforeUpdate($data) {

		// Troca os status para pendete novamente
		$data['status'] = "pendente";

		// Retorna os dados para o framework
		return $data;
	}


}