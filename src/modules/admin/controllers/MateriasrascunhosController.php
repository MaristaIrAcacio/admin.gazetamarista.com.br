<?php

/**
 * Controlador
 *
 * @name Admin_MateriasController
 */
class Admin_MateriasrascunhosController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_MateriasRascunho
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_MateriasRascunho();
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
			// Busca apenas as matérias com os status "rascunho"
			->where("status = ?", "rascunho")
			// Busca apenas as matérias escritas pelo usuário logado por meio do Id do Usuário salvo na sessão durante o Login
			->where("autorId = ?", $id)
			->order("atualizadoEm DESC");

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
		
		$this->_notificacao = new Admin_Model_Notificacao();

		// Verifica se está marcado como rascunho
		$isRascunho = $data['isRascunho'];

		if ($isRascunho == 'Rascunho') {
			$data['status'] = "rascunho";
		} else if ($isRascunho == 'Aprovação'){

			$data['status'] = "pendente";

			// Manda notificação para os administradores sobre a nova matéria de rascunho
			$notif = array(
				"tipo" => "nova_materia_pendente"
			);
			
			// Insere o registro da notificação
			$this->_notificacao->insert($notif);

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

		$this->_notificacao = new Admin_Model_Notificacao();

		if ($isRascunho == 1) {
			$data['status'] = "rascunho";
		} else {
			$data['status'] = "pendente";

			// Manda notificação para os administradores sobre a nova matéria de rascunho
			$notif = array(
				"tipo" => "nova_materia_pendente"
			);
			
			// Insere o registro da notificação
			$this->_notificacao->insert($notif);
		};

		// Retorna os dados para o framework
		return $data;
	}


}