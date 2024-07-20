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
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				  |
// | 														              |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						  |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINAMICOS DO SEU CLIENTE PARA A GERACAO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulario c/ POST, GET ou de BD (MySql,Postgre,etc)	//
$data = strtotime($this->_pedido->data_criacao);

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = $this->_config->validade;
$taxa_boleto = $this->_config->taxa_boleto;
$data_proc = date("d/m/Y", $data);
$data_venc = date("d/m/Y", $data + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";

$pedido_valor = $this->_pedido->valor_pedido;
$pedido_frete = $this->_pedido->valor_frete;
$pedido_desconto = $this->_pedido->valor_desconto;
$valor_cobrado = number_format(($pedido_valor + $pedido_frete - $pedido_desconto), 2, ".", ""); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] 		= sprintf("%08d", $this->_idpedido); // Nosso numero sem o DV - REGRA: Maximo de 11 caracteres!
$dadosboleto["numero_documento"] 	= $dadosboleto["nosso_numero"]; // Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] 	= $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] 		= date("d/m/Y"); // Data de emissao do Boleto
$dadosboleto["data_processamento"] 	= $data_proc; // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] 		= $valor_boleto; // Valor do Boleto - REGRA: Com virgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $this->_pedido->nome_pagamento . " " . $this->_pedido->sobrenome_pagamento;
$dadosboleto["endereco1"] = $this->_pedido->endereco_entrega . ", " . $this->_pedido->numero_entrega;
$dadosboleto["endereco2"] = $this->_pedido->cidade_entrega . " - " . $this->_pedido->estado_entrega . " -  CEP: " . $this->_pedido->cep_entrega;

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra na PNEULINE PNEUS E SERVIÇOS LTDA";
$dadosboleto["demonstrativo2"] = "CNPJ:37.994.092/0001-82";
$dadosboleto["demonstrativo3"] = "Referente ao pedido " . sprintf("%08d", $this->_idpedido);
$dadosboleto["instrucoes1"] = "ATENÇÃO:";
$dadosboleto["instrucoes2"] = "";
$dadosboleto["instrucoes3"] = "NÃO SERÃO ACEITOS TRANSFERÊNCIAS OU DEPÓSITOS PARA O PAGAMENTO DESTE BOLETO.";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = $this->_config->aceite;		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";

// ---------------------- DADOS FIXOS DE CONFIGURACAO DO SEU BOLETO --------------- //

// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = $this->_config->agencia; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = $this->_config->agencia_dv; // Digito do Num da agencia
$dadosboleto["conta"] = $this->_config->conta; // Num da conta, sem digito
$dadosboleto["conta_dv"] = $this->_config->conta_dv; // Digito do Num da conta
$dadosboleto["conta_cedente"] = $this->_config->conta_cedente; // Num da conta, sem digito
$dadosboleto["conta_cedente_dv"] = $this->_config->conta_cedente_dv; // Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["carteira"] = $this->_config->carteira; // Codigo da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = $this->_modules->loja->nome;
$dadosboleto["cpf_cnpj"] = $this->_modules->loja->cnpj;
$dadosboleto["endereco"] = $this->_modules->loja->endereco;
$dadosboleto["cidade_uf"] = $this->_modules->loja->cidade . " / " . $this->_modules->loja->estado;
$dadosboleto["cedente"] = $this->_modules->loja->nome;
?>