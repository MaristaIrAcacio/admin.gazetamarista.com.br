<?php

/**
 * Cria o plugin do commons
 *
 * @name gazetamarista_Controller_Plugin_Navigation
 */
class gazetamarista_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract {
	/**
	 * Método da classe
	 * 
	 * @name includejs
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		// Busca a sessão
		$session  = new Zend_Session_Namespace("loginadmin");
		$messages = new Zend_Session_Namespace("messages");
		
		// Busca o modulo
		$module = $request->getModuleName();
		if(empty($module)) {
			$module = "default";
		}
		
		// Busca o view
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
		$viewRenderer->initView();
		$view = $viewRenderer->view;

		// Assina a acao/controller e modulo para a view
		$view->currentController = $request -> getControllerName();
		$view->currentAction = $request -> getActionName();
		$view->currentModule = $request -> getModuleName();
		
		// Verifica se é o admin
		if($module == "admin") {
			// Verifica se está logado
			if(!isset($session->logged_usuario)) {
				return FALSE;
			}
			
			// Cria o filtro admin
			if($session->logged_usuario['idperfil'] > 0) {
				$where = "
					WHERE 
						T01.idperfil <= " . $session->logged_usuario['idperfil'] . "
				";
			}
			else {
				$where = "
					WHERE
						1 = 2
				";
			}
		
			// Cria o objeto de navegação
			$navigation = new Zend_Navigation();
			
			// Busca o objeto de conexão com o banco
			$db = Zend_Registry::get("db");
			
			// Busca os itens do menu do usuario logado
			$sql = "
				SELECT 
					T01.descricao as \"funcionalidade\",
					T01.modulo as \"modulo\",
					T01.controlador as \"controlador\",
					T01.acao as \"acao\",
					T01.parametros as \"parametros\",
					T02.descricao as \"categoria\",
					T02.icone as \"icone\"
				FROM 
					gm_menuitens T01
					INNER JOIN gm_menucategorias T02 USING(idcategoria)
				" . $where . "
				ORDER BY
				    T02.ordenacao,
					T02.descricao,					
					T01.descricao
			";
			
			$result = $db->query($sql);
			$list = $result->fetchAll();

			
			// Percorre os itens da consulta
			$category_name = "";
			$category = "";
			$i = 0;
			
			if(count($list) > 0) {
				foreach($list as $row) {
					if($row['controlador'] == $request->getControllerName()) {
						$view->openedController = $row['categoria'];
					}
					
					// Cria a categoria
					if($category_name != $row['categoria']) {
						$category_name = $row['categoria'];

						// Adiciona a categoria no menu
						if(is_array($category)) {
							$navigation->addPage($category);
						}
						
						// Cria uma nova categoria
						$category = array(
                            'icone' => $row['icone'],
							'label' => $row['categoria'],
							'uri'	=> "#",
							'pages'	=> array()
						);

					}

					// Verifica o começo da string de parametros
					if($row['parametros'][0] == "/") {
						$row['parametros'] = substr($row['parametros'], 1);
					}
					
					// Ajusta os parametros
					$params = array();
					$rParams = explode("/", $row['parametros']);
					for($j=0; $j<count($rParams); $j+=2) {
						$index = $rParams[$j];
						$params[$index] = $rParams[$j+1];
					}
					
					// Adiciona a pagina
					$category['pages'][$i++] = array(
						'label'			=> $row['funcionalidade'],
						'controller'	=> $row['controlador'],
						'action'		=> $row['acao'],
						'module'		=> $row['modulo'],
						'params'		=> $params
					);
					
				}

				// Adiciona o ultimo laço
				$navigation->addPage($category);

				// Adiciona a navegação ao view
				$view->navigation($navigation);
				$view->navigation()->menu()->setUlClass('off-canvas-list');
			}else{
				if($request->getControllerName() != "usuarios" && $request->getActionName() != "login") {
					// Limpa usuário logado
					Zend_Auth::getInstance()->clearIdentity();
						
					$config = Zend_Registry::get('config');
					$basePath = $config->gazetamarista->config->basepath;
			
					$messages->error = "Efetue o login novamente";
					$this->getResponse()->setRedirect($basePath . "/admin/usuarios/login")->sendResponse();
				}
			}
		}
		
		// Assina a acao/controller e modulo para a view
		$view->currentController = $request->getControllerName();
		$view->currentAction = $request->getActionName();
		$view->currentModule = $request->getModuleName();
	}
}