<?php

/**
 * Controlador
 *
 * @name Admin_RadioController
 */
class Admin_RadioController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Admin_Model_Radio
	 */
	protected $_model = NULL;

	/**
	 * Inicializa o controller
	 * 
	 * @name init
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Radio();
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
			->where("DATE(data) = CURDATE()");

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

		// Retorna os dados para o framework
		return $data;
	}

	/**
     * Ação para gerar HTMl para Impressão de um registro
     *
     * @access protected
     * @name exportpdfAction
     */
    protected function printAction() {
        // Desabilita os layouts
        $this->_helper->layout->disableLayout();

        // Passa para 600 segundo o max_execution_time
        set_time_limit(600);

        // Busca os parametros
        $idregistro = $this->_request->getParam("id", "");

        if($idregistro == "") {
            // Adiciona a mensagem de erro à sessão
            $this->_messages->error = "ID inválido. Tente novamente";
            $this->_redirect($_SERVER["HTTP_REFERER"]);
        }

        // Busca o campo da chave primaria
        $primary_field = $this->_model->getPrimaryField();

        // Cria os parametros
        $where = array();
        $paramsr = array();
        foreach($primary_field as $field) {
            // Verifica o parametro
            if($idregistro > 0) {
                $where[$field . " = ?"] = $idregistro;
                $paramsr[$field] = $idregistro;
            }

            break;
        }

        // Verifica se existe id passando por parametro
        if(!count($where) > 0) {
            // Mensagem de erro
            $this->_messages->error = "Item não selecionado corretamente";
            $this->_helper->redirector("list", NULL, NULL, $this->_requiredParam);
        }

        // Cria o formulario para visualizar
        $form = $this->_model->getForm("update");

		$registro = $this->_model->fetchRow($where);

		dd($registro);

		$dados = new stdClass();

		$dados = [
			'Data' => $registro->data,
			'Período' => $registro->periodo,
			'Período' => ()->fetchRow($where), // Faz o sistema de busca das chaves estrangeiras
		];


        // Busca o registro
        $data = $dados;
        $this->view->dados = $data;
        $this->view->idregistro = $idregistro;
    }

}