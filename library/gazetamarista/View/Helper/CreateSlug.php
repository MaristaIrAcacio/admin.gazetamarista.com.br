<?php 

class gazetamarista_View_Helper_CreateSlug extends Zend_View_Helper_Abstract {
	/**
	 * Plugin para conversão dos caracteres especiais para link
	 * 
	 * @param string $SEO_text Texto para converter
	 * @return string
	 */
	public function createslug($SEO_text) {
	
		// Verifica se tem texto
		if(empty($SEO_text)) {
			return;
		}
	
		// Decodifica o html entities
		$SEO_text = html_entity_decode($SEO_text,ENT_QUOTES, 'UTF-8');
		
		// Diminui o tamanho da letra
		$SEO_text = mb_strtolower($SEO_text, "UTF-8");
		
		// Troca os caracteres especiais
		$trans = array(
			'ç' => "c",
			'á' => "a",
			'â' => "a",
			'à' => "a",
			'ã' => "a",
			'é' => "e",
			'ê' => "e",
			'è' => "e",
			'ẽ' => "e",
			'í' => "i",
			'î' => "i",
			'ì' => "i",
			'ĩ' => "i",
			'ó' => "o",
			'ô' => "o",
			'ò' => "o",
			'õ' => "o",
			'ú' => "u",
			'û' => "u",
			'ù' => "u",
			'ũ' => "u"
		);
		$SEO_text = strtr($SEO_text, $trans);
		
		// Trocar o que não é especial
		$SEO_text = preg_replace("@[^a-zA-Z0-9]@", "-", $SEO_text);
		
		// Troca varios espacos por 1 só
		$SEO_text = preg_replace("/__+/", "-", $SEO_text);

		// Remove traço do final
        $SEO_text  = rtrim($SEO_text, '-');
		
		// Retorna o texto
		return $SEO_text;
	}
}
