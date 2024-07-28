<?php

/**
 * Controlador da Dashboard
 */
class Admin_IndexController extends gazetamarista_Controller_Action
{
	/**
	 *
	 */
	public function init()
	{
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
	public function indexAction()
	{
		$model = new Admin_Model_Turma();

		// ---------------------------------------------------------------------------
		// |
		// | Lógica do gráfico de matérias escritas por série
		// |
		// ---------------------------------------------------------------------------

		$select_materias_por_turmas = $model->select()
		->from(array('s' => 'gm_serie'), array('serie' => 's.item'))
		->joinLeft(
			array('u' => 'usuarios'),
			's.idserie = u.serie',
			array() // Não seleciona colunas adicionais de usuários
		)
		->joinLeft(
			array('m' => 'gm_materias'),
			'u.idusuario = m.autorId',
			array('quantidade_materias' => new Zend_Db_Expr('COUNT(m.idNoticia)'))
		)
		->group('s.idserie') // Agrupa pelo id da série
		->order('s.item') // Ordena pelo nome da série
		->setIntegrityCheck(false);

		$result_materias_por_turma = $model->fetchAll($select_materias_por_turmas);

		// Inicialize arrays para labels e dados
		$labels_materias_por_turma = [];
		$data_materias_por_turma = [];

		// Itere sobre os resultados da consulta
		foreach ($result_materias_por_turma as $row) {
			$labels_materias_por_turma[] = $row->serie; // Nome da série
			$data_materias_por_turma[] = (int) $row->quantidade_materias; // Quantidade de matérias
		}

		// Prepare os dados do gráfico
		$chartData_materias_por_turma = [
			'labels' => $labels_materias_por_turma,
			'datasets' => [
				[
					'label' => 'Matérias Postadas',
					'backgroundColor' => '#016090',
					'borderColor' => '#016090',
					'borderWidth' => 1,
					'data' => $data_materias_por_turma
				]
			]
		];

		// ---------------------------------------------------------------------------
		// |
		// | Lógica do gráfico de charges escritas por série
		// |
		// ---------------------------------------------------------------------------
		$select_charges_por_turmas = $model->select()
		->from(array('s' => 'gm_serie'), array('serie' => 's.item'))
		->joinLeft(
			array('u' => 'usuarios'),
			's.idserie = u.serie',
			array() // Não seleciona colunas adicionais de usuários
		)
		->joinLeft(
			array('m' => 'gm_charges'),
			'u.idusuario = m.autorId',
			array('quantidade' => new Zend_Db_Expr('COUNT(m.idCharges)'))
		)
		->group('s.idserie') // Agrupa pelo id da série
		->order('s.item') // Ordena pelo nome da série
		->setIntegrityCheck(false);

		$result_charges_por_turma = $model->fetchAll($select_charges_por_turmas);

		// Inicialize arrays para labels e dados
		$labels_charges_por_turma = [];
		$data_charges_por_turma = [];

		// Itere sobre os resultados da consulta
		foreach ($result_charges_por_turma as $row) {
			$labels_charges_por_turma[] = $row->serie; // Nome da série
			$data_charges_por_turma[] = (int) $row->quantidade; // Quantidade de matérias
		}

		// Prepare os dados do gráfico
		$chartData_charges_por_turma = [
			'labels' => $labels_charges_por_turma,
			'datasets' => [
				[
					'label' => 'Charges Postadas',
					'backgroundColor' => '#034e78',
					'borderColor' => '#034e78',
					'borderWidth' => 1,
					'data' => $data_charges_por_turma
				]
			]
		];


		// ---------------------------------------------------------------------------
		// |
		// | Lógica do gráfico de matéria por categorias
		// |
		// ---------------------------------------------------------------------------
		// Consultar as categorias e a quantidade de matérias em cada uma
		$select_categorias_materias = $model->select()
		->from(array('c' => 'gm_categorias'), array('categoria' => 'c.nome'))
		->joinLeft(
			array('m' => 'gm_materias'),
			'c.idCategorias = m.categoriaId',
			array('quantidade_materias' => new Zend_Db_Expr('COUNT(m.idNoticia)'))
		)
		->group('c.idCategorias')
		->order('c.nome')
		->setIntegrityCheck(false);

		$result_categorias_materias = $model->fetchAll($select_categorias_materias);

		// Inicialize arrays para labels e dados
		$labels_categorias_materias = [];
		$data_categorias_materias = [];

		// Itere sobre os resultados da consulta
		foreach ($result_categorias_materias as $row) {
			$labels_categorias_materias[] = $row->categoria;
			$data_categorias_materias[] = (int) $row->quantidade_materias;
		}

		// Prepare os dados do gráfico
		$chartData_categorias_materias = [
			'labels' => $labels_categorias_materias,
			'datasets' => [
				[
					'label' => 'Matérias por Categoria',
					'backgroundColor' => [
						'#034e78', '#016090', '#003a62', '#a6d1ee', '#2099c4', '#09afeb'
					],
					'data' => $data_categorias_materias
				]
			]
		];



		
		// ---------------------------------------------------------------------------
		// |
		// | Lógica do gráfico de colaboração dos redatores
		// |
		// ---------------------------------------------------------------------------
		// Consultar os usuários e a quantidade de colaborações de cada um, ordenado por quantidade de colaborações
		$select_colaboracoes_por_usuario = $model->select()
		->from(array('u' => 'usuarios'), array('usuario' => 'u.nome'))
		->joinLeft(
			array('m' => 'gm_materias'),
			'u.idusuario = m.colaboradorId',
			array('quantidade_colaboracoes' => new Zend_Db_Expr('COUNT(m.idNoticia)'))
		)
		->group('u.idusuario')
		->order('quantidade_colaboracoes DESC')
		->limit(10)
		->setIntegrityCheck(false);

		$result_colaboracoes_por_usuario = $model->fetchAll($select_colaboracoes_por_usuario);

		// Inicialize arrays para labels e dados
		$labels_colaboracoes_por_usuario = [];
		$data_colaboracoes_por_usuario = [];

		// Itere sobre os resultados da consulta
		foreach ($result_colaboracoes_por_usuario as $row) {
		$labels_colaboracoes_por_usuario[] = $row->usuario;
		$data_colaboracoes_por_usuario[] = (int) $row->quantidade_colaboracoes;
		}

		// Prepare os dados do gráfico
		$chartData_colaboracoes_por_usuario = [
		'labels' => $labels_colaboracoes_por_usuario,
		'datasets' => [
			[
				'label' => 'Colaborações',
				'backgroundColor' => '#034e78',
				'borderColor' => '#034e78',
				'borderWidth' => 1,
				'data' => $data_colaboracoes_por_usuario
			]
		]
		];


		// ---------------------------------------------------------------------------
		// |
		// | Lógica do gráfico de quantidade de matérias por status
		// |
		// ---------------------------------------------------------------------------
		// Consultar a quantidade de matérias por status
		$select_status_materias = $model->select()
			->from('gm_materias', array('status', 'quantidade' => new Zend_Db_Expr('COUNT(*)')))
			->group('status')
			->order('status')
			->setIntegrityCheck(false);

		$result_status_materias = $model->fetchAll($select_status_materias);

		// Inicialize arrays para labels e dados
		$labels_status_materias = [];
		$data_status_materias = [];
		$colors_status_materias = [
			'rascunho' => '#034e78',
			'pendente' => '#016090',
			'publicado' => '#003a62',
			'rejeitado' => '#a5d1ee'
		];

		// Itere sobre os resultados da consulta
		foreach ($result_status_materias as $row) {
		$labels_status_materias[] = ucfirst($row->status); // Capitaliza a primeira letra do status
		$data_status_materias[] = (int) $row->quantidade;
		}

		// Prepare os dados do gráfico
		$chartData_status_materias = [
		'labels' => $labels_status_materias,
		'datasets' => [
			[
				'label' => 'Status das Matérias',
				'backgroundColor' => array_values($colors_status_materias),
				'data' => $data_status_materias
			]
		]
		];



		// Assina na view os dados dos gráficos
		$this->view->grapf_materias_por_turma 	        = json_encode($chartData_materias_por_turma);
		$this->view->grapf_charges_por_turma 	        = json_encode($chartData_charges_por_turma);
		$this->view->graph_categorias_materias          = json_encode($chartData_categorias_materias);
		$this->view->graph_colaboracoes_por_usuario     = json_encode($chartData_colaboracoes_por_usuario);
		$this->view->graph_status_materias              = json_encode($chartData_status_materias);

	}

	/**
	 * Método que busca os auto completes
	 *
	 * @name autocompleteAction
	 */
	public function autocompleteAction()
	{
		// Busca o termo passado
		$filter = $this->_request->getParam("term", "");

		// Inicializa os dados de retorno
		$data = array();

		// Busca o auto-complete passado
		$autocomplete = $this->_request->getParam("ac");

		// Verifica se existe tabela do autocomplete
		$ac_table = $this->_request->getParam("ac_table", NULL);
		if ($ac_table !== NULL) {
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
		if ($filter == " ") {
			$filter = "";
		}

		$filter = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $filter));

		$db = Zend_Registry::get("db");

		// Se informado um array no model
		if (is_array($description_field)) {
			$sql_where_filtro = "LOWER(" . $description_field[0] . ")" . " LIKE _utf8 " . $db->quote("%" . strtolower($filter) . "%") . " COLLATE utf8_general_ci";
			$sql_where_filtro .= " OR " . "LOWER(" . $description_field[1] . ")" . " LIKE _utf8 " . $db->quote("%" . strtolower($filter) . "%") . " COLLATE utf8_general_ci";

			$description_field = $description_field[0];
		} else {
			$sql_where_filtro = "LOWER(" . $description_field . ")" . " LIKE _utf8 " . $db->quote("%" . strtolower($filter) . "%") . " COLLATE utf8_general_ci";
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
		foreach ($records as $row) {
			// Busca os valores iniciais
			$label = ($row[$description_field]);
			$value = $row[$primary_field[1]];
			$line = array('label' => $label, 'identifier' => $value);

			// Percorre as colunas para os valores adicionais
			foreach ($row as $column_name => $column_value) {
				// Só adicionar caso não for chave primaria ou descrição da tabela
				if (($column_name != $description_field) && ($column_name != $primary_field[1])) {
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
