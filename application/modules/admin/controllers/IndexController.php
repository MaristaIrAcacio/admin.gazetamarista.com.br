<?php

/**
 * Controlador da Dashboard
 */
class Admin_IndexController extends gazetamarista_Controller_Action {
	/**
	 *
	 */
	public function init() {
        // Init

        // Busca a sessão do login
		$this->session      = new Zend_Session_Namespace("loginadmin");
		$this->messages     = new Zend_Session_Namespace("messages");

		// Id user/perfil
		$this->idusuario 	= $this->session->logged_usuario['idusuario'];
		$this->idperfil 	= $this->session->logged_usuario['idperfil'];

		// Action
        $this->action		= $this->_request->getParam("action", "");

		// Retorna os dados do usuário
		$idUsuario = $this->session->logged_usuario['idusuario'];

		$select = (new Admin_Model_Usuarios())->select()
			->where("idusuario = ?", $idUsuario);

		$usuario = (new Admin_Model_Usuarios())->fetchRow($select);

		$this->view->usuario 	= $usuario;

	}

	/**
	 * Dashboard
	 */
	public function indexAction() {
		// Busca totais
        // $model = new Admin_Model_Usuarios();
		// $select = $model->select()
		// 	->from("usuarios", array(""))
		// 	->columns(array(
		// 	    'qtd_contato'  	=> new Zend_Db_Expr("(SELECT COUNT(idcontato) FROM contatos)"),
        //         'qtd_email' 	=> new Zend_Db_Expr("(SELECT COUNT(idemail) FROM emails)"),
        //         'qtd_servicos' 	=> new Zend_Db_Expr("(SELECT COUNT(idservico) FROM servicos)"),
        //         'qtd_noticias' 	=> new Zend_Db_Expr("(SELECT COUNT(idblog) FROM blogs)"),
		// 	))
		// 	->setIntegrityCheck(false);

		// $resumo = $model->fetchRow($select);

		// // Busca ultimos contatos
		// $select = $model->select()
		// 	->from("contatos", array("idcontato", "nome", "email", "data"))
		// 	->order("contatos.idcontato DESC")
		// 	->limit(13)
		// 	->setIntegrityCheck(false);

		// $contatos = $model->fetchAll($select);

		// // Busca ultimos emails
		// $select = $model->select()
		// 	->from("emails", array("idemail", "email", "data"))
		// 	->order("emails.idemail DESC")
		// 	->limit(13)
		// 	->setIntegrityCheck(false);

		// $emails = $model->fetchAll($select);

		// // Busca ultimas notícias
		// $select = $model->select()
		// 	->from("blogs", array("idblog", "titulo", "autor","data"))
		// 	->order("blogs.data DESC")
		// 	->limit(13)
		// 	->setIntegrityCheck(false);

		// $blogs = $model->fetchAll($select);

		// // Busca ultimas serviços
		// $select = $model->select()
		// 	->from("servicos", array("idservico", "titulo", "descricao"))
		// 	->order("servicos.ordenacao ASC")
		// 	->limit(13)
		// 	->setIntegrityCheck(false);

		// $servicos = $model->fetchAll($select);

		// // Assina para o template
		// $this->view->resumo     = $resumo;
		// $this->view->contatos   = $contatos;
		// $this->view->emails 	= $emails;
		// $this->view->blogs 	= $blogs;
		// $this->view->servicos 	= $servicos;

	}

	/**
	 * Método que busca os auto completes
	 *
	 * @name autocompleteAction
	 */
	public function autocompleteAction() {
		// Busca o termo passado
		$filter = $this->_request->getParam("term", "");

		// Inicializa os dados de retorno
		$data = array();

		// Busca o auto-complete passado
		$autocomplete = $this->_request->getParam("ac");

		// Verifica se existe tabela do autocomplete
		$ac_table = $this->_request->getParam("ac_table", NULL);
		if($ac_table !== NULL) {
			$ac_table = "U_" . $ac_table;
		}

		// Instancia o model
		$model = new $autocomplete($ac_table);

		// Verifica se existe query de autocomplete
		$ac_name = $this->_request->getParam("ac_name", "default");

		// Busca o select
		$select = $model->getQueryAutoComplete($ac_name);

		// Busca o campo da chave primaria
		$primary_field = $model->getPrimaryField();
		$description_field = $model->getDescription();

		// Verifica se é um espaço, para mostrar tudo
		if($filter == " ") {
			$filter = "";
		}

		$filter = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $filter ) );

		$db = Zend_Registry::get("db");

		// Se informado um array no model
		if(is_array($description_field)) {
		    $sql_where_filtro = "LOWER(".$description_field[0].")" . " LIKE _utf8 " . $db->quote("%".strtolower($filter)."%") . " COLLATE utf8_general_ci";
		    $sql_where_filtro .= " OR " . "LOWER(".$description_field[1].")" . " LIKE _utf8 " . $db->quote("%".strtolower($filter)."%") . " COLLATE utf8_general_ci";

		    $description_field = $description_field[0];
        }else{
            $sql_where_filtro = "LOWER(".$description_field.")" . " LIKE _utf8 " . $db->quote("%".strtolower($filter)."%") . " COLLATE utf8_general_ci";
        }

		// Where like
		$select->where($sql_where_filtro);

		// Ordena
		$select->order($description_field);

		// Limita
		$select->limit(30);

		// Busca a query do auto-complete
		$records = $model->fetchAll($select);

		// Percorre os registros
		foreach($records as $row) {
			// Busca os valores iniciais
			$label = ($row[$description_field]);
			$value = $row[$primary_field[1]];
			$line = array('label' => $label, 'identifier' => $value);

			// Percorre as colunas para os valores adicionais
			foreach($row as $column_name => $column_value) {
				// Só adicionar caso não for chave primaria ou descrição da tabela
				if(($column_name != $description_field) && ($column_name != $primary_field[1])) {
					$line[$column_name] = $column_value;
				}
			}

			// Monta o vetor
			$data[] = $line;
		}

		// Desabilita o layout e da o parse para json
		$this->_helper->json($data);
	}
}
