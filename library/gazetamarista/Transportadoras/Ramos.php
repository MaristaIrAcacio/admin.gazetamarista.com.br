<?php

/**
 * Calcula frete por cidade / estado
 * 
 * @name gazetamarista_Transportadoras_Cidade
 */
class gazetamarista_Transportadoras_Ramos extends gazetamarista_Transportadoras_Abstract {
	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "ramos";
	
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
		// Busca a cidade e o estado do cep digitado
		$correios = new gazetamarista_Request_Correios();
		$this->infos['localidade'] = $correios->cep($this->_cep_destino);
		
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
		$this->infos['valor_declarado'] = 0;
		
		// Percorre os produtos
		foreach($produtos as $produto) {
			// Soma o peso dos produtos
			$this->infos['peso'] += $produto->peso * $this->_produtos[$produto->idproduto]['quantidade'];
			
			// Soma o preço dos produtos
			$this->infos['valor_declarado'] += $produto->preco_venda * $this->_produtos[$produto->idproduto]['quantidade'];
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
				transportadoras_ramos 
			WHERE 
				(cidade = " . $this->_model->quote(strtoupper($this->infos['localidade']['cidade'])) . " OR cidade = 'INTERIOR')
					AND
				estado = " . $this->_model->quote(strtoupper($this->infos['localidade']['uf'])) . "
					AND
				peso_inicial <= " . $this->infos['peso'] . "
					AND
				peso_final > " . $this->infos['peso'] . "
		";
		
		// Efetua a busca dos fretes
		$result = $this->_model->query($select);
		$list = $result->fetchAll();
		$row = $list[0];
		
		// Monta o valor do frete
		$valor = $row['valor'];

		// Verifica se existe valores adicionais
		$dados = (array)json_decode($row['meta_dados']);
		
		// Verifica se existe valor adicional
		if(count($dados['adicional']) > 0) {
			
			// Percorre os indices para o calculo
			foreach($dados['adicional'] as $indice) {
				
				// Verifica se é porcentagem
				if(strpos($indice, "%") !== FALSE) {
					
					// Calcula o valor da porcentagem
					$indice = str_replace("%", "", $indice);
					$porcento = ($this->infos['valor_declarado'] * $indice) / 100;

					// Adiciona o valor ao frete
					$valor = $valor + $porcento;
				}
				else {
					// Busca só o valor
					$indice = str_replace("R\$", "", $indice);

					// Adiciona o valor ao frete
					$valor = $valor + $indice;
				}

			}
		}

		// Monta o vetor do frete
		$frete["1010"] = array(
			'codigo' => 1010,
			'nome' => "Transportadora",
			'valor' => (float)str_replace(",", ".", $valor),
			'entrega' => (int)$this->_config->prazo_adicional,
			'erro' => ""
		);
		
		// Retorna o frete
		return $frete;
	}
}