<?php

/** Zend_Application */
require_once("Zend/Application.php");

/** Debug */
require_once("gazetamarista/Debug.php");

/**
 * Classe que instancia toda a aplicação
 *
 * @name gazetamarista_Application
 * @see Zend_Application
 */
class gazetamarista_Application extends Zend_Application {
	/**
	 * Inicializa a aplicação
	 *
	 * @param  string $environment
	 * @param  string|array|Zend_Config $options String path to configuration file, or array/Zend_Config of configuration options
	 * @throws Zend_Application_Exception When invalid options are provided
	 * @return void
	 */
	public function __construct($environment, $options=null) {
		// Verifica se é a criação de imagens
		if($_GET['param'] == "tbimage") {
			// Cria os thumbs
			$this->_createThumb();
		}
		elseif($_GET['param'] == "minifycss") {
			// Executa o minify no CSS
			//$this->_minifyCSS();
		}
		else {
			// Inicializa o debug
			$debug = new gazetamarista_Debug();

			// Continua o carregamento
			parent::__construct($environment, $options);

			// Registra o debug
			Zend_Registry::set("debug", $debug);
		}
	}

	/**
	 * Executa o minify css
	 *
	 * @access protected
	 * @name _minifyCSS
	 */
	protected function _minifyCSS() {
		// Monta o caminho do arquivo
		var_dump($_REQUEST);
	}

	/**
	 * Cria thumbs
	 *
	 * @access protected
	 * @name _createThumb
	 */
	protected function _createThumb() {
		// Inclui a classe da manipulação de imagens
		include("gazetamarista/Image/Canvas.php");

		// Busca os parametros
		$file   = $_GET["imagem"];
		$type   = $_GET["tipo"];
		$width  = $_GET["largura"] == 0 ? '' : $_GET["largura"];
		$height = $_GET["altura"] == 0 ? '' : $_GET["altura"];
		$crop   = $_GET["crop"];

		// Monta o caminho do arquivo
		$file = APPLICATION_PATH . "/../common/uploads/" . $type . "/" . $file;

		// Cria o objeto canvas
		$canvas = new gazetamarista_Image_Canvas($file);

		// Verifica se foi passada somente a largura
		if(($width != "") && ($height == "")) {
			$canvas->redimensiona($width);
		}
		// Verifica se foi passada somente a altura
		elseif($width == "" && $height != "") {
			$canvas->redimensiona('',$height);
		}
		// Verifica se foram passadas as duas dimensoes
		elseif($width != "" && $height != "") {
			if($crop == 0) {
				$canvas->redimensiona($width, $height);
			}
			elseif($crop == 1) {
				$canvas->redimensiona($width, $height, "crop");
			}
			elseif($crop == 2) {
				$canvas->hexa("FFFFFF");
				$canvas->redimensiona($width, $height, "preenchimento");
			}
			elseif($crop == 3) {
				// tipo crop sem preenchimento (para imagens png fundo transparente)
                $canvas->redimensiona($width, $height, "sempreenchimento");
			}
		}
		else {
			$canvas->redimensiona(0, 0, "preenchimento");
		}

        //get the last-modified-date of this very file
        $lastModified=filemtime(__FILE__);
        //get a unique hash of this file (etag)
        $etagFile = md5_file($_SERVER['SCRIPT_FILENAME']);
        //get the HTTP_IF_MODIFIED_SINCE header if set
        $ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
        //get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
        $etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

        //set last-modified header
        header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
        //set etag-header
        header("Etag: \"$etagFile\"");
        //make sure caching is turned on
        header('Cache-Control: "max-age=29030400, public"');

		// Mostra a imagem
		$canvas->grava("", 90);
	}
}