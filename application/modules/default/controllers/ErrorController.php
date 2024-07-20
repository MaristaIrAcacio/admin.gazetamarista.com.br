<?php

/**
 * Controlador de erros
 *
 * @name ErrorController
 */
class ErrorController extends Zend_Controller_Action
{
    
    /**
     * Ação do erro
     *
     * @name errorAction
     */
    public function errorAction()
    {
        // Desabilita o layout e busca o handler de erro
        //$this->_helper->layout->disableLayout();
        $errors = $this->_getParam("error_handler");
        
        // Verifica se foi possivel bucar o erro
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = "You have reached the error page";
            return;
        }
        
        // Verifica o tipo do erro
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = "Page not found";
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = "Application error";
                break;
        }
        
        // Verifica se existe o erro
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }
        
        // Verifica erros de redirecionamentos
        if ($errors->exception->getMessage() == "Invalid controller specified (testes)") {
            $this->_redirect("teste-url");
        }
        
        // Não insere se for erros específicos
        if ($errors->exception->getMessage() != "Invalid controller specified (imagens)"
            && $errors->exception->getMessage() != "Invalid controller specified (favicon.ico)"
            && $errors->exception->getMessage() != "Invalid controller specified (robots.txt)"
            && $errors->exception->getMessage() != "Invalid controller specified (rss)"
            && $errors->exception->getMessage() != "Invalid controller specified (manager)"
            && $errors->exception->getMessage() != "Invalid controller specified (admin.php)"
            && $errors->exception->getMessage() != "Invalid controller specified (wp-login.php)"
            && $errors->exception->getMessage() != "Invalid controller specified (wordpress)"
            && $errors->exception->getMessage() != "Invalid controller specified (mkt)"
            && $errors->exception->getMessage() != "Invalid controller specified (wp-admin)"
            && $errors->exception->getMessage() != "Invalid controller specified (includes)"
            && $errors->exception->getMessage() != "Invalid controller specified (wp)"
            && $errors->exception->getMessage() != "Invalid controller specified (cms)"
            && $errors->exception->getMessage() != "Invalid controller specified (clickweb-logo.jpg)"
            && $errors->exception->getMessage() != "Invalid controller specified (css)"
            && $errors->exception->getMessage() != "Invalid controller specified (xmlrpc.php)"
            && $errors->exception->getMessage() != "Invalid controller specified (wp-content)"
            && $errors->exception->getMessage() != "Invalid controller specified (webmail)"
            && $errors->exception->getMessage() != "Invalid controller specified (administrator)"
        ) {
            
            // Verifica se deve exibir o erro
            if ($this->getInvokeArg("displayExceptions") == TRUE) {
                $this->view->exception = $errors->exception;
            }
            
            // Captura a session_id do usuário
            $unique_session_id = session_id();
            
            // Verifica se foi algum erro sequencial do mesmo ip em menos de 15 segundos
            if ($_SESSION['last_error_request'] > (time() - 15)) {
                // Não armazena o erro repetido
            } else {
                // Salva no banco de dados
                try {
                    $session = new Zend_Session_Namespace("loginadmin");
                    $model = new Admin_Model_Erros();
                    
                    $data = array();
                    $data['data_execucao'] = date("Y-m-d H:i:s");
                    $data['mensagem'] = $errors->exception->getMessage();
                    $data['parametros'] = json_encode($errors->request->getParams());
                    $data['browser_sistema'] = json_encode($_SERVER["HTTP_USER_AGENT"]);
                    $data['idusuario'] = $session->logged_usuario['idusuario'] > 0 ? $session->logged_usuario['idusuario'] : NULL;
                    $data['trace'] = $errors->exception->getTraceAsString();
                    $data['ip'] = $_SERVER ['REMOTE_ADDR'];
                    
                    $model->insert($data);
                    
                    // Session do tempo da ultima requisição de erro
                    $_SESSION['last_error_request'] = time();
                } catch (Exception $e) {
                    $extras = $e->getMessage();
                }
            }
            
            // Assina as variaveis
            $this->view->request = $errors->request;
            $this->view->extras = $extras;
            $this->view->displayexceptions = $this->getInvokeArg("displayExceptions");
            
            $this->view->assign("has_exception", TRUE);
            $this->view->assign("exception_message", $errors->exception->getMessage());
            $this->view->assign("trace", $errors->exception->getTraceAsString());
            $this->view->assign("params", $this->view->escape(var_export($errors->request->getParams(), TRUE)));
        }
        
        // Ativa o menu alternativo
        $this->view->alternative = true;
    }
    
    /**
     * Busca o log
     *
     * @name getLog
     */
    public function getLog()
    {
        // Busca o bootstrap
        $bootstrap = $this->getInvokeArg("bootstrap");
        if (!$bootstrap->hasResource("Log")) {
            return false;
        }
        
        // Busca o log
        $log = $bootstrap->getResource("Log");
        
        // Retorna o log
        return $log;
    }
}