<?php

class Avadora_Report {
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_template_file = NULL;
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_template_xml = NULL;
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_pdf = NULL;
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_info = array();
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_parameters = array();
	
	/**
	 *
	 * @var unknown_type
	 */
	protected $_binds = array();
	
	/**
	 * 
	 * @param unknown_type $file
	 */
	public function __construct($file=NULL) {
		$this->_template_file = $file;
	}
	
	/**
	 * 
	 * @param unknown_type $file
	 */
	public function loadTemplate($file) {
		$this->_template_file = $file;
	}
	
	/**
	 *
	 * @param unknown_type $param
	 * @param unknown_type $value
	 */
	public function setParam($param, $value) {
		$this->_parameters[$param] = $value;
	}
	
	/**
	 * 
	 * @todo Verificar o tipo da coluna se é um sum ou count ou fixo
	 */
	public function run() {
		// 
		$this->parseTemplate();
		
		//
		$this->_pdf = new Zend_Pdf();
		
		//
		$page = new Zend_Pdf_Page($this->_info['page']['width'], $this->_info['page']['height']);
		
		// Busca a query à ser executada
		$query = $this->_template_xml['queryString'];
		
		// Busca os parametros do filtro
		$parameters = $this->_template_xml['parameter'];
		if(isset($parameters['name'])) {
			$parameters = array(
				$parameters
			);
		}
		foreach($parameters as $parameter) {
			$param_name = $parameter['name'];
				
			if(strpos($query, "\$P{" . $param_name . "}") !== FALSE ) {
				$this->_binds[] = $this->_parameters[$param_name];
			}
				
			$query = str_replace("\$P{" . $param_name . "}", "?", $query);
		}
		
		// Executa a query
		$list = $this->_executeQuery($query);
		
		// Monta as informações do titulo
		$top = $this->_info['page']['margins']['top'] + 9;
		$left = $this->_info['page']['margins']['left'];
		$this->_mountContainer($this->_template_xml['title']['band'], $page, $top, $left, $list[0]);
		
		// Monta as informações do cabeçalho da pagina
		$top += $this->_template_xml['title']['band']['@attributes']['height'];
		$left = $this->_info['page']['margins']['left'];
		$this->_mountContainer($this->_template_xml['pageHeader']['band'], $page, $top, $left, $list[0]);
		
		// Monta as informações do cabeçalho das colunas
		$top += $this->_template_xml['pageHeader']['band']['@attributes']['height'];
		$left = $this->_info['page']['margins']['left'];
		$this->_mountContainer($this->_template_xml['columnHeader']['band'], $page, $top, $left, $list[0]);
		
		// Monta as informações dos detalhes
		$top += $this->_template_xml['columnHeader']['band']['@attributes']['height'];
		$detail_height = $this->_template_xml['detail']['band']['@attributes']['height'];
		$footer_size = $this->_template_xml['pageFooter']['band']['@attributes']['height'] + $this->_template_xml['columnFooter']['band']['@attributes']['height'] + $this->_info['page']['margins']['bottom'];
		foreach($list as $key => $row) {
			if($top + $detail_height + $footer_size >= $this->_info['page']['height']) {
				continue;
			}
			
			$left = $this->_info['page']['margins']['left'];
			$this->_mountContainer($this->_template_xml['detail']['band'], $page, $top, $left, $row);
			
			$top += $this->_template_xml['detail']['band']['@attributes']['height'];
			$size += $this->_template_xml['detail']['band']['textField'][0]['reportElement']['@attributes']['height'];
			
			unset($list[$key]);
		}
		
		// Monta as informações do rodapé das colunas
		$left = $this->_info['page']['margins']['left'];
		$this->_mountContainer($this->_template_xml['columnFooter']['band'], $page, $top, $left, $list[0]);
		
		// Monta as informações do rodapé da pagina
		$top += $this->_template_xml['columnFooter']['band']['@attributes']['height'];
		$left = $this->_info['page']['margins']['left'];
		$this->_mountContainer($this->_template_xml['pageFooter']['band'], $page, $top, $left, $list[0]);
		
		//
		$this->_pdf->pages[0] = $page;
		
		// Verifica se existe outros itens
		while(count($list) > 0) {
			// Cria outra pagina
			$page = new Zend_Pdf_Page($this->_info['page']['width'], $this->_info['page']['height']);
			
			// Monta as informações do cabeçalho da pagina
			$top = $this->_info['page']['margins']['top'];
			$left = $this->_info['page']['margins']['left'];
			$this->_mountContainer($this->_template_xml['pageHeader']['band'], $page, $top, $left, $list[0]);
			
			// Monta as informações do cabeçalho das colunas
			$top += $this->_template_xml['pageHeader']['band']['@attributes']['height'];
			$left = $this->_info['page']['margins']['left'];
			$this->_mountContainer($this->_template_xml['columnHeader']['band'], $page, $top, $left, $list[0]);
			
			// Monta as informações dos detalhes
			$top += $this->_template_xml['columnHeader']['band']['@attributes']['height'];
			$detail_height = $this->_template_xml['detail']['band']['@attributes']['height'];
			
			foreach($list as $key => $row) {
				if($top + $detail_height + $footer_size >= $this->_info['page']['height']) {
					continue;
				}
					
				$left = $this->_info['page']['margins']['left'];
				$this->_mountContainer($this->_template_xml['detail']['band'], $page, $top, $left, $row);
					
				$top += $this->_template_xml['detail']['band']['@attributes']['height'];
				$size += $this->_template_xml['detail']['band']['textField'][0]['reportElement']['@attributes']['height'];
					
				unset($list[$key]);
			}
			
			// Continua percorrento os itens para chegar ao final da pagina
			while(1) {
				if($top + $detail_height + $footer_size >= $this->_info['page']['height']) {
					break;
				}
				$top += $this->_template_xml['detail']['band']['@attributes']['height'];
				$size += $this->_template_xml['detail']['band']['textField'][0]['reportElement']['@attributes']['height'];
			}
			
			// Monta as informações do rodapé das colunas
			$left = $this->_info['page']['margins']['left'];
			$this->_mountContainer($this->_template_xml['columnFooter']['band'], $page, $top, $left, $list[0]);
			
			// Monta as informações do rodapé da pagina
			$top += $this->_template_xml['columnFooter']['band']['@attributes']['height'];
			$left = $this->_info['page']['margins']['left'];
			$this->_mountContainer($this->_template_xml['pageFooter']['band'], $page, $top, $left, $list[0]);
			
			// Adiciona a pagina
			$this->_pdf->pages[] = $page;
		}
	}
	
	/**
	 * 
	 * @param unknown_type $child_node
	 */
	protected function _mountContainer($child_node, $page, $current_top, $current_left, $row=NULL) {
		// Percorre os elementos
		foreach($child_node as $child_name => $child_node) {
			// Verifica se são textFields
			if($child_name == "textField") {
				// Percorre os itens
				foreach($child_node as $key => $node) {
					// Verifica se possui mais de um elemento
					if(!is_numeric($key)) {
						$node = $child_node;
					}
					
					// Cria o elemento texto
					$element = new Avadora_Reports_Elements_Text($node);

					// Recupera o tamanho
					$width = $node['reportElement']['@attributes']['width'];
					
					// Calcula a posição
					$top = $node['reportElement']['@attributes']['y'] - 1;
					$top = $this->_info['page']['height'] - ($top + $current_top);
					
					$left = $node['reportElement']['@attributes']['x'];
					$left = $left + $current_left;
		
					// Adiciona o texto
					$text = $element->getText();
					$text = $this->_parseText($text, $row);
					
					// Adiciona à pagina
					$page
						->setStyle($element->getStyle())
						->drawText($text, $left, $top, "UTF-8");
				}
			}
			// Verifica se são textos staticText
			elseif($child_name == "staticText") {
				// Percorre os itens
				foreach($child_node as $key => $node) {
					// Verifica se possui mais de um elemento
					if(!is_numeric($key)) {
						$node = $child_node;
					}
						
					// Cria o elemento texto
					$element = new Avadora_Reports_Elements_Static($node);
				
					// Recupera o tamanho
					$width = $node['reportElement']['@attributes']['width'];
					
					// Calcula a posição
					$top = $node['reportElement']['@attributes']['y'];
					$top = $this->_info['page']['height'] - ($top + $current_top);
					
					if($node['reportElement']['@attributes']['uuid'] == "02ce5453-731d-4b58-b90b-e279967e7a9e") {
						//die(var_dump($node['reportElement']['@attributes']['y']));
					}
					
					$left = $node['reportElement']['@attributes']['x'];
					$left = $left + $current_left;
				
					// Adiciona o texto
					$text = $element->getText();
					$text = $this->_parseText($text, $row);
					
					// Adiciona à pagina
					
					$page
						->setStyle($element->getStyle())
						->drawText($text, $left, $top, "UTF-8");
				}
			}
			elseif($child_name == "line") {
				// Percorre os itens
				foreach($child_node as $key => $node) {
					// Verifica se possui mais de um elemento
					if(!is_numeric($key)) {
						$node = $child_node;
					}
					
					// Calcula a posição
					$top = $node['reportElement']['@attributes']['y'] + $node['reportElement']['@attributes']['height'] - 11.6;
					$top = $this->_info['page']['height'] - ($top + $current_top);
					
					$left = $node['reportElement']['@attributes']['x'];
					$left = $left + $current_left;
					
					$width = $node['reportElement']['@attributes']['width'] - 1;
					$height = $node['reportElement']['@attributes']['height'] - 1;
					
					// Adiciona a linha à pagina
					$page->drawLine($left, $top, $left + $width, $top + $height);
				}
			}
		}
	}
	
	/**
	 * 
	 * @param unknown_type $text
	 * @param unknown_type $row
	 */
	protected function _parseText($text, $row) {
		// Verifica se é uma data
		if($text == "new java.util.Date()") {
			$text = date("d/m/Y");
		}
		// Verifica se é um field
		elseif(strpos($text, "\$F{") !== FALSE) {
			$field = str_replace("\$F{", "", str_replace("}", "", $text));
			$text = $row[$field];
		}
		
		return $text;
	}
	
	/**
	 * 
	 * @param unknown_type $filename
	 * 
	 * @todo adicionar parametro para baixar ou abrir na tela
	 */
	public function download($filename) {
		//
		header("Content-Type: application/pdf");
		
		echo $this->_pdf->render();
	}
	
	/**
	 * 
	 * @throws Zend_Exception
	 */
	protected function parseTemplate() {
		try {
			$this->_template_xml = simplexml_load_file($this->_template_file, NULL, LIBXML_NOCDATA);
			
			$json = json_encode($this->_template_xml);
			$this->_template_xml = json_decode($json,TRUE);
		}
		catch(Exception $e) {
			throw new Zend_Exception("Cannot parse template file");
		}
		
		// Armazena as informações da pagina
		$page_info = $this->_template_xml['@attributes'];
		$this->_info['page'] = array(
			'width' => (int)$page_info['pageWidth'],
			'height' => (int)$page_info['pageHeight'],
			'margins' => array(
				'top' => (int)$page_info['topMargin'],
				'right' => (int)$page_info['rightMargin'],
				'bottom' => (int)$page_info['bottomMargin'],
				'left' => (int)$page_info['leftMargin']
			)
		);
	}
	
	/**
	 * 
	 */
	protected function _executeQuery($query) {
		// Recupera o objeto de conexão com o banco de dados
		$db = Zend_Registry::get("db");
		
		// Executa a query
		$result = $db->query($query, array_reverse($this->_binds));
		
		// Busca os elementos
		$list = $result->fetchAll();
		
		// Retorna o resultado
		return $list;
	}
	
	function widthForStringUsingFontSize($string, $font, $fontSize) {
		$drawingString = iconv('UTF-8', 'UTF-16BE//IGNORE', $string);
		$characters = array();
		for ($i = 0; $i < strlen($drawingString); $i++) {
			$characters[] = (ord($drawingString[$i++]) << 8 ) | ord($drawingString[$i]);
		}
		$glyphs = $font->glyphNumbersForCharacters($characters);
		$widths = $font->widthsForGlyphs($glyphs);
		$stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize;
		return $stringWidth;
	}
}