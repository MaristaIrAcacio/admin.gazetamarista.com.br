<?php

// Inclui a classe do smarty
require_once("gazetamarista/Library/Smarty/Smarty.class.php");

/**
 * Classe para ajudar na integração entre o zend e o smarty
 * 
 * @name gazetamarista_View_Smarty
 */
class gazetamarista_View_Smarty extends Zend_View_Abstract {

	/**
	 * Armazena o objeto smarty
	 * @var _smarty
	 * @type Smarty
	 */
	protected $_smarty;

	/**
	 * Construtor da classe
	 * 
	 * @name __construct
	 * @param array $data Configurações do smarty
	 */
	public function __construct($data) {
		parent::__construct($data);

		// Cria o objeto smarty
		$this->_smarty = new Smarty();
		
		// Configura o objeto
		$this->_smarty->compile_dir		= $data['compile_dir'];
		$this->_smarty->compile_check	= $data['compile_check'];
		$this->_smarty->force_compile	= $data['force_compile'];
		$this->_smarty->template_dir	= array($data['views_dir'], $data['template_dir']);
		
		// Assina o objeto ao template
		$this->_smarty->assign("this", $this);
	}

	/**
	 * Verifica se o template está em cache
	 *
	 * @name isCached
	 * @param string $template Templete para verificar se está em cache
	 * @return boolean
	 */
	public function isCached($template) {
		// Verifica se o template está em cache
		if ($this->_smarty->is_cached($template)){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Seta se seve usar cache
	 * 
	 * @name setChaching
	 * @param boolean $caching Se deve ou não usar cache
	 */
	public function setCaching($caching) {
		// Configura o smarty
		$this->_smarty->caching = $caching;
	}

	/**
	 * Retorna o engine para o zend
	 * 
	 * @name getEngine()
	 * @return Smarty
	 */
	public function getEngine() {
		return $this->_smarty;
	}

	/**
	 * Método magico que seta valores nas propriedades
	 * 
	 * @name __set
	 * @param string $key Nome da propriedade
	 * @param string $val Valor da propriedade
	 */
	public function __set($key, $val) {
		$this->_smarty->assign($key, $val);
	}

	/**
	 * Método magico que retorna valores nas propriedades
	 * 
	 * @name __get
	 * @param string $key Nome da propriedade
	 * @return mixed
	 */
	public function __get($key) {
		return $this->_smarty->getTemplateVars($key);
	}

	/**
	 * Método magico que verifica se a variavel existe
	 * 
	 * @name __isset
	 * @param string $key Nome da propriedade
	 * @return boolean
	 */
	public function __isset($key) {
		return $this->_smarty->getTemplateVars($key) != NULL;
	}

	/**
	 * Método magico que remove a assinatura de uma variavel
	 * 
	 * @name __unset
	 * @param string $key Nome da propriedade
	 */
	public function __unset($key) {
		$this->_smarty->clear_assign($key);
	}

	/**
	 * Método que assina as variaveis para o template
	 * 
	 * @name assign
	 * @param string $spec Nome da propriedade no view
	 * @param midex $value Valor da propriedade no view
	 * @return null
	 */
	public function assign($spec, $value=NULL) {
		if (is_array($spec)) {
			$this->_smarty->assign($spec);
			return;
		}
		$this->_smarty->assign($spec, $value);
	}

	/**
	 * Limpa as variaveis do view
	 * 
	 * @name clearVars
	 */
	public function clearVars() {
//		// Limpa as variaveis assinadas
//		$this->_smarty->clearAllAssign();
//		
//		// Assina o objeto ao template
//		$this->_smarty->assign("this", $this);
	}

	/**
	 * Renderiza o tempalte
	 * 
	 * @name render
	 * @param string $name Nome do template
	 * @return string
	 */
	public function render($name) {
		
		// Percorre os caminhos onde podem ter templates
		foreach($this->_smarty->template_dir as $path) {
			
			// Verifica se existe / no final do path
			if($path[strlen($path)-1] != "/") {
				$path .= "/";
			}
			
			// Verifica se o arquivo do template existe
			if(!file_exists($name)) {
				// Monta o novo nome do template
				$filename = basename($name);
				$name = $path . $filename;
			}
			else {
				// Finaliza a busca
				break;
			}
		}
		
		// Remove as mensagens da sessão
		unset($_SESSION['messages']['error']);
		unset($_SESSION['messages']['success']);
		
		// Retorna o template
		return $this->_smarty->fetch(strtolower($name));
	}

	/**
	 * Inicia o renderizador
	 * 
	 * @name _run
	 */
	public function _run() {
		die(func_get_arg(0));
		$this->_smarty->display(func_get_arg(0));
	}

	/**
	 * Renderiza o arquivo setado
	 * 
	 * @param string $name Arquivo à ser renderizado, deve estar no diretório do template
	 */
	public function display($name) {
		// Mostra o template
		print parent::render($name);
	}
}
