<?php

/**
 * Classe que compara 2 arrays multidimensionais
 * 
 * @name gazetamarista_Comparararray
 *
 * @author  gazetamarista - Rossi
 */
class gazetamarista_Comparararray {
	/**
	 * Retorna o conteúdo diferente dos arrays
	 * 
	 * @return array
	 */
	function array_diff_assoc_recursive($array1, $array2) {
	    $difference = array();
	    foreach($array1 as $key => $value) {
	        if( is_array($value) ) {
	            if( !isset($array2[$key]) || !is_array($array2[$key]) ) {
	                $difference[$key] = $value;
	            } else {
	                $new_diff = $this->array_diff_assoc_recursive($value, $array2[$key]);
	                if( !empty($new_diff) )
	                    $difference[$key] = $new_diff;
	            }
	        } else if( !array_key_exists($key,$array2) || $array2[$key] !== $value ) {
	            $difference[$key] = $value;
	        }
	    }
	    return $difference;
	}
}