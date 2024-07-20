<?php

/**
 * Classe de inicialização da aplicação
 * 
 * @name Bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	/**
	 * Armazena o view
	 * 
	 * @name $_view
	 */
	protected $_view = NULL;
	
	/**
	 * Armazena a configuração
	 * 
	 * @name $_config
	 */
	protected $_config = NULL;
	
	/**
	 * Busca a configuração do INI
	 *
	 * @name _initConfig
	 */
	protected function _initConfig() {
		// Busca a configuração
		$this->_config = new Zend_Config($this->getOptions());
		
		// Registra o config na sessão
		Zend_Registry::set("config", $this->_config);
		
		// Busca as configurações dos modulos
		$modulos = new Zend_Config_Ini(APPLICATION_PATH . "/configs/modules.ini");
		Zend_Registry::set("modulos", $modulos);
		
		// Inicia os loaders
		$this->bootstrap("autoloaders");
	}
    
    /**
     * Inicializa a tradução do sistema
     *
     * @name _initTranslate
     */
    protected function _initTranslate()
    {
        try
        {
            // Busca a linguagem padrão
            $options          = $this->getOption("gazetamarista");
            $default_language = $options['config']['language'];
            
            // Inicia a tradução do site
            $translator = new Zend_Translate([
                'adapter' => 'array',
                'content' => APPLICATION_PATH . '/languages',
                'locale'  => $default_language,
                'scan'    => Zend_Translate::LOCALE_DIRECTORY,
            ]);
            
            //Zend_Registry::set("translate", $translate);
            
            // Define a tradução padrão
            Zend_Validate_Abstract::setDefaultTranslator($translator);
        }
        catch( Exception $e )
        {
            //die($e->getMessage());
        }
    }
	
	/**
	 * Inicializa as rotas
	 * 
	 * @name _initRouter
	 */
	protected function _initRouter() {
		try {
			$this->bootstrap("frontController");
			$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/routes.ini", "routes");
			$router = $this->getResource("frontController")
				->getRouter()
				->addConfig($config, "routes");
			return $router;
		}
		catch(Exception $e) {
			return FALSE;
		}
	}
	
	/**
	 * Inicializa os loaders
	 * 
	 * @name _initAutoloaders
	 */
	protected function _initAutoloaders() {
		$this->getApplication()->setAutoloaderNamespaces(array("gazetamarista_", "ZendX_"));
	}

	/**
	 * Inicializa a conexão com o banco de dados
	 * 
	 * @name _initConnection
	 */
	protected function _initConnection() {
		// Busca as opções de configuração
		$options = $this->getOption("resources");
		$enabled = $options['db']['enabled'];
		
		// Verifica se está habilitado
		if($enabled) {
			$db_adapter = $options['db']['adapter'];
			$params = $options['db']['params'];
			
			try {
				// Carrega a classe adaptadoda
				$db = Zend_Db::factory($db_adapter, $params);
					
				// Busca a conexão
				$db->getConnection();
				
				// Registra a conexão
				$registry = Zend_Registry::getInstance();
				$registry->set("db", $db);
			}
			catch(Exception $e) {
				// Verifica se exibe o erro
				$settings_erros = $this->getOption("phpSettings");
				$settings_erros = $options['display_errors'];
				if($settings_erros) {
					var_dump($e);
				}
				
				// Mostra o problema com a conexão de dados
				die("Estamos com problemas no momento, retorne em alguns instantes. Obrigado.");
			}
		}else{
			// Sem conexão
		}
	}

	/**
	 * Força o fechamento da conexão
	 */
	public function __destruct(){
		// Registra a conexão
		$registry = Zend_Registry::getInstance();
		$db = $registry->get("db");
				
		if($db) {
			// Fecha conexão
			$db->closeConnection();
		}
	}

	/**
	 * Inicializa o view
	 * 
	 * @name _initView
	 */
	protected function _initView() {
		// Busca a sessão das mensagens 
		$session = new Zend_Session_Namespace("messages");
		
		// Busca as configurações do smarty
		$options = $this->getOption("smarty");
		
		// Cria o objeto smarty
		$this->_view = new gazetamarista_View_Smarty($options);
		Zend_Registry::set("view", $this->_view);
		
		// Seta a codificação
		$this->_view->setEncoding("UTF-8");
		
		// Adiciona o renderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper("ViewRenderer");
		$viewRenderer->setView($this->_view)
			->setViewScriptPathSpec(APPLICATION_PATH . "/modules/:module/views/:controller/:action.:suffix")
			->setViewSuffix("tpl");

		$inflector = new Zend_Filter_Inflector(APPLICATION_PATH . "/layouts/:script.:suffix");
		$inflector->addRules(
		array(
			'script' => "layout",
			'suffix' => "tpl"
			)
		);

		Zend_Layout::startMvc(
			array(
			'view' => $this->_view,
			'inflector' => $inflector
			)
		);
		
		// Registra o viewer
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		
		// Adiciona o basepath ao view
		$options = $this->getOption("gazetamarista");
		$basePath = $options['config']['basepath'];
		$this->_view->basePath = $basePath;
		$this->_view->imagePath = $basePath.'/common/admin/images';
		
		// Verifica se houve erros
        $this->_view->error = $session->error;
        $session->error = "";

		// verifica se houve sucessos
        $this->_view->success = $session->success;
        $session->success = "";

		// verifica se houve warning
        $this->_view->warning = $session->warning;
        $session->warning = "";
	}
	
	/**
	 * Inicia os plugins e helpers
	 * 
	 * @name _initPlugins
	 */
	protected function _initPlugins() {
	// Registra o view helper que cria a URL de forma facilitada
		$helper = new gazetamarista_View_Helper_CreateUrl();
		$this->_view->registerHelper($helper, "CreateUrl");
		
		// Registra o helper para criar bbcode
		//$helper = new gazetamarista_View_Helper_Bbcode();
		//$this->_view->registerHelper($helper, "bbcode");
		
		// Registra o helper para criar o tradutor
		// $helper = new gazetamarista_View_Helper_Translate();
		// $this->_view->registerHelper($helper, "translate");
		
		// Registra o helper para criar o tradutor
		$helper = new gazetamarista_View_Helper_Dateformat();
		$this->_view->registerHelper($helper, "dateformat");
		
		// Registra o helper para buscar as colunas
		$helper = new gazetamarista_View_Helper_GetColumnValue();
		$this->_view->registerHelper($helper, "GetColumnValue");
		
		// Registra o helper para criar o tradutor
		$helper = new gazetamarista_View_Helper_CreateSlug();
		$this->_view->registerHelper($helper, "createslug");
		
		// Registra o helper para retornar id do youtube
		$helper = new gazetamarista_View_Helper_YoutubeId();
		$this->_view->registerHelper($helper, "YoutubeId");
		
		// Registra o helper da existencia do produto em estoque
		$helper = new gazetamarista_View_Helper_Jsondecode();
		$this->_view->registerHelper($helper, "jsondecode");
                
	    // Registra o helper do Menu Ativo
	    $helper = new gazetamarista_View_Helper_ActiveMenu();
	    $this->_view->registerHelper($helper, "activeMenu");

	    // Registra o helper breadcump
	    $helper = new gazetamarista_View_Helper_Breadcrumb();
	    $this->_view->registerHelper($helper, "breadcrumb");
		
		// Registra o plugin do commons
		$this->frontController->registerPlugin(new gazetamarista_Controller_Plugin_Commons);
		
		// Registra o plugin do custom css
		$this->frontController->registerPlugin(new gazetamarista_Controller_Plugin_Customcss);
		
		// Registra o plugin do custom js
		$this->frontController->registerPlugin(new gazetamarista_Controller_Plugin_Customjs);
		
		// Registra o plugin de navigation
		$this->frontController->registerPlugin(new gazetamarista_Controller_Plugin_Navigation);
		
		// Registra o plugin de verificação do usuario
		$this->frontController->registerPlugin(new gazetamarista_Controller_Plugin_Userverify);
		
		// Registra o plugin de adição das meta tags
		$this->frontController->registerPlugin(new gazetamarista_Controller_Plugin_Metas);
		
		// Registra o plugin para carregar informações para todo o site
		$this->frontController->registerPlugin(new gazetamarista_Controller_Plugin_Geral);
		
		// Verifica se utiliza um layout por modulo
		if(!$this->config->gazetamarista->layout->justone) {
			$plugin = new gazetamarista_View_ModularLayout();
			$this->frontController->registerPlugin($plugin);
		}
	}
}