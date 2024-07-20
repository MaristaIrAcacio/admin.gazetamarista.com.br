<?php

/**
 * Cria o helper do bbcode
 * 
 * @name Zend_View_Helper_Bbcode
 */
class gazetamarista_View_Helper_Bbcode extends Zend_View_Helper_Abstract {
	/**
	 * Método da classe
	 * 
	 * @param string $string Texto para converter para bbcode
	 */
	public function bbcode($string) {
		// Cria as buscas
		$simple_search = array(  
			"/\[br\]/is",
			"/\[b\](.*?)\[\/b\]/is",
			"/\[i\](.*?)\[\/i\]/is",
			"/\[u\](.*?)\[\/u\]/is",
			"/\[url\=(.*?)\](.*?)\[\/url\]/is",
			"/\[url\](.*?)\[\/url\]/is",
			"/\[align\=(left|center|right)\](.*?)\[\/align\]/is",
			"/\[img\](.*?)\[\/img\]/is",
			"/\[mail\=(.*?)\](.*?)\[\/mail\]/is",
			"/\[mail\](.*?)\[\/mail\]/is",
			"/\[font\=(.*?)\](.*?)\[\/font\]/is",
			"/\[size\=(.*?)\](.*?)\[\/size\]/is",
			"/\[color\=(.*?)\](.*?)\[\/color\]/is",
			"/\[codearea\](.*?)\[\/codearea\]/is",
			"/\[code\](.*?)\[\/code\]/is",
			"/\[p\](.*?)\[\/p\]/is",
			"/\[h1\](.*?)\[\/h1\]/is",
			"/\[h2\](.*?)\[\/h2\]/is",
			"/\[h3\](.*?)\[\/h3\]/is",
			"/\[h4\](.*?)\[\/h4\]/is",
			"/\[youtube\]\s*(?:https?\:\/\/)?(?:www\.)?(?:youtube\.com(?:\.br)?\/watch\?v=|youtu\.be\/)([\w\-]{11})\s*\[\/youtube\]/is"
		);  
		
		// Cria as trocas
		$simple_replace = array(  
			"<br />",
			"<strong>$1</strong>",
			"<em>$1</em>",
			"<u>$1</u>",
			"<a href=\"$1\" rel=\"nofollow\" title=\"$2 - $1\">$2</a>",
			"<a href=\"$1\" rel=\"nofollow\" title=\"$1\">$1</a>",
			"<div style=\"text-align: $1;\">$2</div>",
			"<img src=\"$1\" alt=\"\" />",
			"<a href=\"mailto:$1\">$2</a>",
			"<a href=\"mailto:$1\">$1</a>",
			"<span style=\"font-family: $1;\">$2</span>",
			"<span style=\"font-size: $1;\">$2</span>",
			"<span style=\"color: $1;\">$2</span>",
			"<textarea class=\"code_container\" rows=\"30\" cols=\"70\">$1</textarea>",
			"<pre class=\"code\">$1</pre>",
			"<p>$1</p>",
			"<h1>$1</h1>",
			"<h2>$1</h2>",
			"<h3>$1</h3>",
			"<h4>$1</h4>",
			"<iframe width=\"640\" height=\"365\" src=\"//www.youtube.com/embed/$1?controls=1&showinfo=0&autohide=1\" frameborder=\"0\" allowfullscreen></iframe>"
		);
		
		// Refaz as trocas
		$string = preg_replace ($simple_search, $simple_replace, $string); 
		
		// Quebras de linha
		$string = nl2br($string);
		
		// Retorna a string formatada
		return $string;
	}
}