<?php
/**
 * Salva as alterações efetuadas no módulo default/admin (Log de ações)
 *
 * @name gazetamarista_Logatualizacoes
 * @author Rossi - gazetamarista
 */
class gazetamarista_Logatualizacoes {
	
	/**
	 * Cria o log de atualização do admin
	 *
	 */
	static public function salvaAtualizacao($action=NULL, $tabela=NULL, $data_antes=NULL, $data=NULL) {
		// Armazena as ações executadas

		// Sessão do login
		$session = new Zend_Session_Namespace("loginadmin");

		if($data_antes) {
			$data_antes = json_encode($data_antes);
		}

		if($data) {
			$data = json_encode($data);
		}
			
		// Monta os dados
		$data_insert 						= array();
		$data_insert['idusuario'] 			= $session->logged_usuario['idusuario'];
		$data_insert['nomeusuario'] 		= $session->logged_usuario['nome'] . ' (' . $session->logged_usuario['login'] . ')';
		$data_insert['modulo'] 				= 'admin';
		$data_insert['tabela'] 				= $tabela;
		$data_insert['json_data_antes'] 	= $data_antes;
		$data_insert['json_data'] 			= $data;
		$data_insert['acao_executada'] 		= $action;
		$data_insert['browser_sistema']		= json_encode($_SERVER["HTTP_USER_AGENT"]);
		$data_insert['data_execucao'] 		= date("Y-m-d H:i:s");
		$data_insert['ip'] 					= $_SERVER['REMOTE_ADDR'];

		// Seta o model dos logs
		try {
			(new Admin_Model_Logs())->insert($data_insert);
		}catch(Exception $e) {
			//throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
		}
	}

	/**
	 * Cria o log de erro
	 *
	 */
	static public function salvaErro($mensagem=NULL, $parametros=NULL, $erro=NULL) {
		// Armazena o erro retornado

		// Monta os dados
		$data_insert 						= array();
		$data_insert['data_execucao'] 		= date("Y-m-d H:i:s");
		$data_insert['mensagem'] 			= $mensagem;
		$data_insert['parametros'] 			= $parametros;
		$data_insert['browser_sistema']		= json_encode($_SERVER["HTTP_USER_AGENT"]);
        $data_insert['idusuario']		    = NULL;
        $data_insert['trace'] 			    = $erro;
		$data_insert['ip'] 					= $_SERVER['REMOTE_ADDR'];

		// Seta o model dos erros
		try {
			(new Admin_Model_Erros())->insert($data_insert);
		} catch(Exception $e) {
			//throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
		}
	}

	/**
	 * Cria o log de atividades do cliente
	 *
	 */
	static public function salvarAtividades($tabela="", $action="", $descricao="") {
		// Armazena as ações executadas

        // Sessão de usuário logado no módulo default
        $cliente = new Zend_Session_Namespace("cliente");

        // Monta os dados
		$data_insert 						= array();
		$data_insert['idcliente'] 			= $cliente->dados->idcliente;
		$data_insert['tabela'] 				= $tabela;
		$data_insert['acao_executada'] 		= $action;
		$data_insert['descricao'] 		    = $descricao;
		$data_insert['browser_sistema']		= json_encode($_SERVER["HTTP_USER_AGENT"]);
		$data_insert['data_execucao'] 		= date("Y-m-d H:i:s");
		$data_insert['ip'] 					= $_SERVER['REMOTE_ADDR'];

		try {
		    // Insert log de atividade
			(new Admin_Model_Clienteslogs())->insert($data_insert);
		}
		catch(Exception $e) {
			//throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
		}
	}
}
