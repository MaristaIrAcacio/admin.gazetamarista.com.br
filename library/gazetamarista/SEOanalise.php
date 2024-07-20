<?php
/**
 * Class gazetamarista_SEOanalise
 * 
 * @name gazetamarista_SEOanalise
 *
 * @author  gazetamarista - Rossi
 */
class gazetamarista_SEOanalise {
	/**
	 * Configurações gerais
	 *
	 * @access private
	 * @name _config
	 * @var $_config
	 */
	private $_config = NULL;

	/**
	 * Url do projeto
	 *
	 * @access private
	 * @name _dominio
	 * @var $_dominio
	 */
	private $_dominio = NULL;

	/**
	 * Configurações do DB
	 *
	 * @access private
	 * @name _db
	 * @var $_db
	 */
	private $_db = NULL;

	/**
	 * Slug
	 *
	 * @access private
	 * @name _slug
	 * @var $_slug
	 */
	private $_slug = NULL;

	/**
	 * Resposta da análise
	 *
	 * @var array
	 */
	protected $retorno = false;

	/**
	 * Método de inicialização da classe
	 * 
	 * @name init
	 */
	public function __construct() {
		// Instancia o Zend_Registry
		$zend_registry = new Zend_Registry;

		// Busca as configurações gerais
		$this->_config = $zend_registry->get('config');

		// Url do projeto
		if ($_SERVER['HTTP_HOST'] == "localhost") {
            $this->_dominio = "http://localhost" . $this->_config->gazetamarista->config->basepath;
        } elseif ($_SERVER['HTTP_HOST'] == "sites.gazetamarista.com.br") {
            $this->_dominio = "http://sites.gazetamarista.com.br" . $this->_config->gazetamarista->config->basepath;
        } else {
            $this->_dominio = "http://" . $this->_config->gazetamarista->config->domain;
        }

        // Instancia o db
	    $this->_db = $zend_registry->get("db");

	    // Instancia o slug
	    $this->_slug = new gazetamarista_View_Helper_CreateSlug();
	}

	/**
	 * Retorna o array de dados da análise do artigo
	 * 
	 * @name seo
	 * @param Array $post
	 * @return Array $retorno
	 */
	public function seo($post) {
		// Inicia variáveis
		$itens 		 = array();
		$total_otimo = 0;
		$total_bom   = 0;
		$total_ruim  = 0;

		if(is_array($post) || is_object($post)) {
			if(is_array($post)) {
				// Executado do form
				$idprimary 			= addslashes(($post["idprimary"]));
				$imagem_temp_url 	= addslashes(($post["imagem_temp"]));
			}else{
				// Executado do list
				$idprimary = addslashes(($post["idblog"]));
			}

            // Busca params
            $titulo 			= addslashes(($post["titulo"]));
            $imagem_url 		= addslashes(($post["imagem"]));
			$texto 				= addslashes(($post["texto"]));
			$meta_palavra_chave = addslashes(($post["meta_palavra_chave"]));
			$meta_slug 			= addslashes(($post["meta_slug"]));
			$meta_title 		= addslashes(($post["meta_title"]));
			$meta_description 	= addslashes(($post["meta_description"]));

			if($titulo != "") {
				// SLUG
				if($meta_slug != "") {
					$meta_slug = $meta_slug;
				}else{
					$meta_slug = $this->_slug->createslug($titulo);
				}

				// TAMANHO DO TÍTULO DO ARTIGO
				$qtd_caracteres_titulo = strlen(utf8_decode($titulo));

				if($qtd_caracteres_titulo > 38) {
					$total_otimo++;
					$itens[] = array(
						'item_descricao' => "TAMANHO DO TÍTULO DO ARTIGO",
		            	'item_nivel' 	 => "ótimo",
		            	'item_cor' 		 => "green",
		            	'item_frase' 	 => "O título do artigo tem um bom comprimento."
					);
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "TAMANHO DO TÍTULO DO ARTIGO",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "O título do artigo é muito curto. Use o espaço para adicionar variações de palavras-chave ou criar uma chamada convincente para a ação."
					);
				}
			}else{
				$total_ruim++;
				$itens[] = array(
					'item_descricao' => "TAMANHO DO TÍTULO DO ARTIGO",
	            	'item_nivel' 	 => "ruim",
	            	'item_cor' 		 => "red",
	            	'item_frase' 	 => "O título do artigo não foi especificado."
				);
			}

			// PALAVRA-CHAVE DE FOCO
			if($meta_palavra_chave != "") {
				$total_otimo++;
				$itens[] = array(
					'item_descricao' => "PALAVRA-CHAVE DE FOCO",
	            	'item_nivel' 	 => "ótimo",
	            	'item_cor' 		 => "green",
	            	'item_frase' 	 => "A palavra-chave de foco foi definida."
				);
			}else{
				$total_ruim++;
				$itens[] = array(
					'item_descricao' => "PALAVRA-CHAVE DE FOCO",
	            	'item_nivel' 	 => "ruim",
	            	'item_cor' 		 => "red",
	            	'item_frase' 	 => "Nenhuma palavra-chave de foco foi definida para este artigo. É muito importante que você defina."
				);
			}

			if($texto != "") {
				// Limpa as tags, acentos e caracteres especiais do texto
				$texto_limpo = trim(html_entity_decode($texto, ENT_COMPAT, "UTF-8"));
				$texto_limpo = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $texto_limpo ) );
				$texto_limpo = addslashes($texto_limpo);
				$texto_limpo = strip_tags($texto_limpo);
				$texto_limpo = str_replace('&nbsp;', ' ', $texto_limpo);
				$texto_limpo = preg_replace('/\s/', ' ', $texto_limpo); // remove quebras
				$texto_limpo = preg_replace('/( ){2,}/', ' ', $texto_limpo); // remove espaços duplicados
				
				$span_descricao = $texto_limpo;

				// LINKS NO TEXTO
				$qtd_link = substr_count($texto, '<a href=');

				if($qtd_link > 0) {
					$total_otimo++;
					$itens[] = array(
						'item_descricao' => "LINKS NO TEXTO",
		            	'item_nivel' 	 => "ótimo",
		            	'item_cor' 		 => "green",
		            	'item_frase' 	 => "Esta página possui ".$qtd_link." link(s) de saída normal."
					);
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "LINKS NO TEXTO",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "Seu texto não possui links, considere adicionar alguns como apropriado. Ao menos 1 link é o ideal."
					);
				}

				$qtd_h2 = 0;
				$qtd_negrito = 0;
				if($meta_palavra_chave != "") {
					// Verifica palavra-chave h2
					$regex_h2 = "/<h2>(.*?)<\/h2>/";
					preg_match_all($regex_h2, $texto, $retorno_h2);

					if($retorno_h2) {
						foreach($retorno_h2[1] as $h2) {
							$existe_chave_h2 = strpos(strtolower(trim($h2)), strtolower($meta_palavra_chave));
							
							if($existe_chave_h2 !== false) {
								$qtd_h2 += 1;
							}
						}
					}

					// Verifica palavra-chave negrito
					$regex_negrito = "/<strong>(.*?)<\/strong>/";
					preg_match_all($regex_negrito, $texto, $retorno_negrito);

					if($retorno_negrito) {
						foreach($retorno_negrito[1] as $negrito) {
							$existe_chave_negrito = strpos(strtolower(trim($negrito)), strtolower($meta_palavra_chave));
							
							if($existe_chave_negrito !== false) {
								$qtd_negrito += 1;
							}
						}
					}

					// Total de aparições da palavra-chave no texto
					$txt_aparicoes 		 = str_replace('&nbsp;', ' ', $texto);
					$qtd_aparicoes_chave = substr_count(strtolower($txt_aparicoes), strtolower($meta_palavra_chave));

					// PALAVRA-CHAVE DE FOCO NO PRIMEIRO PARÁGRAFO DO TEXTO
					$existe_chave_texto = strpos(strtolower($texto_limpo), strtolower($meta_palavra_chave));

					if($existe_chave_texto !== false) {
						if($existe_chave_texto < 300) {
							$total_otimo++;
							$itens[] = array(
								'item_descricao' => "PALAVRA-CHAVE DE FOCO NO PRIMEIRO PARÁGRAFO DO TEXTO",
				            	'item_nivel' 	 => "ótimo",
				            	'item_cor' 		 => "green",
				            	'item_frase' 	 => "A palavra-chave de foco aparece no primeiro parágrafo do texto."
							);
						}else{
							$total_ruim++;
							$itens[] = array(
								'item_descricao' => "PALAVRA-CHAVE DE FOCO NO PRIMEIRO PARÁGRAFO DO TEXTO",
				            	'item_nivel' 	 => "ruim",
				            	'item_cor' 		 => "red",
				            	'item_frase' 	 => "A palavra-chave de foco não aparece no primeiro parágrafo do texto. Certifique-se de fazer isso com urgência."
							);
						}
					}
				}

				// PALAVRA-CHAVE DE FOCO EM SUB-TÍTULOS DO TEXTO (H2)
				if($qtd_h2 > 0) {
					$total_otimo++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO EM SUB-TÍTULOS DO TEXTO (H2)",
		            	'item_nivel' 	 => "ótimo",
		            	'item_cor' 		 => "green",
		            	'item_frase' 	 => "A palavra-chave de foco aparece em ".$qtd_h2." sub-título(s) no texto. Embora não seja um importante fator de classificação, isso é benéfico."
					);
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO EM SUB-TÍTULOS DO TEXTO (H2)",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "Você não usou a palavra-chave de foco em qualquer sub-título (Título 2 ou H2) em seu texto, é benéfico utilizar."
					);
				}

				// PALAVRA-CHAVE DE FOCO EM NEGRITO NO TEXTO (strong)
				if($qtd_negrito > 0) {
					$total_otimo++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO EM NEGRITO NO TEXTO (STRONG)",
		            	'item_nivel' 	 => "ótimo",
		            	'item_cor' 		 => "green",
		            	'item_frase' 	 => "A palavra-chave de foco aparece ".$qtd_negrito." vez(es) em negrito no texto. Embora não seja um importante fator de classificação, isso é benéfico."
					);
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO EM NEGRITO NO TEXTO (STRONG)",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "Você não usou a palavra-chave de foco em negrito (strong) no seu texto, é benéfico utilizar."
					);
				}

				// NÚMERO TOTAL DE PALAVRAS NO ARTIGO
				$qtd_palavras = str_word_count($texto_limpo);

				if($qtd_palavras > 199) {
					if($qtd_palavras > 299) {
						$total_otimo++;
						$itens[] = array(
							'item_descricao' => "NÚMERO TOTAL DE PALAVRAS NO ARTIGO",
			            	'item_nivel' 	 => "ótimo",
			            	'item_cor' 		 => "green",
			            	'item_frase' 	 => "O texto contém ".$qtd_palavras." palavra(s). Isto é mais ou igual ao mínimo recomendado de 300 palavras."
						);
					}else{
						$total_bom++;
						$itens[] = array(
							'item_descricao' => "NÚMERO TOTAL DE PALAVRAS NO ARTIGO",
			            	'item_nivel' 	 => "bom",
			            	'item_cor' 		 => "orange",
			            	'item_frase' 	 => "O texto contém ".$qtd_palavras." palavra(s). Isso é um pouco abaixo do recomendado de 300 palavras. Adicione um pouco mais de conteúdo."
						);
					}
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "NÚMERO TOTAL DE PALAVRAS NO ARTIGO",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "O texto contém ".$qtd_palavras." palavra(s). Isso é menos do que o mínimo de 300 palavras. Escreva mais conteúdo relevante."
					);
				}

				// DENSIDADE DE PALAVRAS-CHAVE NO TEXTO
				$densidade_chave = round(($qtd_aparicoes_chave / $qtd_palavras) * 100, 2);

				if($qtd_aparicoes_chave > 0) {
					if($densidade_chave >= 0.5) {
						$total_otimo++;
						$itens[] = array(
							'item_descricao' => "DENSIDADE DE PALAVRAS-CHAVE NO TEXTO",
			            	'item_nivel' 	 => "ótimo",
			            	'item_cor' 		 => "green",
			            	'item_frase' 	 => "A densidade de palavras-chave no seu texto é de ".$densidade_chave."%, o que é muito bom; A palavra-chave foco foi encontrada ".$qtd_aparicoes_chave." vez(es)."
						);
					}else{
						$total_bom++;
						$itens[] = array(
							'item_descricao' => "DENSIDADE DE PALAVRAS-CHAVE NO TEXTO",
			            	'item_nivel' 	 => "bom",
			            	'item_cor' 		 => "orange",
			            	'item_frase' 	 => "A densidade de palavras-chave é ".$densidade_chave."%, que é baixo. A palavra-chave de foco foi encontrada ".$qtd_aparicoes_chave." vez(es). Considere utilizar mais vezes a palavra-chave foco ao longo do texto."
						);
					}
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "DENSIDADE DE PALAVRAS-CHAVE NO TEXTO",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "A densidade de palavras-chave é 0%, que é muito baixo. A palavra-chave de foco não foi encontrada."
					);
				}
			}else{
				$total_ruim++;
				$itens[] = array(
					'item_descricao' => "NÚMERO TOTAL DE PALAVRAS NO ARTIGO",
	            	'item_nivel' 	 => "ruim",
	            	'item_cor' 		 => "red",
	            	'item_frase' 	 => "O texto não foi especificado. Escreva um conteúdo relevante, com sub-título e palavras-chave."
				);
			}

			// TÍTULO SEO
			if($meta_title == "") {
				$total_ruim++;
				$itens[] = array(
					'item_descricao' => "TÍTULO SEO",
	            	'item_nivel' 	 => "ruim",
	            	'item_cor' 		 => "red",
	            	'item_frase' 	 => "Nenhum título SEO foi especificado. Considere fazer isso com urgência."
				);

				$span_titulo = $titulo;
			}else{
				// TAMANHO DO TÍTULO SEO
				$qtd_caracteres = strlen(utf8_decode($meta_title));

				if($qtd_caracteres >= 35) {
					if($qtd_caracteres > 63) {
						$total_bom++;
						$itens[] = array(
							'item_descricao' => "TAMANHO DO TÍTULO SEO",
			            	'item_nivel' 	 => "bom",
			            	'item_cor' 		 => "orange",
			            	'item_frase' 	 => "O título SEO tem mais de 63 caracteres. Reduzindo o tamanho você garante que o título seja visível por inteiro nos mecanismos de pesquisa."
						);
					}else{
						$total_otimo++;
						$itens[] = array(
							'item_descricao' => "TAMANHO DO TÍTULO SEO",
			            	'item_nivel' 	 => "ótimo",
			            	'item_cor' 		 => "green",
			            	'item_frase' 	 => "O título SEO tem o mínimo de 35 caracteres e o máximo de 63 caracteres recomendado."
						);
					}
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "TAMANHO DO TÍTULO SEO",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "O título SEO tem menos de 20 caracteres. Considere utilizar até 63 caracteres."
					);
				}

				// PALAVRA-CHAVE DE FOCO NO TÍTULO SEO
				if($meta_palavra_chave != "") {
					$posicao_foco = strpos(strtolower($meta_title), strtolower($meta_palavra_chave));
					
					if($posicao_foco !== false) {
						if($posicao_foco >= 20) {
							$total_bom++;
							$itens[] = array(
								'item_descricao' => "PALAVRA-CHAVE DE FOCO NO TÍTULO SEO",
				            	'item_nivel' 	 => "bom",
				            	'item_cor' 		 => "orange",
				            	'item_frase' 	 => "O título SEO contém a palavra-chave de foco, mas não aparece no início. Tente movê-lo o mais próximo do início."
							);
						}else{
							$total_otimo++;
							$itens[] = array(
								'item_descricao' => "PALAVRA-CHAVE DE FOCO NO TÍTULO SEO",
				            	'item_nivel' 	 => "ótimo",
				            	'item_cor' 		 => "green",
				            	'item_frase' 	 => "O título SEO contém a palavra-chave de foco no início, que é considerado para melhorar rankings de busca."
							);
						}
					}else{
						$total_ruim++;
						$itens[] = array(
							'item_descricao' => "PALAVRA-CHAVE DE FOCO NO TÍTULO SEO",
			            	'item_nivel' 	 => "ruim",
			            	'item_cor' 		 => "red",
			            	'item_frase' 	 => "A palavra-chave de foco não aparece no título SEO."
						);
					}
				}

				$span_titulo = $meta_title;
			}

			// DESCRIÇÃO SEO
			if($meta_description == "") {
				$total_ruim++;
				$itens[] = array(
					'item_descricao' => "DESCRIÇÃO SEO",
	            	'item_nivel' 	 => "ruim",
	            	'item_cor' 		 => "red",
	            	'item_frase' 	 => "Nenhuma descrição SEO foi especificada. Os mecanismos de pesquisa exibirão o início do texto."
				);
			}else{
				// TAMANHO DA DESCRIÇÃO SEO
				$txt_metatexto 		= addslashes($meta_description);
				$txt_metatexto 		= str_replace('&nbsp;', ' ', $txt_metatexto);
				$txt_metatexto 		= preg_replace('/\s/', ' ', $txt_metatexto); // remove quebras
				$txt_metatexto 		= preg_replace('/( ){2,}/', ' ', $txt_metatexto); // remove espaços duplicados

				$span_descricao 	= $txt_metatexto;

				$tamanho_metatexto 	= strlen(utf8_decode($txt_metatexto));

				if($tamanho_metatexto >= 120) {
					if($tamanho_metatexto > 156) {
						$total_bom++;
						$itens[] = array(
							'item_descricao' => "TAMANHO DA DESCRIÇÃO SEO",
			            	'item_nivel' 	 => "bom",
			            	'item_cor' 		 => "orange",
			            	'item_frase' 	 => "A descrição SEO tem mais de 156 caracteres. Reduzindo o comprimento você garante que a descrição seja visível por inteiro."
						);
					}else{
						$total_otimo++;
						$itens[] = array(
							'item_descricao' => "TAMANHO DA DESCRIÇÃO SEO",
			            	'item_nivel' 	 => "ótimo",
			            	'item_cor' 		 => "green",
			            	'item_frase' 	 => "O tamanho da descrição SEO é suficiente."
						);
					}
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "TAMANHO DA DESCRIÇÃO SEO",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "A descrição SEO tem menos de 120 caracteres. Considere utilizar até 156 caracteres."
					);
				}

				// PALAVRA-CHAVE DE FOCO NA DESCRIÇÃO SEO
				$posicao_desc_foco = strpos(strtolower($meta_description), strtolower($meta_palavra_chave));
					
				if($posicao_desc_foco !== false) {
					$total_otimo++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO NA DESCRIÇÃO SEO",
		            	'item_nivel' 	 => "ótimo",
		            	'item_cor' 		 => "green",
		            	'item_frase' 	 => "A descrição SEO contém a palavra-chave de foco."
					);
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO NA DESCRIÇÃO SEO",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "A descrição SEO foi especificada, mas não contém a palavra-chave de foco."
					);
				}
			}

			if($meta_palavra_chave != "") {
				// PALAVRA-CHAVE DE FOCO NA URL DA POSTAGEM (SLUG)
				$existe_chave_slug = strpos($meta_slug, $this->_slug->createslug($meta_palavra_chave));

				if($existe_chave_slug !== false) {
					$total_otimo++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO NA URL DA POSTAGEM (SLUG)",
		            	'item_nivel' 	 => "ótimo",
		            	'item_cor' 		 => "green",
		            	'item_frase' 	 => "A palavra-chave de foco aparece na Url Slug deste artigo."
					);
				}else{
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO NA URL DA POSTAGEM (SLUG)",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "A palavra-chave de foco não aparece na Url Slug deste artigo. Considere editar a Url Slug."
					);
				}

				// PALAVRA-CHAVE DE FOCO EM OUTRAS PUBLICAÇÕES
				$model_blogs = new Admin_Model_Blogs();
				
				$select = $model_blogs->select()
					->where("meta_palavra_chave = ?", trim($meta_palavra_chave));

				if($idprimary > 0) {
					$select
						->where("idblog != ?", $idprimary);
				}

				$blogs = $model_blogs->fetchAll($select);

				if(count($blogs) > 0) {
					$total_ruim++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO NA URL DA POSTAGEM (SLUG)",
		            	'item_nivel' 	 => "ruim",
		            	'item_cor' 		 => "red",
		            	'item_frase' 	 => "Você já utilizou esta palavra-chave de foco em outras postagens, considere utilizar outra."
					);
				}else{
					$total_otimo++;
					$itens[] = array(
						'item_descricao' => "PALAVRA-CHAVE DE FOCO NA URL DA POSTAGEM (SLUG)",
		            	'item_nivel' 	 => "ótimo",
		            	'item_cor' 		 => "green",
		            	'item_frase' 	 => "Parabéns, você não utilizou esta palavra-chave antes."
					);
				}
			}

			// IMAGEM DE DESTAQUE NA POSTAGEM
			if($imagem_url != "") {
				$imagem_arquivo = end(explode("uploads/blog/", $imagem_url));
			}

			if(($imagem_arquivo != "" && file_exists("common/uploads/blog/" . $imagem_arquivo)) || $imagem_temp_url != "") {
				$total_otimo++;
                $itens[] = array(
					'item_descricao' => "IMAGEM DE DESTAQUE NA POSTAGEM",
	            	'item_nivel' 	 => "ótimo",
	            	'item_cor' 		 => "green",
	            	'item_frase' 	 => "Sua postagem contém uma imagem de destaque."
				);
            }else{
            	$total_ruim++;
            	$itens[] = array(
					'item_descricao' => "IMAGEM DE DESTAQUE NA POSTAGEM",
	            	'item_nivel' 	 => "ruim",
	            	'item_cor' 		 => "red",
	            	'item_frase' 	 => "Nenhuma imagem de destaque aparece nesta postagem, considere acrescentar alguma."
				);
            }

            // Tratamento de tamanho da exibição seo-preview
            if($meta_slug != "") {
            	$span_slug = $this->_dominio . "/post/" . $idprimary . "/" . $meta_slug;
            }

            // Ordena os itens por cor
            $new_itens = $this->ordenarCor($itens);

			$new_itens = array_reverse($new_itens); // inverte ordenação

            // Retorno itens
            $resposta = array(
                'status' 			=> 'sucesso',
                'span_titulo' 	 	=> mb_strimwidth(trim($span_titulo), 0, 63, "..."),
                'span_link' 	 	=> mb_strimwidth(trim($span_slug), 0, 130, "..."),
                'span_descricao'	=> mb_strimwidth(trim($span_descricao), 0, 156, "..."),
                'meta_slug' 		=> trim($meta_slug),
                'total_otimo' 		=> $total_otimo,
                'total_bom' 		=> $total_bom,
                'total_ruim' 		=> $total_ruim,
                'itens'  			=> $new_itens
            );

		}else{
			// ERRO
            $resposta = array(
                'status' => 'erro',
                'itens' => '',
            );
		}

		// Resposta de retorno
		return $resposta;
	}

	// Função de ordenação do array
	public function ordenarCor($itens) {
		// Verifica se já existe a função
		if(!function_exists('ordenandoCor')) {
			// Ordena por cor
		  	function ordenandoCor($itens, $b) {
			  return strcmp($itens["item_cor"], $b["item_cor"]);
			}
		}

		usort($itens, 'ordenandoCor'); // ordena o array

	  return $itens;
	}
}