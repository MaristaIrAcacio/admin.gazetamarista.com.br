<?php
/**
 * Analisa o status do login do usuário
 *
 * @name gazetamarista_Validalogin
 * @author Rossi - gazetamarista
 */
class gazetamarista_Validalogin {

	/**
	 * Armazena o nome do Dominio
	 *
	 * @access protected
	 * @name $dominio
	 * @var string
	 */
	protected $dominio;

	/**
	 * Armazena o nome do usuario
	 *
	 * @access protected
	 * @name $cliente
	 * @var string
	 */
	protected $cliente;

	/**
	 * Construct
	 */
	public function __construct() {
		// Url domínio
        $this->dominio = url_dominio();

		// Seta a sessão de usuário logado
        $this->cliente = new Zend_Session_Namespace("cliente");
	}

	/**
	 * Validação se o usuário está logado
     *
     * @param null $redirect string
     * @param null $type string
     * @param null $paramsroute array
	 */
	public function validar($redirectroute=null, $type=null, $paramsroute=[]) {
		// Redirector
		$_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');

		// Inicio
		$logado = FALSE;

        // Verifica sessão
        if($this->cliente->logado == TRUE && $this->cliente->dados->id > 0) {
            $logado = TRUE;
        }

		// Action atual
		$current_action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();

		// Verifica se o usuário está logado
        if($logado == TRUE) {
        	// LOGADO

            // Se for tela de login
            if($current_action == "login") {
                $_redirector->gotoRoute([], 'meus-dados');
            }
        }else{
        	// Força limpeza de sessão
        	$this->cliente->logado = FALSE;
        	if(!empty($redirectroute)) {
                Zend_Session::namespaceUnset("cliente");

                // Armazena o redirecionamento na sessão
                $this->cliente = new Zend_Session_Namespace("cliente");
                $this->cliente->redirect = $redirectroute;
                $this->cliente->redirectparams = $paramsroute;
            }

            // Verifica se o valida veio do ajaxController
        	if($type == "ajax") {
                // Erro
                $resposta = array(
                    'status'            => 'erro',
                    'titulo'            => 'Oops!',
                    'mensagem'          => 'Por favor efetue o login e tente novamente.',
                    'redirecionar_para' => url('login')
                );

        		print_r(json_encode($resposta));die();
        	}

            if($current_action != "login") {
	        	// Redirect para login
	        	$_redirector->setCode(301);
                $_redirector->gotoRoute([], 'login');
        	}
        }

        // Return
        return true;
	}
}
