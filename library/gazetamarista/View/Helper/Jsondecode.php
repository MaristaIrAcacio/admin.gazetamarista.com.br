<?php

/**
 * Cria o helper para exibição das metas dos pedidos
 * 
 * @name Zend_View_Helper_Pedidometa
 */
class gazetamarista_View_Helper_Jsondecode extends Zend_View_Helper_Abstract {
	/**
	 * Método da classe
	 * 
	 * @param Zend_Table_Row $row Registro do status
	 */
	public function jsondecode($row, $column) {
		// Inicializa o retorno
		$string = "";
		
		$json = json_decode($row);
		$string = $json->$column;
				
		// Retorna a string formatada
		return $string;
	}
}
