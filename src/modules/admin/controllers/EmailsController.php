<?php

/**
 * Controlador dos E-mails
 *
 * @name Admin_EmailsController
 */
class Admin_EmailsController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Emails
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Emails();
		
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
			->order("idemail DESC");
		
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
		// Seta a sessão
		$messages = new Zend_Session_Namespace("messages");
		
		// Busca nome e email
		$nome 	= $this->_request->getParam("nome");
		$email 	= trim($this->_request->getParam("email"));
		
		// Verifica o e-mail
		if(!empty($email)) {
			$select_email = $this->_model->select()
				->where("email = ?", $email);
				
			$emailexiste = $this->_model->fetchRow($select_email);
			if($emailexiste) {
				// Existe o e-mail
				
				// Mensagem de erro
				$messages->error = "E-mail já existente";
				$this->_redirect($_SERVER["HTTP_REFERER"]);
			}else{
				// Não existe o e-mail
				
				// Armazena no insert a data-hora e ip
				$data['data'] = date("Y-m-d H:i:s");
				$data['ip'] = $_SERVER ['REMOTE_ADDR'];
			}
		}else{
			// Mensagem de erro
			$messages->error = "E-mail não informado";
			$this->_redirect($_SERVER["HTTP_REFERER"]);
		}
		
		// Retorna os dados para o framework
		return $data;
	}
	
	/**
	 * Hook para ser executado antes do update
	 *
	 * @access protected
	 * @name doBeforeUpdate
	 * @param array $data Vetor com os valores à serem atualizados
	 * @return array
	 */
	protected function doBeforeUpdate($data) {
		// Seta a sessão
		$messages = new Zend_Session_Namespace("messages");
		
		// Busca nome e email
		$idemail 	= $this->_request->getParam("idemail");
		$nome 		= $this->_request->getParam("nome");
		$email 		= trim($this->_request->getParam("email"));
		
		// Verifica o e-mail
		if(!empty($email)) {
			$select_email = $this->_model->select()
				->where("email = ?", $email)
				->where("idemail != ?", $idemail);
		
			$emailexiste = $this->_model->fetchRow($select_email);
			if($emailexiste) {
				// Existe o e-mail
		
				// Mensagem de erro
				$messages->error = "E-mail já existente";
				$this->_redirect($_SERVER["HTTP_REFERER"]);
			}else{
				// Não existe o e-mail
		
				// Retira a data-hora
				unset($data['data']);
			}
		}else{
			// Mensagem de erro
			$messages->error = "E-mail não informado";
			$this->_redirect($_SERVER["HTTP_REFERER"]);
		}
	
		return $data;
	}
}
