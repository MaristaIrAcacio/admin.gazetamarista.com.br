<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Itaú: Glauber Portella                        |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
//Zend_Debug::dump($this->_pedido);exit;
$data = strtotime($this->_pedido->data_criacao);

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = $this->_config->validade;
$taxa_boleto = $this->_config->taxa_boleto;
$data_proc = date("d/m/Y", $data);
$data_venc = date("d/m/Y", $data + ($dias_de_prazo_para_pagamento * 86400));

$pedido_valor = $this->_pedido->valor_pedido;
$pedido_frete = $this->_pedido->valor_frete;
$pedido_desconto = $this->_pedido->valor_desconto;
$valor_cobrado = number_format(($pedido_valor + $pedido_frete - $pedido_desconto), 2, ".", ""); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = sprintf("%08d", $this->_idpedido);  // Nosso numero - REGRA: Máximo de 8 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = $data_proc; // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $this->_pedido->nome_pagamento . " " . $this->_pedido->sobrenome_pagamento;
$dadosboleto["endereco1"] = $this->_pedido->endereco_entrega . ", " . $this->_pedido->numero_entrega;
$dadosboleto["endereco2"] = $this->_pedido->cidade_entrega . " - " . $this->_pedido->estado_entrega . " - CEP: " . $this->_pedido->cep_entrega;

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra na PNEULINE PNEUS E SERVIÇOS LTDA";
$dadosboleto["demonstrativo2"] = "CNPJ:37.994.092/0001-82";
$dadosboleto["demonstrativo3"] = "Referente ao pedido " . sprintf("%08d", $this->_idpedido);
$dadosboleto["instrucoes1"] = "ATENÇÃO:";
$dadosboleto["instrucoes2"] = "";
$dadosboleto["instrucoes3"] = "NÃO SERÃO ACEITOS TRANSFERÊNCIAS OU DEPÓSITOS PARA O PAGAMENTO  DESTE BOLETO.";
$dadosboleto["instrucoes4"] = "";// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra na PNEULINE PNEUS E SERVIÇOS LTDA";
$dadosboleto["demonstrativo2"] = "CNPJ:37.994.092/0001-82";
$dadosboleto["demonstrativo3"] = "Referente ao pedido " . sprintf("%08d", $this->_idpedido);
$dadosboleto["instrucoes1"] = "ATENÇÃO:";
$dadosboleto["instrucoes2"] = "";
$dadosboleto["instrucoes3"] = "NÃO SERÃO ACEITOS TRANSFERÊNCIAS OU DEPÓSITOS PARA O PAGAMENTO  DESTE BOLETO.";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - ITAÚ
$dadosboleto["agencia"] = $this->_config->agencia; // Num da agencia, sem digito
$dadosboleto["conta"] = $this->_config->conta;	// Num da conta, sem digito
$dadosboleto["conta_dv"] = $this->_config->digito; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - ITAÚ
$dadosboleto["carteira"] = $this->_config->carteira;  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

// SEUS DADOS
$dadosboleto["identificacao"] = $this->_modules->loja->nome;
$dadosboleto["cpf_cnpj"] = $this->_modules->loja->cnpj;
$dadosboleto["endereco"] = $this->_modules->loja->endereco;
$dadosboleto["cidade_uf"] = $this->_modules->loja->cidade . " / " . $this->_modules->loja->estado;
$dadosboleto["cedente"] = $this->_modules->loja->nome;

// NÃO ALTERAR!
// include("include/funcoes_itau.php"); 
// include("include/layout_itau.php");
?>
