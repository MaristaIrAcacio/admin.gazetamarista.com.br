<?php

/**
 * Cria o plugin do commons
 * 
 * @name gazetamarista_Controller_Plugin_Commons
 */
class gazetamarista_Controller_Plugin_Commons extends Zend_Controller_Plugin_Abstract {
	/**
	 * Método da classe
	 * 
	 * @name includejs
	 */
	public function preDispatch (Zend_Controller_Request_Abstract $request) {
		// Busca o view renderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
		$viewRenderer->initView();
		$view = $viewRenderer->view;
		
		// Busca o basepath
		$options = Zend_Registry::get("config");
		$basePath = $options->gazetamarista->config->basepath;
		
		// Busca os arquivos css do commons
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/commons.ini", "css");
		
		// Percorre os arquivos
		$module = (string)$request->getModuleName();

		foreach($config->$module as $file) {
			if( strpos($file, "http://") !== FALSE || strpos($file, "https://") !== FALSE || strpos($file, "//") !== FALSE ) {
				// Adiciona o arquivo
				$view->headLink()->appendStylesheet($file);
			}else {
				// Troca a palavra chave do modulo
				$file = str_replace(":module", $module, $file);

				$cssmin_file = str_replace(".css", ".min.css", $file);

				if(file_exists(APPLICATION_PATH . "/../" . $cssmin_file)) {
					// Adiciona o arquivo
						$view->headLink()->appendStylesheet($basePath . "/" . $cssmin_file, 'all');
				}else{
					// Adiciona o arquivo
						$view->headLink()->appendStylesheet($basePath . "/" . $file, 'all');
				}
			}
		}
		
		// Busca os arquivos js do commons
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/commons.ini", "js");
		
		// Percorre os arquivos js
		$module = (string)$request->getModuleName();
		foreach($config->$module as $file) {
			if( strpos($file, "http://") !== FALSE || strpos($file, "https://") !== FALSE || strpos($file, "//") !== FALSE ) {
				// Adiciona o arquivo
				$view->headScript()->appendFile($file);
			} else {
				// Troca a palavra chave do modulo
				$file = str_replace(":module", $module, $file);

				$jsmin_file = str_replace(".js", ".min.js", $file);

				if(file_exists(APPLICATION_PATH . "/../" . $jsmin_file)) {
					// Adiciona o arquivo
						$view->headScript()->appendFile($basePath . "/" . $jsmin_file);
				}else{
					// Adiciona o arquivo
						$view->headScript()->appendFile($basePath . "/" . $file);
				}
			}
		}
		
		// Busca os titulos do commons
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/commons.ini", "title");
		
		// Percorre os arquivos js
		$module = (string)$request->getModuleName();
		$view->headTitle($config->$module)->setSeparator(" | ");
	}
}