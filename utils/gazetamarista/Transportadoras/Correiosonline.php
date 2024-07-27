<?php
/**
 * Faz requisições ao webservice dos correios 
 *
 * @name gazetamarista_Transportadoras_Correiosonline
 */
class gazetamarista_Transportadoras_Correiosonline extends gazetamarista_Transportadoras_Abstract {
	/**
	 * Armazena o nome da integração
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "correios";
	
	/**
	 * Armazena os métodos de envio à buscar
	 * 
	 * @access protected
	 * @name $metodos_envio
	 * @var array
	 */
	protected $metodos_envio = array();
	
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
		// Verifica quais os métodos de envio buscar
		foreach($this->_metodos_envio as $metodo_envio) {
			// Verifica se o código unico faz parte da transportadora
			if((40010 == $metodo_envio) || (40101 == $metodo_envio) || (40045 == $metodo_envio) || (40215 == $metodo_envio) || (41106 == $metodo_envio)) {
				$this->metodos_envio[] = $metodo_envio;
			}
		}
		
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
		$this->infos['peso'] 			= 0;
		$this->infos['comprimento'] 	= $produtos->current()->comprimento;
		$this->infos['largura'] 		= $produtos->current()->largura;
		$this->infos['altura'] 			= 0;
		$this->infos['valor_declarado'] = 0;
		
		// Percorre os produtos
		foreach($produtos as $produto) {
			if($produto->peso > 0) {
				// Soma o peso dos produtos
				$this->infos['peso'] += $produto->peso * $this->_produtos[$produto->idproduto]['quantidade'];
			}
			
			if($produto->altura > 0) {
				// Soma a altura dos produtos
				$this->infos['altura'] += $produto->altura * $this->_produtos[$produto->idproduto]['quantidade'];
			}
			
			if($produto->preco_venda > 0) {
				// Soma o preço dos produtos
				$this->infos['valor_declarado'] += $produto->preco_venda * $this->_produtos[$produto->idproduto]['quantidade'];
			}
		}
		
		// Verifica comprimento (mínimo 16cm e máximo 105cm)
		if($this->infos['comprimento'] < 16) {
			$this->infos['comprimento'] = 16;
		}
		if($this->infos['comprimento'] > 105) {
			$this->infos['comprimento'] = 105;
		}
		
		// Verifica largura (mínimo 11cm e máximo 105cm)
		if($this->infos['largura'] < 11) {
			$this->infos['largura'] = 11;
		}
		
		// Verifica altura (mínimo 2cm e máximo 105cm)
		if($this->infos['altura'] < 2) {
			$this->infos['altura'] = 2;
		}
		if($this->infos['altura'] > 105) {
			$this->infos['altura'] = 105;
		}

		// Valor declarado (mínimo de 18,00 e máximo de 10.000,00)
		if($this->infos['valor_declarado'] < 18) {
			$this->infos['valor_declarado'] = 18.00;
		}
		if($this->infos['valor_declarado'] > 10000) {
			$this->infos['valor_declarado'] = 10000.00;
		}

		// Peso (mínimo 2cm e máximo 30kg)
		// A soma resultante do comprimento + largura + altura não deve superar 200 cm
		// A soma resultante do comprimento + o dobro do diâmetro não pode ser menor que 28 cm
		// O valor declarado não pode exceder R$ 10.000,00
	}
	
	/**
	 * Faz requisições de frete
	 * 
	 * @name frete
	 * @return array
	 */
	public function fretes() {
		// Cria a url
		$url  = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";
			$url .= "?nCdEmpresa=";
			$url .= "&sDsSenha=";
			$url .= "&sCepOrigem=" . $this->_config->cep_origem;
			$url .= "&sCepDestino=" . $this->_cep_destino;
			$url .= "&nVlPeso=" . $this->infos['peso'];
			$url .= "&nCdFormato=1"; // caixa/pacote
			$url .= "&nVlComprimento=" . str_replace(".", ",", $this->infos['comprimento']);
			$url .= "&nVlAltura=" . str_replace(".", ",", $this->infos['altura']);
			$url .= "&nVlLargura=" . str_replace(".", ",", $this->infos['largura']);
			$url .= "&sCdMaoPropria=n";
			$url .= "&nVlValorDeclarado=" . number_format($this->infos['valor_declarado'], 2, ",", "");
			$url .= "&sCdAvisoRecebimento=n";
			$url .= "&nCdServico=" . implode(",", $this->metodos_envio);
			$url .= "&nVlDiametro=0&StrRetorno=xml";
			
		// Cria o objeto de requisição remota e configura
		$client = new Zend_Http_Client();
		$client->setUri($url);
		
		// Faz a requisição
		$response = $client->request("GET");
		$xml = $response->getBody();

		// Cria o model dos metodos de envio
		$model = new Admin_Model_Metodosenvio();
		
		//Zend_Debug::dump($xml);exit;
		
		// Percorre os retornos
		$fretes = array();
		if(simplexml_load_string($xml)) {
			foreach(simplexml_load_string($xml) as $frete) {
				// Busca o nome do serviço
				$nome = $model->fetchRow(array('idmetodo_envio = ?' => (string)$frete->Codigo))->descricao;
				
				// Verifica se existe erro
				if(strlen((string)$frete->MsgErro) <= 0) {
					// Cria o vetor
					$fretes[(string)$frete->Codigo] = array(
						'codigo' => (int)$frete->Codigo,
						'nome' => $nome,
						'valor' => (float)str_replace(",", ".", (string)$frete->Valor),
						'entrega' => ((int)$frete->PrazoEntrega) + $modules->frete->somar_dias,
						'erro' => (string)$frete->MsgErro
					);
				}else{
// 					$fretes[(string)$frete->Codigo] = array(
// 						'erro' => (string)$frete->Erro . ": " . (string)$frete->MsgErro
// 					);
				}
			}
		}else{
			$fretes['errofrete'] = "Ocorreu um erro, tente novamente ou entre em contato conosco";
		}
		
		//Zend_Debug::dump($fretes);exit;
		
		// Retorna os fretes
		return $fretes;
	}
	
// 	Manual de implementação do webservice de cálculo de preços e prazos de encomendas
// 	Código de erro Mensagem de erro
// 	0 Processamento com sucesso
// 	-1 Código de serviço inválido
// 	-2 CEP de origem inválido
// 	-3 CEP de destino inválido
// 	-4 Peso excedido
// 	-5 O Valor Declarado não deve exceder R$ 10.000,00
// 	-6 Serviço indisponível para o trecho informado
// 	-7 O Valor Declarado é obrigatório para este serviço
// 	-8 Este serviço não aceita Mão Própria
// 	-9 Este serviço não aceita Aviso de Recebimento
// 	-10 Precificação indisponível para o trecho informado
// 	-11 Para definição do preço deverão ser informados, também, o comprimento, a largura e altura do objeto em centímetros (cm).
// 	-12 Comprimento inválido.
// 	-13 Largura inválida.
// 	-14 Altura inválida.
// 	-15 O comprimento não pode ser maior que 105 cm.
// 	-16 A largura não pode ser maior que 105 cm.
// 	-17 A altura não pode ser maior que 105 cm.
// 	-18 A altura não pode ser inferior a 2 cm.
// 	-20 A largura não pode ser inferior a 11 cm.
// 	-22 O comprimento não pode ser inferior a 16 cm.
// 	-23 A soma resultante do comprimento + largura + altura não deve superar a 200 cm.
// 	-24 Comprimento inválido.
// 	-25 Diâmetro inválido
// 	-26 Informe o comprimento.
// 	-27 Informe o diâmetro.
// 	-28 O comprimento não pode ser maior que 105 cm.
// 	-29 O diâmetro não pode ser maior que 91 cm.
// 	-30 O comprimento não pode ser inferior a 18 cm.
// 	-31 O diâmetro não pode ser inferior a 5 cm.
// 	-32 A soma resultante do comprimento + o dobro do diâmetro não deve superar a 200 cm.
// 	-33 Sistema temporariamente fora do ar. Favor tentar mais tarde.
// 	-34 Código Administrativo ou Senha inválidos.
// 	-35 Senha incorreta.
// 	-36 Cliente não possui contrato vigente com os Correios.
// 	-37 Cliente não possui serviço ativo em seu contrato.
// 	-38 Serviço indisponível para este código administrativo.
// 	-39 Peso excedido para o formato envelope
// 	-40 Para definicao do preco deverao ser informados, tambem, o comprimento e a largura e altura do objeto em centimetros (cm).
// 	-41 O comprimento nao pode ser maior que 60 cm.
// 	-42 O comprimento nao pode ser inferior a 16 cm.
// 	-43 A soma resultante do comprimento + largura nao deve superar a 120 cm.
// 	-44 A largura nao pode ser inferior a 11 cm.
// 	-45 A largura nao pode ser maior que 60 cm.
// 	-888 Erro ao calcular a tarifa
// 	006 Localidade de origem não abrange o serviço informado
// 	007 Localidade de destino não abrange o serviço informado
// 	008 Serviço indisponível para o trecho informado
// 	009 CEP inicial pertencente a Área de Risco.
// 	010 Área com entrega temporariamente sujeita a prazo diferenciado.
// 	011 CEP inicial e final pertencentes a Área de Risco
// 	7 Serviço indisponível, tente mais tarde
// 	99 Outros erros diversos do .Net
	
}