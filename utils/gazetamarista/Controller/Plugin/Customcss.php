<?php
	/**
	 * Cria o plugin do customcss
	 * 
	 * @name gazetamarista_Controller_Plugin_Customcss
	 */
	class gazetamarista_Controller_Plugin_Customcss extends Zend_Controller_Plugin_Abstract {
		/**
		 * Método da classe
		 * 
		 * @name includecss
		 */
		public function preDispatch(Zend_Controller_Request_Abstract $request) {
			// Recupera a requisição
				//$request = Zend_Controller_Front::getInstance()->getRequest();
			
			// Busca o basepath
				$options = Zend_Registry::get("config");
				$basePath = $options->gazetamarista->config->basepath;
			
			// Gera o caminho parcial do arquivo original
				$css_filename = $request->getModuleName() . "/" . $request->getControllerName() . "/" . $request->getActionName() . ".css";

			// Gera o caminho parcial do arquivo minificado
				$css_filename_min = $request->getModuleName() . "/" . $request->getControllerName() . "/" . $request->getActionName() . ".min.css";
			
			// Monta o caminho do arquivo original
				$local_css_file = APPLICATION_PATH . "/../common/application/css/" . $css_filename;
				$http_css_file = $basePath . "/common/application/css/" . $css_filename;		
			
			// Monta o caminho do arquivo minificado
				$local_cssmin_file = APPLICATION_PATH . "/../common/application/css/" . $css_filename_min;
				$http_cssmin_file = $basePath . "/common/application/css/" . $css_filename_min;
			
			// Verifica se o CSS minificado existe
				$string = "";
				if(file_exists($local_cssmin_file)) {
					$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
					$viewRenderer -> initView();
					$view = $viewRenderer -> view;
					
					$view -> headLink() -> appendStylesheet($http_cssmin_file, 'all');
				}else{
					// Verifica se o CSS original existe
						$string = "";
						if(file_exists($local_css_file)) {
							$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
							$viewRenderer -> initView();
							$view = $viewRenderer -> view;
							
							$view -> headLink() -> appendStylesheet($http_css_file, 'all');
						}
				}			
		}
	}
?>