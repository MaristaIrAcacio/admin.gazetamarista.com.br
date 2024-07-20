<?php

/**
 * Cria o plugin do customjs
 * 
 * @name gazetamarista_Controller_Plugin_Customjs
 */
class gazetamarista_Controller_Plugin_Customjs extends Zend_Controller_Plugin_Abstract {
	/**
	 * Método da classe
	 * 
	 * @name includejs
	 */
	public function preDispatch (Zend_Controller_Request_Abstract $request) {
		// Recupera a requisição
			//$request = Zend_Controller_Front::getInstance()->getRequest();
		
		// Busca o basepath
			$options = Zend_Registry::get("config");
			$basePath = $options->gazetamarista->config->basepath;
		
		// Gera o caminho parcial do arquivo original
			$js_filename = $request->getModuleName() . "/" . $request->getControllerName() . "/" . $request->getActionName() . ".js";

		// Gera o caminho parcial do arquivo minificado
			$js_filename_min = $request->getModuleName() . "/" . $request->getControllerName() . "/" . $request->getActionName() . ".min.js";
		
		// Monta o caminho do arquivo original
		$local_js_file = APPLICATION_PATH . "/../common/application/js/" . $js_filename;
		$http_js_file = $basePath . "/common/application/js/" . $js_filename;

		// Monta o caminho do arquivo minificado
		$local_jsmin_file = APPLICATION_PATH . "/../common/application/js/" . $js_filename_min;
		$http_jsmin_file = $basePath . "/common/application/js/" . $js_filename_min;
		
		// Verifica se o js da ação existe
			$string = "";
			if(file_exists($local_jsmin_file)) {
				$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
				$viewRenderer -> initView();
				$view = $viewRenderer -> view;
				
				$view -> headScript() -> appendFile($http_jsmin_file);
			}else{
				// Verifica se o js da ação existe
					$string = "";
					if(file_exists($local_js_file)) {
						$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
						$viewRenderer -> initView();
						$view = $viewRenderer -> view;
						
						$view -> headScript() -> appendFile($http_js_file);
					}				
			}
		
	}
}
