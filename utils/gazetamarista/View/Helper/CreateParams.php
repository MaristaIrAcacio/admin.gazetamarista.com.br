<?php 

class gazetamarista_View_Helper_CreateParams {
	
	/**
	 * Cria um vetor com os parametros de chave primaria
	 * 
	 * @name createParams
	 * @param array $primaryKeys Vetor com o nome das chaves primarias
	 * @param array $row Vetor com os valores da linha
	 * @param array $params Vetor com parametros prédefinidos
	 * @return array
	 */
	public function CreateParams($primaryKeys, $row, $params=array()) {
		//
		$model = $row->getTable();
		
		// Percorre as colunas da linha
		foreach($row as $key => $value) {
			// Verifica se é chave primaria
			if(in_array($key, $primaryKeys)) {
				$params[$key] = $value;
			}
		}
		
		//
		return $params;
	}
}