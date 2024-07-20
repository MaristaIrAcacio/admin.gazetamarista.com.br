<?php

/**
 * Controlador
 *
 * @name Admin_BlogsController
 */
class Admin_BlogsController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Blogs
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Blogs();

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
		// Monta a query
		$select
            ->order("data DESC")
			->order("idblog DESC");

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
		// Param
		$idblog = $this->_request->getParam("idblog", 0);

		// Verifica se está editando
		if($idblog > 0) {
			$this->view->idblog = $idblog;
		}

		// Retorna os dados
		return $data;
	}

	/**
	 * Preview do post
	 *
	 */
	public function previewAction() {
		// Set Layout
        $this->_helper->layout->setLayout('admin-limpo');
	}

	/**
	 * Análise de SEO do post
	 *
	 */
	public function seoAction() {
		// Desabilita os layouts
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        // Verifica se foi enviado um post
        if($this->_request->isPost()) {
        	// Instancia a análise
        	$seoanalise = new gazetamarista_SEOanalise();
        	$resposta = $seoanalise->seo($_POST);
        }else{
        	// ERRO
            $resposta = array(
                'status' => 'erro',
                'itens' => '',
            );
        }

        // Retorno
        $this->_helper->json($resposta);
	}
}