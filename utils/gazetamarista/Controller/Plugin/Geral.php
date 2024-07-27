<?php

/**
 * Cria o plugin para carregar informações para todo o site
 *
 * @name gazetamarista_Controller_Plugin_Geral
 */
class gazetamarista_Controller_Plugin_Geral extends Zend_Controller_Plugin_Abstract
{
    /**
     * Método da classe
     *
     * @name preDispatch
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Busca as configurações
        $config = Zend_Registry::get("config");
        ini_set("session.cookie_domain", $config->gazetamarista->config->domain);
        
        // Busca o view
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("viewRenderer");
        $viewRenderer->initView();
        $view = $viewRenderer->view;
        
        // Captura a session_id do usuário
        $unique_session_id = session_id();
        
        // Script IP Anti DDoS *****************
        if (!isset($_SESSION)) { // Verifica se existe uma session ativa
            //session_start();
            ob_start('ob_gzhandler');
        }
        
        $IpUltimaRequisicao = $_SERVER['REMOTE_ADDR'];
        
        if ($_SESSION['last_session_request'] > (time() - 3)) {
            // Verifica o tempo da ultima solicitação, caso tenha menos de 3 segundos, exibe tela de erro
            
            // Verifica a quantidade em menos de 5 vezes
            if ($_SESSION[$unique_session_id . '_' . $IpUltimaRequisicao] > 5) {
                header("HTTP/1.0 503 Service Temporarily Unavailable");
                header("Connection: close");
                header("Content-Type: text/html");
                
                $_SESSION[$unique_session_id . '_' . $IpUltimaRequisicao] = 1;
                
                // die("A página foi atualizada muitas vezes rapidamente pelo seu IP " . $IpUltimaRequisicao . ", o site foi bloqueado temporariamente.");
            }
            
            $_SESSION[$unique_session_id . '_' . $IpUltimaRequisicao]++;
        } else {
            $_SESSION[$unique_session_id . '_' . $IpUltimaRequisicao] = 1;
        }
        
        $_SESSION['last_session_request'] = time(); // Cria uma session com o tempo da ultima solicitação
        // FIM Script IP Anti DDoS *****************

        // Redir helper
        $redir = new Zend_Controller_Action_Helper_Redirector();
        
        // Busca os titulos do commons
        $config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/commons.ini", "title");
        
        // Seta a sessão da configuracao do site
        $session_configuracao = new Zend_Session_Namespace("configuracao");
        
        // Captura dados de configuração do projeto
        $configuracao = (new Admin_Model_Configuracoes())->fetchRow(array("idconfiguracao = 1"));
        if ($configuracao) {
            $session_configuracao->dados = $configuracao;
        }
        
        // Seleciona o título e versão
        $module  = (string)$request->getModuleName();
        $_title  = $config->$module;
        $_versao = $config->admin;
        
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        
        if (substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], ".")) == ".jpg") {
            return TRUE;
        }
        
        if ($this->_request->getParam("module") == "admin") {
            $view->_permitidoAdicionar  = true;
            $view->_permitidoEditar     = true;
            $view->_permitidoExcluir    = true;
            $view->_permitidoVisulizar  = true;
            
            // return TRUE;
        } else {
        	// Sessão de mensagens
			$messages = new Zend_Session_Namespace("messages");

			// Sessão de usuário
			$cliente = new Zend_Session_Namespace("cliente");

            // // Páginas internas
            // $paginas = (new Admin_Model_Internas())->fetchAll(NULL, "ordenacao ASC");
            // $arr_paginas = array();
        	// foreach($paginas as $pag) {
        	// 	$arr_paginas[$pag->parametro] = $pag;
			// }

        	// Formas de pagamento
            // $formas_pagto = (new Admin_Model_Formaspagto())->fetchAll(array('ativo = ?' => 1), "ordenacao ASC");

        	// Validar cadastro de usuário completo
			$session_completed = new Zend_Session_Namespace("completed");
			if($session_completed->incompleto == true) {
				if(
					$this->_request->getParam("action") != 'editar-dados' &&
					$this->_request->getParam("action") != 'ajax-editar-dados' &&
					$this->_request->getParam("action") != 'logout'
				) {
					// Redirect editar dados
					$messages->warning = "Complete o seu cadastro para continuar.";
					redirect_route('editar-dados');
				}
			}

//            // Mensagem bloqueio do projeto
//            $msg_bloqueio = "ATENÇÃO! EM MANUTENÇÃO!!";
//
//            die('
//                <html lang="en">
//                <head>
//                  <meta charset="UTF-8">
//                  <title>' . $session_configuracao->dados->nome_site . '</title>
//                  <style>
//                    body{color: #666666;text-align: center;}
//                    .box{background-color: #fff;width: 595px;margin: 15px auto;}
//                    #title {font-size: 30px;margin-top: 25px;}
//                    #descricao{font-size:20px;margin: 20px auto;}
//                    #logo {margin-top: 25px;max-width: 500px;height: auto;}
//                  </style>
//                </head>
//                <body>
//                  <div class="box">
//                    <img src="' . $config->gazetamarista->config->domain . '/common/email/images/logo-cliente.png" id="logo" alt="Logo">
//                    <div id="title">' . $msg_bloqueio . '</div>
//                    <div id="descricao"></div>
//                  </div>
//                </body>
//                </html>
//            ');
        }

        // Assina na view
        $view->_title               = $_title;
        $view->_versao              = $_versao;
        $view->application_env      = APPLICATION_ENV;
        $view->protocolo            = $protocol;
        // $view->_paginas             = $arr_paginas;
        // $view->_formas_pagto 		= $formas_pagto;
        $view->unique_session_id    = $unique_session_id;
        $view->_configuracao        = $session_configuracao->dados;
        $view->_cliente             = $cliente->dados;
    }
}
