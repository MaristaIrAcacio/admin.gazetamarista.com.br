<?php

/**
 * Controlador das Admin_WikiViewController
 *
 * @name Admin_WikiViewController
 */
class Admin_WikiViewController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Wiki
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Wiki();
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
			->where("autor = ?", $id)
			->order("data_modificacao DESC");

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
		
		// Resgata o id do usuário da session
		$id = $this->session->logged_usuario['idusuario'];
		$data['autor'] = $id;

		// Retorna os dados para o framework
		return $data;
	}



	/**
	 * Hook para ser executado antes do insert
	 *
	 * @access protected
	 * @name wiki
	 */
	protected function wikiAction () {

		$model_wiki = new Admin_Model_Wiki();
		$model_wiki_categorias = new Admin_Model_Wikicategoria();

		$select_Categorias = $model_wiki_categorias->select()
		->order('id ASC')
		->setIntegrityCheck(false);
		$result_categorias = $model_wiki_categorias->fetchAll($select_Categorias);




		$select_wikis = $model_wiki->select()
		->setIntegrityCheck(false);

		// Executa a consulta e obtém os resultados
		$result_wikis = $model_wiki->fetchAll($select_wikis);

		$config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path               = $path;
		$this->view->categorias         = $result_categorias;
		$this->view->wikis              = $result_wikis;

	}

	/**
	 * Hook para ser executado antes do insert
	 *
	 * @access protected
	 * @name wiki
	 */
	protected function wikidetalheAction () {

		$model_wiki = new Admin_Model_Wiki();
		$model_wiki_categorias = new Admin_Model_Wikicategoria();

		$select_Categorias = $model_wiki_categorias->select()
		->order('id ASC')
		->setIntegrityCheck(false);
		$result_categorias = $model_wiki_categorias->fetchAll($select_Categorias);




		$select_wikis = $model_wiki->select()
		->setIntegrityCheck(false);

		// Executa a consulta e obtém os resultados
		$result_wikis = $model_wiki->fetchAll($select_wikis);

		$this->view->categorias              = $result_categorias;
		$this->view->wikis              = $result_wikis;

	}

}