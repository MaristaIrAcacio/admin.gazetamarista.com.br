<?php
/**
 * Classe de debug
 *
 * @name gazetamarista_Debug
 */
class gazetamarista_Debug {
	/**
	 * Armazena o nome do arquivo
	 *
	 * @access protected
	 * @name $_filename
	 * @var string
	 */
	protected $_filename;

	/**
	 * Armazena a quantidade de queries
	 *
	 * @access protected
	 * @name $_queries
	 * @var int
	 */
	protected $_queries = 0;

	/**
	 * Armazena o inicio do processamento
	 *
	 * @access protected
	 * @name $_start_time
	 * @var int
	 */
	protected $_start_time = 0;

	/**
	 * Inicializa o debug
	 *
	 * @name __construct
	 */
	public function __construct() {
		$debug = getenv("APPLICATION_DEBUG");
		if($debug == 1) {
			// Calcula o inicio da execução
			$time = microtime();
			$time = explode(" ", $time);
			$time = $time[1] + $time[0];
			$this->_start_time = $time;

			// Adiciona a data de acesso
			$log = "Date: " . date("M d Y H:i:s");
			$this->Log($log);

			// Adiciona o cliente
			$log = "Access From: " . $_SERVER['REMOTE_ADDR'];
			$this->Log($log);

			// Adiciona o navegador
			$log = "User Agent: " . $_SERVER['HTTP_USER_AGENT'];
			$this->Log($log);

			// Adiciona o arquivo
			$log = "Filename: " . __FILE__;
			$this->Log($log);

			// Adiciona a URL
			$log = "Access URL: http" . (($_SERVER['HTTP_USER_AGENT'] == "on") ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$this->Log($log);

			// Adiciona a URL
			$log = "Referer: " . $_SERVER['HTTP_REFERER'];
			$this->Log($log);

			// Adiciona o metodo
			$log = "Request method: " . $_SERVER['REQUEST_METHOD'];
			$this->Log($log);

			// Adiciona os parametros POST
			$log = "POST params: ";
			foreach($_POST as $key => $post) {
				$log .= $key . "=" . $post . "&";
			}
			$this->Log(substr($log, 0, strlen($log)));

			// Adiciona o separador
			$log = "\n===========================================";
			$this->Log($log);

			//
			$log = "[" . date("H:i:s") . "] Aplicação inicializada";
			$this->Log($log);
		}
	}

	public function __destruct() {
//		// Adiciona o separador
//		$log = "\n===========================================";
//		$this->Log($log);
//
//		// Calcula o tempo de processamento
//		$time = microtime();
//		$time = explode(" ", $time);
//		$time = $time[1] + $time[0];
//		$finish = $time;
//		$totaltime = ($finish - $this->_start_time);
//		$log = "Total time: " . $totaltime;
//		$this->Log($log);
//
//		//
//		$log = "Queries: " . $this->_queries;
//		$this->Log($log);
	}

	/**
	 * Grava logs no arquivo
	 *
	 * @name Log
	 * @param string $text Texto para guardar o log
	 * @param string $level Level do log
	 */
	public function Log($text) {
		if(!empty($text)) {
            //$this->_filename = APPLICATION_PATH . "/tmp/debug/" . date("d-m-Y_H-i-s") . "_" . rand(10000, 99999) . ".log";
            $this->_filename = APPLICATION_PATH . "/tmp/debug/" . date("d-m-Y_H") . ".log";

            $contentFile = null;
            if (file_exists($this->_filename)) {
                $contentFile = file_get_contents($this->_filename);
            }

            file_put_contents($this->_filename, $contentFile . $text . "\n");
        }
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
		$file = $_GET["imagem"];
		$type = $_GET["tipo"];
		$width = $_GET["largura"];
		$height = $_GET["altura"];
		$crop = $_GET["crop"];

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
		}
		else {
			$canvas->redimensiona(0, 0, "preenchimento");
		}

		// Mostra a imagem
		$canvas->grava("", 75);

		die();
	}

	public function addQuery($query) {
		$this->_queries++;

		$log = "[" . date("H:i:s") . "] Running query " . str_replace("\n", " ", str_replace("\r", " ", str_replace("  ", " ", $query)));
        $this->Log($log);
	}

}
