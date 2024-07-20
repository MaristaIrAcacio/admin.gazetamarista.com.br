<?php

/**
 * Classe que trata as informações das transportadoras
 * 
 * @name gazetamarista_Transportadoras
 */
class gazetamarista_Transportadoras extends Zend_Mail {
	/**
	 * Armazena o transporte do email
	 *
	 * @access private 
	 * @name _transport
	 * @var Zend_Mail_Transport_Smtp
	 */
	private $_transport = NULL;
	
	/**
	 * Armazena as configurações gerais
	 *
	 * @access private
	 * @name _config
	 * @var Zend_Config
	 */
	private $_config = NULL;
	
	/**
	 * Método de inicialização da classe
	 * 
	 * @name init
	 */
	public function __construct() {
		// Busca as configurações do arquivo ini
		$this->_config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/transportadoras/transportadoras.ini", "config");
	}
	
	/**
	 * Retorna os fretes disponiveis
	 * 
	 * @name fretes
	 * @param string $cep CEP destino
	 * @param array $produtos Vetor com os produtos para o calculo do frete
	 * @return array
	 */
	public function fretes($cep, $produtos) {
		// Cria o model dos métodos de envio
		$model = new Admin_Model_Metodosenvio();
		
		// Ajusta o cep
		$cep = str_replace("-", "", $cep);
		
		// Busca os métodos de envio ativo
		$list = $model->fetchAll(array("ativo = 1"));
		
		// Percorre os métodos de envio
		$metodos_envio = array();
		foreach($list as $metodo_envio) {
			$metodos_envio[] = $metodo_envio->idmetodo_envio;
		}
		
		// Inicializa os fretes
		$fretes = array();
		
		// Busca os fretes da transportadora Ramos
// 		if(in_array(1010, $metodos_envio)) {
// 			$ramos = new gazetamarista_Transportadoras_Ramos($cep, $metodos_envio, $produtos);
// 			$fretes += $ramos->fretes();
// 		}
		
		// Verifica os fretes dos correios offline
		if((in_array(101, $metodos_envio)) || (in_array(102, $metodos_envio)) || (in_array(103, $metodos_envio)) || (in_array(104, $metodos_envio)) || (in_array(105, $metodos_envio))) {
			$correios_offline = new gazetamarista_Transportadoras_Correiosoffline($cep, $metodos_envio, $produtos);
			$fretes += $correios_offline->fretes();
		}
		
		// Verifica os fretes dos correios online
		if((in_array(40010, $metodos_envio)) || (in_array(40101, $metodos_envio)) || (in_array(40045, $metodos_envio)) || (in_array(40215, $metodos_envio)) || (in_array(41106, $metodos_envio))) {
			$correios_offline = new gazetamarista_Transportadoras_Correiosonline($cep, $metodos_envio, $produtos);
			$fretes += $correios_offline->fretes();
		}
		
		// Percorre os produtos para criar o where da busca
		$where = array(0);
		foreach($produtos as $idproduto => $quantidade) {
			$where[] = $idproduto;
		}
		
		// Cria o model dos produtos
		$model = new Admin_Model_Produtos();
		
		// Busca os produtos do carrinho
		$produtos = $model->fetchAll(array("idproduto in (" . implode(",", $where) . ")"), array("largura DESC", "comprimento DESC"));
		
		// Inicializa o prazo adicional de entrega e o frete gratis
		$prazo_entrega = 0;
		$frete_gratis = FALSE;
		
		// Percorre os produtos
		foreach($produtos as $produto) {
			// Verifica se o produto possui prazo de entrega adicional
			if($produto->prazo_entrega > $prazo_entrega) {
				$prazo_entrega = $produto->prazo_entrega;
			}
				
			// Verifica se o produto possui frete gratis
			if($produto->frete_gratis == 1) {
				$frete_gratis = TRUE;
			}
		}
		
		// Verifica se deve adicionar frete gratis
		if($frete_gratis == TRUE) {
			// Limpa o array de fretes para exibir somente o grátis
			unset($fretes);
			
			// Adiciona o método de frete gratis
			$fretes = array();
			$fretes[1] = array(
				'codigo' => 1,
				'nome' => "Frete Grátis",
				'valor' => 0.00,
				'entrega' => (int)$this->_config->prazo_adicional,
				'erro' => ''
			);
		}
		
		// Verifica se possui prazo de entrega adicional por produto
		if($prazo_entrega > 0) {
			// Percorre os fretes
			foreach($fretes as $key => $_frete) {
				// Incrementa o valor do prazo de entrega do produto
				$fretes[$key]['entrega'] += $prazo_entrega;
			}
		}
		
		// Retorna os fretes
		return $fretes;
	}
}