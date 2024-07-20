<?php

/**
 * Calcula frete pela tabela dos correios
 * 
 * @name gazetamarista_Transportadoras_Correiosoffline
 */
class gazetamarista_Transportadoras_Correiosoffline extends gazetamarista_Transportadoras_Abstract {
	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "correios";
	
	/**
	 * Armazena as informações dos produtos necessarias para o calculo do frete
	 *
	 * @access protected
	 * @name $infos
	 * @var array
	 */
	protected $infos = array();
	
	/**
	 * Inicializador da classe
	 * 
	 * @name init
	 */
	public function init() {
		// Cria o where
		$where = array(0);
		foreach($this->_produtos as $idproduto => $quantidade) {
			$where[] = $idproduto;
		}
		
		// Instancia o model dos produtos
		$model = new Admin_Model_Produtos();
		
		// Busca os produtos da lista
		$produtos = $model->fetchAll(array("idproduto in (" . implode(", ", $where) . ")"), array("largura DESC", "comprimento DESC"), "idproduto DESC");
		
		// Inicializa as informações dos produtos
		$this->infos['peso'] = 0;
		
		// Percorre os produtos
		foreach($produtos as $produto) {
			// Soma o peso dos produtos
			$this->infos['peso'] += $produto->peso * $this->_produtos[$produto->idproduto]['quantidade'];
		}
	}
	
	/**
	 * Faz requisições de frete
	 * 
	 * @name frete
	 * @return array
	 */
	public function fretes() {
		// Monta a query
		$select = "
			SELECT 
				*
			FROM 
				transportadoras_correios 
			WHERE 
				" . $this->_cep_destino . " BETWEEN cep_inicial AND cep_final 
					AND 
				" . $this->infos['peso'] . " BETWEEN condicao_inicial AND condicao_final
		";
		
		// Efetua a busca dos fretes
		$result = $this->_model->query($select);
		$list = $result->fetchAll();
		
		// Cria o model dos metodos de envio
		$model = new Admin_Model_Metodosenvio();
		
		// Percorre os fretes
		$fretes = array();
		foreach($list as $frete) {
			// Busca o nome do serviço
			$nome = $model->fetchRow(array('idmetodo_envio = ?' => $frete['idmetodo_envio']))->descricao;
			
			// Monta o frete
			$fretes[$frete['idmetodo_envio']] = array(
				'codigo' 	=> (int)$frete['idmetodo_envio'],
				'nome' 		=> $nome,
				'valor' 	=> (float)str_replace(",", ".", $frete['preco']),
				'entrega' 	=> (int)$frete['dias_entrega'],
				'erro' 		=> ""
			);
		}
		
		return $fretes;
	}
}