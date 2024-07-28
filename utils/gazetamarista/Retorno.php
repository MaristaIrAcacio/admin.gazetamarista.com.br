<?php

/**
 * Classe mensagem de retorno
 * 
 * @name gazetamarista_Retorno
 */
class gazetamarista_Retorno {
	
	/**
	 * retornoAjaxMSG [Função que retorno as mensagem em json, para serem usadas nos alerts do ajax]
	 * @param  string $status     [Tipo de status, success ou error]
	 * @param  string $titulo     [Título do alerta/mensagem]
	 * @param  string $mensagem   [Mensagem que será exibida]
	 * @param  string $textoBotao [Caso tenha um botão colocar o texto desta variável]
	 * @return [type]             [retorna um json com as informações]
	 */
	public function ajaxmsg( $status = '', $titulo = '', $itens = '', $mensagem = '', $textoBotao = 'Continuar' ){
		return json_encode(
			array(
				'status' => $status,
				'titulo' => $titulo,
				'itens' => $itens,
				'mensagem' => $mensagem,
				'textoBotao' => $textoBotao
			)
		);
	}
	
	/**
	 * retornoAjaxMSG [Função que retorno as mensagem em json, para serem usadas nos alerts do ajax]
	 * 
	 */
	public function ajaxmsgarray( $array ){
		return json_encode(
			$array
		);
	}
}