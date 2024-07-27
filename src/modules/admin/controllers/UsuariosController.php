<?php

/**
 * Controlador dos usuarios
 *
 * @name UsuariosController
 */
class Admin_UsuariosController extends gazetamarista_Controller_Action {
	/**
	 * Armazena o model padrão da tela
	 *
	 * @access protected
	 * @name $_model
	 * @var Default_Model_Usuarios
	 */
	protected $_model = NULL;

	/**
	 *
	 */
	public function init() {
		// Inicializa o model da tela
		$this->_model = new Admin_Model_Usuarios();

		// Busca a sessão do login
		$this->session = new Zend_Session_Namespace("loginadmin");
		$this->messages = new Zend_Session_Namespace("messages");
		
		// Chama o parent
		parent::init();
	}

	/**
	 * Hook para ser executado antes do insert
	 *
	 * @access protected
	 * @name doBeforeInsert
	 * @param array $data Vetor com os valores à serem inseridos
	 * @return array
	 */
	protected function doBeforeInsert($data) {
		// Verifica se já possui o login
		$result = $this->_model->fetchRow(array('login = ?' => $data['login']));
		if(count($result) > 0) {
			// Erro
			$this->messages->error = "Login já existente. Informe outro.";
			$this->_helper->redirector("form", "usuarios", "admin");
		}
		
		if(empty($data['senha'])) {
			unset($data['senha']);
		}else{
			$data['senha'] = md5($data['senha']);
		}
	
		// Retorna os dados para o framework
		return $data;
	}

	/**
	 * Hook executado após a inserção do registro
	 *
	 * @name doAfterInsert
	 * @param int $id Código ID inserido
	 */
	public function doAfterInsert($id) {
	    if($this->_request->getParam("idperfil", 0) == 2) {
                $data_update = array('sendmail' => date("Y-m-d H:i:s"));
				$this->_model->update($data_update, array('idusuario = ?' => $id));
        }
    }
	
	/**
	 * Hook para a edição do usuário
	 * 
	 * @name doBeforeUpdate
	 * @param array $data Valores à serem editados
	 */
	public function doBeforeUpdate($data) {
		// Id usuario editado
		$idusuario = $this->_request->getParam("idusuario", 0);

		// Verifica se já possui o login
		$result = $this->_model->fetchRow(array('login = ?' => $data['login'], 'idusuario != ?' => $idusuario));
		if(count($result) > 0) {
			// Erro
			$this->messages->error = "Login já existente. Informe outro.";
			$this->_helper->redirector("list", "usuarios", "admin");
		}

		if(empty($data['senha'])) {
			unset($data['senha']);
		}else{
			$data['senha'] = md5($data['senha']);
		}
		
		return $data;
	}
	
	/**
	 * Hook para execução antes da listagem dos usuários
	 * 
	 * @name doBeforeList
	 * @return Zend_Db_Select
	 */
	public function doBeforeList($select) {
		// Cria o select
		$select
			->where("idperfil <= ?", $this->session->logged_usuario['idperfil']);
		
		// Retorna o select para criar a lista
		return $select;
	}

	/**
	 * Acao login
	 *
	 * @name loginAction
	 */
	public function loginAction() {
		// Desabilita o layout
		$this->_helper->layout->disableLayout();

		// Captura o domínio atual
		if( APPLICATION_ENV == 'development' ){
			$arryadominio = explode("/", $_SERVER['REQUEST_URI']);
			$dominio = $arryadominio[1];
		}else{
			$dominio = $_SERVER['SERVER_NAME'];
		}

		// Busca a instancia do zend_auth
		$auth = Zend_Auth::getInstance();

		// Verifica se está logado e a url atual do login
		if($auth->hasIdentity() && $this->session->urlatual == md5($dominio)) {
			$this->_helper->redirector(NULL, NULL, "admin");
		}

		// Cria o formulario de login
		$form = $this->createLoginForm();

		// Verifica se tem dados vindo do formulario
		if($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			
			// Verifica se o formulario é valido
			if($form->isValid($data)) {
				// Busca as informações do login
				$login = $form->getValue("login");
				$senha = $form->getValue("senha");

				// Busca as informações do usuario por login ou email
				$select = $this->_model->select()
					->where("login = ?", $login)
					->orwhere("email = ?", $login)
					->limit(1);

				$usuario_row = $this->_model->fetchRow($select);
				if($usuario_row) {
					// Converte em array
					$usuario_row = $usuario_row->toArray();
				}else{
					// Monta os dados de LOG de acesso
					$insert_data 					= array();
					$insert_data['idusuario'] 		= null;
					$insert_data['tabela'] 			= "usuarios";
					$insert_data['json_data_antes'] = "";
					$insert_data['json_data'] 		= json_encode(array("login" => $login));
					$insert_data['acao_executada'] 	= "LOGIN-ERRO";
					$insert_data['browser_sistema']	= json_encode($_SERVER["HTTP_USER_AGENT"]);
					$insert_data['data_execucao'] 	= date("Y-m-d H:i:s");
					$insert_data['ip'] 				= $_SERVER['REMOTE_ADDR'];
					
					// Cria o model dos logs
					$model_logs = new Admin_Model_Logs();
					try {
						$model_logs->insert($insert_data);
					}
					catch(Exception $e) {
						//throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
					}
					
					// Erro
					$this->messages->error = "Usuário informado não existe no sistema.";
					$this->_helper->redirector("login", "usuarios", "admin");
				}

				// Busca a instancia de Zend_Auth
				$objAuth = Zend_Auth::getInstance();

				// Efetua o acesso pelo campo de login
				$authAdapter = new Zend_Auth_Adapter_DbTable(
				Zend_Registry::get("db"),
					"usuarios",
					"login",
					"senha",
					"md5(?)"
				);

				// Define os dados para processar o campo de login
				$authAdapter->setIdentity($login)->setCredential($senha);

				// Efetua o campo de login
				$result = $objAuth->authenticate($authAdapter);

				// Efetua acesso pelo campo de email
				$authAdapter2 = new Zend_Auth_Adapter_DbTable(
					Zend_Registry::get("db"),
					"usuarios",
					"email",
					"senha",
					"md5(?)"
				);

				// Define os dados para processar o campo de email
				$authAdapter2->setIdentity($login)->setCredential($senha);

				// Efetua o campo de email
				$result2 = $objAuth->authenticate($authAdapter2);

				// Verifica se o login/email está correto
				if($result->isValid() || $result2->isValid()) {
					// Armazena os dados do usuário em sessão, apenas desconsiderando a senha do usuário
					$info = $authAdapter->getResultRowObject(NULL, "senha");
					$objAuth->getStorage()->write($info);
						
					// remove coluna da senha
					unset($usuario_row['senha']);

					// Adiciona as informações à sessão
					$this->session->logged_usuario = $usuario_row;

					// Armazena na sessão a url atual de acesso
					$this->session->urlatual = md5($dominio);

					// Monta os dados de LOG de acesso
					$insert_data 					= array();
					$insert_data['idusuario'] 		= null;
					$insert_data['tabela'] 			= "usuarios";
					$insert_data['json_data_antes'] = "";
					$insert_data['json_data'] 		= json_encode($usuario_row);
					$insert_data['acao_executada'] 	= "LOGIN-OK";
					$insert_data['browser_sistema']	= json_encode($_SERVER["HTTP_USER_AGENT"]);
					$insert_data['data_execucao'] 	= date("Y-m-d H:i:s");
					$insert_data['ip'] 				= $_SERVER['REMOTE_ADDR'];
					
					// Cria o model dos logs
					$model_logs = new Admin_Model_Logs();
					try {
						$model_logs->insert($insert_data);
					}
					catch(Exception $e) {
						//throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
					}
						
					// Verificar para qual página redirecionar
                    if(!empty($this->session->urlretornar)) {
                        $retornando = $this->session->urlretornar;
                        $this->session->urlretornar = "";
                        $this->_redirect($retornando);
                    }else{
                        // Redireciona o usuario
					    $this->_helper->redirector(NULL, NULL, "admin");
                    }
				}else{
					// Monta os dados de LOG de acesso
					$insert_data 					= array();
					$insert_data['idusuario'] 		= null;
					$insert_data['tabela'] 			= "usuarios";
					$insert_data['json_data_antes'] = "";
					$insert_data['json_data'] 		= json_encode(array("login" => $login));
					$insert_data['acao_executada'] 	= "LOGIN-ERRO";
					$insert_data['browser_sistema']	= json_encode($_SERVER["HTTP_USER_AGENT"]);
					$insert_data['data_execucao'] 	= date("Y-m-d H:i:s");
					$insert_data['ip'] 				= $_SERVER['REMOTE_ADDR'];
					
					// Cria o model dos logs
					$model_logs = new Admin_Model_Logs();
					try {
						$model_logs->insert($insert_data);
					}
					catch(Exception $e) {
						//throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
					}

					// Erro
					$this->messages->error = "Os dados informados (e-mail e/ou senha) não são válidos.";
					$this->_helper->redirector("login", "usuarios", "admin");
				}
			}else{
				// Monta os dados de LOG de acesso
				$insert_data 					= array();
				$insert_data['idusuario'] 		= null;
				$insert_data['tabela'] 			= "usuarios";
				$insert_data['json_data_antes'] = "";
				$insert_data['json_data'] 		= json_encode("Formulário inválido");
				$insert_data['acao_executada'] 	= "LOGIN-ERRO";
				$insert_data['browser_sistema']	= json_encode($_SERVER["HTTP_USER_AGENT"]);
				$insert_data['data_execucao'] 	= date("Y-m-d H:i:s");
				$insert_data['ip'] 				= $_SERVER['REMOTE_ADDR'];
				
				// Cria o model dos logs
				$model_logs = new Admin_Model_Logs();
				try {
					$model_logs->insert($insert_data);
				}
				catch(Exception $e) {
					//throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
				}

				// Erro
				$this->messages->error = "Os dados informados (e-mail e/ou senha) não são válidos.";
				$this->_helper->redirector("login", "usuarios", "admin");
			}
		}
	}

	/**
	 * Ação que efetua o logout do usuario
	 *
	 * @name logoutAction
	 */
	public function logoutAction() {
		// Disable
		$this->_helper->layout->disableLayout();

		// Remove as credenciais
		Zend_Auth::getInstance()->clearIdentity();

		// Limpa sessão de usuário do admin
        Zend_Session::namespaceUnset("loginadmin");

		// Redireciona
		$this->_helper->redirector("login", "usuarios", "admin");
	}

	/**
	 * Cria o formulario de login
	 *
	 * @access protected
	 * @name createLoginForm
	 * @return Zend_Form
	 */
	protected function createLoginForm() {
		// Cria o formulario
		$form = new Zend_Form();

		// Cria o action
		$url = $this->view->url(array('module'=>"default", 'controller'=>"usuarios", 'action'=>"login"), NULL, TRUE);
		$form->setAction($url);

		// Cria o input de login
		$login = new Zend_Form_Element_Text("login");
		$login->setLabel("Login/email")
			->setRequired(TRUE)
			->addFilter("StripTags")
			->addFilter("StringTrim")
			->addValidator("NotEmpty");

		// Cria o input de senha
		$senha = new Zend_Form_Element_Password("senha");
		$senha->setLabel("Senha")
			->setRequired(TRUE)
			->addFilter("StripTags")
			->addFilter("StringTrim")
			->addValidator("NotEmpty");
		
		// Cria o botão de entrar
		$submit = new Zend_Form_Element_Submit("submit");
		$submit->setLabel("Entrar")
			->setAttrib("id", "submit");

		// Adiciona os elementos
		$form->addElements(array($login, $senha, $submit));

		// Retorna o formulario
		return $form;
	}
	
	/**
	 * Ação para trocar as senhas
	 * 
	 * @name trocarsenhaAction
	 */
	public function trocarsenhaAction() {
		// Verifica se é post
		if($this->_request->isPost()) {
			// Busca os dados do formulario
			$senha_atual 		= md5($this->_request->getParam("senha_atual"));
			$senha_nova 		= $this->_request->getParam("senha_nova");
			$senha_confirmar 	= $this->_request->getParam("senha_confirmar");
			
			// Armazena o id do usuario logado
			$idusuario = $this->session->logged_usuario['idusuario'];
			
			// Verifica se a senha atual está correta
			$result = $this->_model->fetchAll(array('idusuario = ?' => $idusuario, 'senha = ?' => $senha_atual))->toArray();
			if(count($result) > 0) {
				$data = array('senha' => md5($senha_nova));
				$this->_model->update($data, array('idusuario = ?' => $idusuario));

				// Sucesso
				$this->messages->success = "Senha alterado com sucesso!";
				$this->_helper->redirector("index", "index", "admin");
			}else{
				// Erro
				$this->messages->error = "Senha atual errado! Informe novamente";
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}
	
	/**
	 * Ação que faz a requisiçao de uma nova senha
	 * 
	 * @name resetAction
	 */
	public function resetAction() {
		// Busca o usuario
		$login = $this->_request->getParam("login", NULL);

		// Busca as configurações
        $config = Zend_Registry::get("config");
		
		// Busca a chave 
		$key = $this->_request->getParam("chave", NULL);
		
		// Verifica se existe chave
		if($key !== NULL) {
			// Busca as informações do usuario no banco
			$result = $this->_model->fetchRow(array('chave = ?' => $key));
			if($result === NULL) {
				// Erro
				$this->messages->error = "Não foi possível encontrar a chave";
				$this->_helper->redirector("login", "usuarios", "admin");
			}
			
			// 
			$idusuario 	= $result['idusuario'];
			$email 		= $result['email'];
			$nome 		= $result['nome'];
			
			// Gera uma nova senha
			$CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789';
			$max = strlen($CaracteresAceitos)-1;
			$password = null;
			for($i=0; $i < 8; $i++) { 
				$password .= $CaracteresAceitos[mt_rand(0, $max)]; 
			}
			
			// Atualiza a senha e remove a chave
			$data = array();
			$data['chave'] = "";
			$data['senha'] = md5($password);
			
			// Salva a chave no banco
			$this->_model->update($data, array('idusuario = ?' => $idusuario));

			// Captura o nome do site e e-mail de administrador
            $session_config = new Zend_Session_Namespace("configuracao");
            $nome_site = $session_config->dados->nome_site;
            if($session_config->dados->email_contato != "") {
                $emails = $session_config->dados->email_contato;
            }else{
                $emails = $session_config->dados->email_padrao;
            }
            $explode_configemails = explode(',', $emails);

			$cabecalho = "
				<tr>
					<td align=\"left\" height=\"30\">
						<h2><b><font face=\"Arial\" color=\"#3B4E99\">Login: " . $login . "</font></b></h2>
					</td>
				</tr>
				<tr>
					<td align=\"left\" height=\"30\">
						<p><font face=\"Arial\">Segue nova senha de acesso</font></p>
					</td>
				</tr>
			";
			
			// Cria a mensagem
			$mensagem = "
                <table width=\"500\" align=\"center\" cellpadding=\"5\" cellspacing=\"0\" border=\"0\" bgcolor=\"#ffffff\">
                	<tr><td><font face=\"Arial, Helvetica, sans-serif, Verdana\" color=\"#333\">Sua nova senha é <b>" . $password . "</b></font></td></tr>
                </table>
            ";
			
			// Busca o conteudo do email
			$contents = file_get_contents(APPLICATION_PATH . "/../common/email/default.html");
			
			// Troca os conteudos
        	$contents = str_replace("{\$assunto}", "Ativação de nova senha", $contents);
        	$contents = str_replace("{\$cabecalho}", $cabecalho, $contents);
        	$contents = str_replace("{\$conteudo}", $mensagem, $contents);
        	$contents = str_replace("{\$sitename}", $nome_site, $contents);
			
			// Configura o envio para o cliente
            // Classe de envio de e-mail
            $mail = new gazetamarista_Mail();
            $mail->addTo($email, $nome)
                ->setSubject($nome_site . " - Ativação de nova senha")
                ->addEmbeddedImage(APPLICATION_PATH . "/../common/email/images/logo-cliente.png", "logo", "common/email/images/logo-cliente.png")
                ->setReplyTo($emails[0], $nome_site)
                ->setBodyHtml($contents)
                ->send(); 
			
			// Sucesso
			$this->messages->success = "Foi lhe enviado um e-mail com a nova senha";
			$this->_helper->redirector("login", "usuarios", "admin");
		}
		
		// Verifica se tem login
		if($login != NULL) {
			// Gera a chave
			$key = md5(rand(100000000, 999999999) . time());
			
			// Busca as informações do usuario no banco
			$result = $this->_model->fetchRow(array('login = ?' => $login));
			
			if($result === NULL) {
				// Erro
                $this->messages->error = "Não foi possível encontrar o usuário";
				$this->_helper->redirector("login", "usuarios", "admin");
			}
			
			// Armazena as informações do usuário
			$idusuario 	= $result['idusuario'];
			$email 		= $result['email'];
			$nome 		= $result['nome'];
			
			// Verifica se tem email
			if(strlen($email) <= 0) {
				// Salva o erro
				$this->messages->error = "O usuário não possui e-mail cadastrado";
				$this->_helper->redirector("login", "usuarios", "admin");
			}
			
			// Salva a chave no banco
			$this->_model->update(array('chave' => $key), array('idusuario = ?' => $idusuario));

			// Captura o nome do site e e-mail de administrador
            $session_config = new Zend_Session_Namespace("configuracao");
            $nome_site = $session_config->dados->nome_site;
            if($session_config->dados->email_contato != "") {
                $emails = $session_config->dados->email_contato;
            }else{
                $emails = $session_config->dados->email_padrao;
            }
            $explode_configemails = explode(',', $emails);
			
			// Cria a URL para ativação da nova senha
			$url = "http://" . $_SERVER['SERVER_NAME'] . substr($_SERVER['REDIRECT_URL'], 0, strpos($_SERVER['REDIRECT_URL'], "/login")) . "/chave/" . $key;

			$cabecalho = "
				<tr>
					<td align=\"left\" height=\"30\">
						<h2><b><font face=\"Arial\" color=\"#3B4E99\">Login: " . $login . "</font></b></h2>
					</td>
				</tr>
				<tr>
					<td align=\"left\" height=\"30\">
						<p><font face=\"Arial\">Solicitação de nova senha</font></p>
					</td>
				</tr>
			";
			
			// Cria a mensagem
			$mensagem = "
                <table width=\"500\" align=\"center\" cellpadding=\"5\" cellspacing=\"0\" border=\"0\" bgcolor=\"#ffffff\">
                	<tr><td><font face=\"Arial, Helvetica, sans-serif, Verdana\" color=\"" . $cor_texto . "\">Uma nova senha foi solicitada.<br><br>Se você foi o requisitante, clique no link abaixo para ativar uma nova senha.</font></td></tr>
                	<tr><td><a href=" . $url . "><font face=\"Arial, Helvetica, sans-serif, Verdana\" color=\"" . $cor_texto . "\">Efetuar ativação senha</font></a></td></tr>
                </table>
            ";
			
			// Busca o conteudo do email
			$contents = file_get_contents(APPLICATION_PATH . "/../common/email/default.html");
			
			// Troca os conteudos
        	$contents = str_replace("{\$assunto}", "Solicitação de senha", $contents);
        	$contents = str_replace("{\$cabecalho}", $cabecalho, $contents);
        	$contents = str_replace("{\$conteudo}", $mensagem, $contents);
        	$contents = str_replace("{\$sitename}", $nome_site, $contents);
			
			// Configura o envio para o cliente
            // Classe de envio de e-mail
            $mail = new gazetamarista_Mail();
            $mail->addTo($email, $nome)
                ->setSubject($nome_site . " - Solicitação de senha")
                ->addEmbeddedImage(APPLICATION_PATH . "/../common/email/images/logo-cliente.png", "logo", "common/email/images/logo-cliente.png")
                ->setReplyTo($emails[0], $nome_site)
                ->setBodyHtml($contents)
                ->send();
			
			// Sucesso
			$this->messages->success = "Foi lhe enviado um e-mail com os próximos procedimentos";
			$this->_helper->redirector("login", "usuarios", "admin");
		}
	}
}
