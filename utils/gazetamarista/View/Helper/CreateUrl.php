<?php 

class gazetamarista_View_Helper_CreateUrl {
	
	/**
	 * Cria a URL de modo simples
	 * 
	 * @name createurl
	 * @param string $action String com a ação
	 * @param string $controller String com o controlador
	 * @param string $module String com o modulo
	 * @param array $params Vetor com os parametros
	 * @param boolean $reset Reseta os parametros da url corrente
	 * @param boolean $encode Seta se a URL deve ser codificada
	 * @param string $rote Nome da rota
	 * @return string
	 */
	public function CreateUrl($action=NULL, $controller=NULL, $module=NULL, $params=array(), $reset=FALSE, $encode=TRUE, $rote="default") {
		// Inicializa a url
		$url = "";
		
		// Busca a rota
		$router = new Zend_Controller_Router_Rewrite();
		$request =  new Zend_Controller_Request_Http();
		$router->route($request);
		
		// Verifica se a ação é nula
		if($action == NULL) {
			// Busca a ação corrente
			$action = $request->getActionName();
		}
		
		// Verifica se o controlador é nulo
		if($controller == NULL) {
			// Busca o controlador corrente
			$controller = $request->getControllerName();
		}
		
		// Verifica se o modulo é nulo
		if($module == NULL) {
			// Busca o modulo corrente
			$module = $request->getModuleName();
		}
		
		// Cria o objeto para criar a URL
		$link = new Zend_View_Helper_Url();
		
		// Cria a URI
		$uri = array(
			"module"	=> $module,
			"controller"=> $controller,
			"action"	=> $action
		);
		
		// Junta a URI com os parametros
		$uri = array_merge($uri, $params);
		
		// Cria a URL
		$url = $link->url($uri, $rote, $reset, $encode);
		
		//
		return $url;
	}
}
