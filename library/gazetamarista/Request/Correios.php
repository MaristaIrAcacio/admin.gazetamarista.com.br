<?php
/**
 * Faz requisições ao correios
 *
 * @name gazetamarista_Correios
 */
class gazetamarista_Request_Correios {
	/**
	 * Busca as informações do cep
	 * 
	 * @name cep
	 */
	public function cep($cep) {
		// Função curl
		function simple_curl($url,$post=array(),$get=array()) {
			$url = explode('?',$url,2);
			if(count($url) === 2){
				$temp_get = array();
				parse_str($url[1],$temp_get);
				$get = array_merge($get,$temp_get);
			}
			
			$ch = curl_init($url[0]."?".http_build_query($get));
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			return curl_exec ($ch);
		}

		$cep = str_replace('.','',str_replace('-','',trim($cep)));
		if(strlen($cep) === 8 && is_numeric($cep)){
		
			// Requer a classe para o parse do site dos correios
			require_once("gazetamarista/Library/phpQuery-onefile.php");
			
			// Capturamos o HTML através da chamada cURL, enviando os parametros necessários
			$html = simple_curl('http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do',array(
				'Metodo' => 'listaLogradouro',
				'TipoConsulta' => 'relaxation',
				'StartRow' => '1',
				'EndRow' => '10',
				'relaxation' => $cep
			));
			
			// Fazemos o phpQuery ler o HTML retornado
			phpQuery::newDocumentHTML($html, $charset = 'utf-8');
			
			$dados = array();
			$c = 0;
			$t = count(pq('.ctrlcontent table tr'));
			foreach(pq('.ctrlcontent table tr') as $tr){
				if($c > 1 && $c < ((int)$t - 1)){
					$dados[] = array(
						'logradouro' => trim(pq($tr)->find('td:eq(0)')->text()),
						'bairro'	 => trim(pq($tr)->find('td:eq(1)')->text()),
						'cidade'	 => trim(pq($tr)->find('td:eq(2)')->text()),
						'uf'		 => trim(pq($tr)->find('td:eq(3)')->text()),
						'cep'		 => trim(pq($tr)->find('td:eq(4)')->text())
					);
				}
				$c++;
			}

			if(count($dados) > 0) {
				$dados = $dados[0];
			}

		}else{
			// Cep inválido
			$dados = array(
				'erro' => 'Cep inválido.'
			);
		}
		
		// Retorna o vetor com as informações
		return $dados;
	}
	
	/**
	 * Faz requisições de frete
	 * 
	 * @name frete
	 */
	public function frete($cep_origem, $cep_destino, $peso, $comprimento, $altura, $largura, $valor_declarado, $cod_servico) {
		// Assina os modulos habilitados
		$modules = Zend_Registry::get("modulos");
		
		// Verifica se o comprimento é menor que 16
		if($comprimento < 16) {
			$comprimento = 16;
		}
		
		// Verifica se a largura é menor que 11
		if($largura < 11) {
			$largura = 11;
		}
		
		// Verifica se a altura é menor que 2
		if($altura < 2) {
			$altura = 2;
		}
		
		// Cria a url
		$url  = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";
		$url .= "?nCdEmpresa=";
		$url .= "&sDsSenha=";
		$url .= "&sCepOrigem=" . $cep_origem;
		$url .= "&sCepDestino=" . $cep_destino;
		$url .= "&nVlPeso=" . $peso;
		$url .= "&nCdFormato=1";
		$url .= "&nVlComprimento=" . $comprimento;
		$url .= "&nVlAltura=" . $altura;
		$url .= "&nVlLargura=" . $largura;
		$url .= "&sCdMaoPropria=n";
		$url .= "&nVlValorDeclarado=" . number_format($valor_declarado, 2, ",", ".");
		$url .= "&sCdAvisoRecebimento=n";
		$url .= "&nCdServico=" . $cod_servico;
		$url .= "&nVlDiametro=0&StrRetorno=xml";
		
		// Cria o objeto de requisição remota e configura
		$client = new Zend_Http_Client();
		$client->setUri($url);
		
		// Faz a requisição
		$response = $client->request("GET");
		
		// Xml
		$xml = $response->getBody();
		
		// Cria o model dos metodos de envio
		$model = new Admin_Model_Metodosenvio();
		
		// Percorre os retornos
		$fretes = array();
		foreach(simplexml_load_string($xml) as $frete) {
			// Busca o nome do serviço
			$nome = $model->fetchRow(array('idmetodo_envio = ?' => (string)$frete->Codigo))->descricao;
			
			// Verifica se existe erro
			if(strlen((string)$frete->MsgErro) <= 0) {
				// Cria o vetor amigavel
				$fretes[(string)$frete->Codigo] = array(
					'codigo' => (string)$frete->Codigo,
					'nome' => $nome,
					'valor' => str_replace(",", ".", (string)$frete->Valor),
					'entrega' => ((int)$frete->PrazoEntrega) + $modules->frete->somar_dias,
					'erro' => (string)$frete->MsgErro
				);
			}
		}
		
		// Retorna os fretes
		return $fretes;
	}
}