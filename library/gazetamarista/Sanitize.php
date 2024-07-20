<?php
/**
 * Limpa o texto de tentativas de Cross Site Scripting (XSS)
 * 
 * @name gazetamarista_Sanitize
 *
 * @author  gazetamarista - Rossi
 */
class gazetamarista_Sanitize {
	/**
	 * Retorna a string limpa
	 * 
	 * @name sanitizestring
	 * @param String|Array $texto
	 * @param String $tipo
	 * @return string
	 */
	static public function sanitizestring($texto=null, $tipo=null) {
	    /*
	     * Funções básicas do PHP
           - addslashes: Escapa caracteres especiais como aspas
           - htmlentities: Transforma caracteres especiais html em entidades html
           - utf8_decode: Converte para UTF-8
           - trim: remove espações em branco no fim e inicio no texto
	    */

		// Diferente de null
		if(!is_null($texto)) {
			// Se for array, percorre e tratando o texto
			if(is_array($texto)) {
				// Percorre o array
				foreach($texto as $field=>$value) {
                    // Verifica o tipo do dado recebido
                    if (is_array($value)) {  // Verifica se é um array
                        // Percorre o array
                        foreach ($value as $field2 => $value2) {
                            // Verifica se está sendo utilizado na busca ou no insert/update
                            if ($tipo == "search") {
                                $value[$field2] = addslashes(htmlspecialchars(strip_tags(trim($value2))));
                            } else {
                                $value[$field2] = addslashes(htmlentities(utf8_decode(strip_tags(trim($value2)))));
                            }
                        }
                        $texto[$field] = $value;
                    } else if(is_object($value)) {  // Verifica se é um objeto
                        // Percorre o objeto
                        foreach ($value as $field2 => $value2) {
                            // Verifica se está sendo utilizado na busca ou no insert/update
                            if ($tipo == "search") {
                                $value->$field2 = addslashes(htmlspecialchars(strip_tags(trim($value2))));
                            } else {
                                $value->$field2 = addslashes(htmlentities(utf8_decode(strip_tags(trim($value2)))));
                            }
                        }
                        $texto[$field] = $value;
                    }else{
                        // Verifica se está sendo utilizado na busca ou no insert/update
                        if ($tipo == "search") {
                            $texto[$field] = addslashes(htmlspecialchars(strip_tags(trim($value))));
                        } else {
                            $texto[$field] = addslashes(htmlentities(utf8_decode(strip_tags(trim($value)))));
                        }
                    }
				}
			}else if(is_object($texto)) {
                // Percorre o objeto
                foreach($texto as $field=>$value) {
                    if (is_array($value)) {
                        // Percorre o array
                        foreach ($value as $field2 => $value2) {
                            // Verifica se está sendo utilizado na busca ou no insert/update
                            if ($tipo == "search") {
                                $value[$field2] = addslashes(htmlspecialchars(strip_tags(trim($value2))));
                            } else {
                                $value[$field2] = addslashes(htmlentities(utf8_decode(strip_tags(trim($value2)))));
                            }
                        }
                        $texto->$field = $value;
                    }else if(is_object($value)) {
                        // Percorre o objeto
                        foreach ($value as $field2 => $value2) {
                            // Verifica se está sendo utilizado na busca ou no insert/update
                            if ($tipo == "search") {
                                $value->$field2 = addslashes(htmlspecialchars(strip_tags(trim($value2))));
                            } else {
                                $value->$field2 = addslashes(htmlentities(utf8_decode(strip_tags(trim($value2)))));
                            }
                        }
                        $texto->$field = $value;
                    }else{
                        // Verifica se está sendo utilizado na busca ou no insert/update
                        if ($tipo == "search") {
                            $texto->$field = addslashes(htmlspecialchars(strip_tags(trim($value))));
                        } else {
                            $texto->$field = addslashes(htmlentities(utf8_decode(strip_tags(trim($value)))));
                        }
                    }
                }
            }else{
                // Verifica se está sendo utilizado na busca ou no insert/update
                if($tipo == "search") {
                    $texto = addslashes(htmlspecialchars(strip_tags(trim($texto)), ENT_QUOTES));
                }else{
                    $texto = addslashes(htmlentities(utf8_decode(strip_tags(trim($texto)))));
                }
            }

			// Retorna o texto
			return $texto;
		}else{
			// Retorna falso
			return FALSE;
		}
	}
}