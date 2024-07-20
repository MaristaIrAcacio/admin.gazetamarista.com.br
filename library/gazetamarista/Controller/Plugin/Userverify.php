<?php

/**
 * Cria o plugin da verificação do usuario
 *
 * @name gazetamarista_Controller_Plugin_Userverify
 */
class gazetamarista_Controller_Plugin_Userverify extends Zend_Controller_Plugin_Abstract {
	/**
	 * Método da classe
	 * 
	 * @name includejs
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		// Busca o view
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
		$viewRenderer->initView();
		$view = $viewRenderer->view;
		
		// Verifica se é o admin
		if($request->getModuleName() == "admin") {
			// Captura o domínio atual
			if( APPLICATION_ENV == 'development' ){
				$arryadominio = explode("/", $_SERVER['REQUEST_URI']);
				$dominio = $arryadominio[1];
			}else{
				$dominio = $_SERVER['SERVER_NAME'];
			}

			// Busca a sessão
			$session = new Zend_Session_Namespace("loginadmin");
		
			$auth = Zend_Auth::getInstance();

			// Verifica se o login está correto e a url atual do login
			if($auth->hasIdentity() && $session->urlatual == md5($dominio)) {
				// Assina as variaveis
				$view->logged = TRUE;
				$view->logged_usuario = $session->logged_usuario;
			}else{
				// Busca o basepath
				$options = Zend_Registry::get("config");
				$basePath = $options->gazetamarista->config->basepath;
					
				// Verifica se action acessada é o de usuarios->login ou usuarios->reset
				if( ($request->getControllerName() != "usuarios") || 
					($request->getControllerName() == "usuarios" && $request->getActionName() != "login" && $request->getActionName() != "reset")
				) {
					// Armazena qual tela retornar após o login
                    if(!empty($_SERVER['REDIRECT_SCRIPT_URI'])) {
                        $session->urlretornar = $_SERVER['REDIRECT_SCRIPT_URI'];
                    }else{
                        $session->urlretornar = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    }

				    $this->getResponse()->setRedirect($basePath . "/admin/usuarios/login")->sendResponse();
				}
			}
		}	
	}
}