<?php

/**
 * Captura a caixa de entrada gmail
 * Conta configurada como imap
 *
 * @name gazetamarista_Capturaremail
 */
class gazetamarista_Capturaremail {
	/**
	 * Armazena as configurações gerais
	 *
	 * @access private
	 * @name _configgazetamarista_Capturaremail
	 * @var Zend_Config
	 */
	private $_config = NULL;
	
	/**
	 * Percorre o e-mails da caixa de entrada
	 *
	 * @name caixaentrada
	 */
	public function caixaentrada() {
		// Configure com seu login/senha
		$login = 'testegazetamarista';
		$senha = '##gazetamarista@@';
		
		$str_conexao = '{imap.gmail.com:993/imap/ssl}';
		if (!extension_loaded('imap')) {
			die('Modulo PHP/IMAP nao foi carregado');
		}
		
		// Abrindo conexao
		//$mailbox = imap_open("{" . SERVIDOR . ":" . PORTA . "/pop3/novalidate-cert}INBOX", USUARIO, SENHA);
		$mailbox = imap_open($str_conexao, $login, $senha);
		if (!$mailbox) {
			die('Erro ao conectar: '.imap_last_error());
		}
		
		// Obtendo dados básicos sobre a conta
		$check = imap_check($mailbox);
		
		// Ultima mensagem
		echo "<br>Date: " . $check->Date;
		
		// Tipo de conexao
		echo "<br>Driver: " . $check->Driver;
		
		// Mailbox
		echo "<br>Mailbox: " . $check->Mailbox;
		
		// Numero de mensagens total
		echo "<br>Nmsgs: " . $check->Nmsgs;
		
		// Numero de mensagens novas
		echo "<br>Recent: " . $check->Recent;
		
		echo("<br><br>++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++<br><br>");
		
		//No body, imap_fetchbody, o terceiro parametro pode ser:
		//0=> retorna o body da mensagem com o texto que o servidor recebe
		//1=> retorna somente o conteudo da mensagem em plain-text
		//2=> retorna o conteudo da mensagem em html
		
		$total_de_mensagens = $check->Nmsgs;
		if ($total_de_mensagens > 0) {
			for ($mensagem = 1; $mensagem <= $total_de_mensagens; $mensagem++) {
				// Cabeçalho
				$header = imap_headerinfo($mailbox, $mensagem);
				
				// Conteúdo
				$body = (imap_fetchbody($mailbox, $mensagem, 1));
				//$body = imap_body($mailbox, 1);
				
				$structure = imap_fetchstructure($mailbox, $mensagem);
				if ($structure->encoding == 3) {
					$body = base64_decode($body);
				} else if ($structure->encoding == 4) {
					$body = imap_qprint($body);
				} else if ($structure->encoding == 0) {
					$body = $this->decode7Bit($body);
				}
				
				echo("<br>----------------------------------------------------------------------------<br>" . $body);
				
				//imap_delete($mail_box, $mensagem);
				//imap_expunge($mail_box);
			}
		}
		
		// Fechar a conexão IMAP
		imap_close($mailbox);
		
		die("<br><br><br>FIM");
	}
	
	// Função decode7Bit
	public function decode7Bit($text){
		// If there are no spaces on the first line, assume that the body is
		// actually base64-encoded, and decode it.
		$lines = explode("\r\n", $text);
		$first_line_words = explode(' ', $lines[0]);
		if ($first_line_words[0] == $lines[0]) {
			$text = base64_decode($text);
		}
	
		// Manually convert common encoded characters into their UTF-8 equivalents.
		$characters = array(
			'=20' 		=> ' ', // space.
			'=E2=80=99' => "'", // single quote.
			'=0A' 		=> "\r\n", // line break.
			'=A0' 		=> ' ', // non-breaking space.
			'=C2=A0' 	=> ' ', // non-breaking space.
			"=\r\n" 	=> '', // joined line.
			'=E2=80=A6' => '…', // ellipsis.
			'=E2=80=A2' => '•', // bullet.
		);
	
		// Loop through the encoded characters and replace any that are found.
		foreach ($characters as $key => $value) {
			$text = str_replace($key, $value, $text);
		}
	
		return $text;
	}
}