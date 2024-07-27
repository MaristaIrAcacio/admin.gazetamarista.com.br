<?php

/**
 * Cria o helper para exibição das metas dos pedidos
 * 
 * @name gazetamarista_View_Helper_Pedidometa
 */
class gazetamarista_View_Helper_Pedidometa extends Zend_View_Helper_Abstract {
	/**
	 * Método da classe
	 * 
	 * @param Zend_Table_Row $row Registro do status
	 */
	public function pedidometa($row) {
		// Inicializa o retorno
		$string = "";
		
		// Verifica o tipo do histórico
		switch($row->identificacao) {
			case "cielo":
				$json = json_decode($row->meta_dados);
				$xml = simplexml_load_string(json_decode($row->meta_dados));
				
				//Zend_Debug::dump($xml);exit;
				
				$string .= "Tid: " . $xml->tid;
				//$string .= $json->bandeira . " Tid: " . $json->tid . " Valor: " . $json->parcelas . "x " . $json->valor;
				break;
				
			case "manual":
				$json = json_decode($row->meta_dados);
				$string = "Modificação manual efetuada por: " . $json->nome;
				break;
				
			case "boletophp":
				$json = json_decode($row->meta_dados);
				$string = "Boleto " . $json->status;
				break;

			case "clearsale":
				$dados = $row->dados;

				preg_match_all("/<Status>(.*?)<\/Status>/", $dados, $status);
				$string = "Status ClearSale: " . $status[1][0];
		}
		
		// Retorna a string formatada
		return $string;
	}
}