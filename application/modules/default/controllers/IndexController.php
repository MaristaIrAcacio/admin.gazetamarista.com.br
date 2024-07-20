<?php

/**
 * Controlador da index do institucional
 *
 * @name IndexController
 */
class IndexController extends Zend_Controller_Action
{
    /**
     *
     */
    public function init()
    {
        /* Initialize action controller here */

        // Setlocale
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');

        // Função de bloquear injection
        $this->sanitize 		= new Clickweb_Sanitize();

        // Seta a sessão das mensagens e cliente
        $this->messages 		= new Zend_Session_Namespace("messages");
        $this->session_config 	= new Zend_Session_Namespace("configuracao");

        // Seta a sessão de usuário
        $this->cliente          = new Zend_Session_Namespace("cliente");

        // Função de Validar o login
        $this->valida_login 	= new Clickweb_Validalogin();

        // Url domínio
		$this->dominio 			= url_dominio();
        $this->view->dominio 	= $this->dominio;
	}

    /**
     * Página inicial
     */
    public function indexAction()
    {
		// Banners
        $this->view->banners = (new Admin_Model_Banners())->fetchAll(array("ativo = 1"), "ordenacao ASC");

		// Sobre
        $this->view->sobre = (new Admin_Model_Sobre())->fetchRow(array('idsobre = ?' => 1));

		// Sobre diferenciais
        $this->view->diferenciais = (new Admin_Model_Sobreitens())->fetchAll(array('idsobre = ?' => 1), 'idsobre_item ASC');

        // Produtos institucionais
		$model_produtos = new Admin_Model_Produtosinstitucional();
        $select_produtos = $model_produtos->select()
			->from("produtos_institucional", array("*"))
			->joinInner("marcas", "produtos_institucional.idmarca = marcas.idmarca", array("marca"))
			->columns(array(
			    'capa' => new Zend_Db_Expr("
			        CONVERT((SELECT imagem FROM mediagallery WHERE model = 'Admin_Model_Produtosinstitucional' AND type = 'foto' AND id = produtos_institucional.idproduto_institucional ORDER BY ordenacao ASC LIMIT 1) USING utf8)
			    ")
			))
			->where("produtos_institucional.ativo = ?", 1)
			->where("marcas.ativo = ?", 1)
			->order("produtos_institucional.ordenacao ASC")
			->order("produtos_institucional.titulo ASC")
			->setIntegrityCheck(false);

		$produtos = $model_produtos->fetchAll($select_produtos);
		$this->view->produtos = $produtos;

		// Blogs
		$model_noticias = new Admin_Model_Blogs();
        $select_noticias = $model_noticias->select()
			->from("blogs", array("*"))
			->joinInner("blogs_categorias", "blogs.idblog_categoria = blogs_categorias.idblog_categoria", array("blogcategoria"))
			->where("blogs.ativo = ?", 1)
			->where("blogs_categorias.ativo = ?", 1)
			->where("blogs.data <= CURDATE()")
			->order("blogs.data DESC")
			->limit(5)
			->setIntegrityCheck(false);

        // Acessos
        $this->model_config 		= new Admin_Model_Configuracoes();
        $settings = $this->model_config->fetchRow($select);
        $qtd_view = $settings->qtd_views;
        $this->model_config->update(array("qtd_views" => $qtd_view + 1), array("idconfiguracao = ?" => 1));

		$noticias = $model_noticias->fetchAll($select_noticias);
		$this->view->noticias = $noticias;

        $config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path             = $path;

    }

    /**
     * Página Produtos
     */
    public function produtosAction()
    {
    	// Parametro
        $idmarca = $this->sanitize->sanitizestring($this->getParam('idmarca', 0), "search");
        $tag 	 = $this->sanitize->sanitizestring($this->getParam('tag', ""), "search");

		// Produtos institucionais
		$model_produtos = new Admin_Model_Produtosinstitucional();
        $select_produtos = $model_produtos->select()
			->from("produtos_institucional", array("*"))
			->joinInner("marcas", "produtos_institucional.idmarca = marcas.idmarca", array("marca"))
			->columns(array(
			    'capa' => new Zend_Db_Expr("
			        CONVERT((SELECT imagem FROM mediagallery WHERE model = 'Admin_Model_Produtosinstitucional' AND type = 'foto' AND id = produtos_institucional.idproduto_institucional ORDER BY ordenacao ASC LIMIT 1) USING utf8)
			    ")
			))
			->where("produtos_institucional.ativo = ?", 1)
			->where("marcas.ativo = ?", 1)
			->order("produtos_institucional.ordenacao ASC")
			->order("produtos_institucional.titulo ASC")
			->setIntegrityCheck(false);

        if($idmarca > 0) {
        	// Busca marca selecionada
			$rowMarca = (new Admin_Model_Marcas())->fetchRow(array('idmarca = ?' => $idmarca, 'ativo = 1'));
            if($rowMarca) {
				// Filtra os produtos
				$select_produtos->where("produtos_institucional.idmarca = ?", $idmarca);

				// MetaTag
				$txtbusca_meta = 'Produtos da marca `' . $rowMarca->marca . '`. | ';

				// SEO
				$og_arr['titulo'] = $txtbusca_meta . $this->session_config->dados->nome_site;
				$this->view->og_arr = $og_arr;

				// Meta title
				$this->view->headTitle()->append('Marca `' . $rowMarca->marca . '`');
			}
		}

        if(!empty($tag)) {
        	// Instancia o db
            $db = Zend_Registry::get("db");

            // Limpa texto
            $tag = preg_replace('/[`^~\"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $tag));

             $select_produtos
                 ->where("
                     LOWER(produtos_institucional.tags) LIKE _utf8 " . $db->quote("%" . mb_strtolower($tag) . "%") . " COLLATE utf8_unicode_ci
                 ");

            // MetaTag
            $txtbusca_meta = 'Tag buscada `' . mb_strtolower($tag) . '`. | ';

            // SEO
            $og_arr['titulo'] = 'Produtos | ' . $txtbusca_meta . $this->session_config->dados->nome_site;
            $this->view->og_arr = $og_arr;

            // Meta title
            $this->view->headTitle()->append('Tag buscada `' . mb_strtolower($tag) . '`');
		}

        // Fetch
		$produtos = $model_produtos->fetchAll($select_produtos);

		// Marcas
        $marcas = (new Admin_Model_Marcas())->fetchAll(array("ativo = 1"), "ordenacao ASC");

        $config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path             = $path;

		// View
		$this->view->produtos 	= $produtos;
		$this->view->marcas 	= $marcas;
		$this->view->idmarca 	= $idmarca;
    }

    /**
     * Página Produto Detalhe
     */
    public function detalheProdutoAction()
    {
    	// Parametro
        $idproduto = $this->sanitize->sanitizestring($this->getParam('idproduto', 0), "search");

        if($idproduto > 0) {
        	// Produtos institucionais
			$model_produtos = new Admin_Model_Produtosinstitucional();
			$select_produto = $model_produtos->select()
				->from("produtos_institucional", array("*"))
				->joinInner("marcas", "produtos_institucional.idmarca = marcas.idmarca", array("marca"))
				->columns(array(
					'capa' => new Zend_Db_Expr("
						CONVERT((SELECT imagem FROM mediagallery WHERE model = 'Admin_Model_Produtosinstitucional' AND type = 'foto' AND id = produtos_institucional.idproduto_institucional ORDER BY ordenacao ASC LIMIT 1) USING utf8)
					")
				))
				->where("produtos_institucional.ativo = ?", 1)
				->where("marcas.ativo = ?", 1)
				->where("produtos_institucional.idproduto_institucional = ?", $idproduto)
				->setIntegrityCheck(false);

			// Fetch
			$produto = $model_produtos->fetchRow($select_produto);

			if($produto) {
				// Arquivos de mídia
                $galeria = (new Admin_Model_Mediagallery())->fetchAll(array(
                    'model = ?' => 'Admin_Model_Produtosinstitucional', 'id = ?' => $idproduto
                ), "ordenacao ASC");

                $model_diferenciais = new Admin_Model_ProdutosDiferenciais();
                $select_diferenvciais = $model_diferenciais->select()
                    ->order("ordenacao ASC");

		        $diferenciais = $model_diferenciais->fetchAll($select_diferenvciais);

                // Assina na view os diferenciais
        		$this->view->diferenciais = $diferenciais;

                $model_compromissos = new Admin_Model_Compromissos();
                $select_compromissos = $model_compromissos->select()
                    ->order("ordenacao ASC");
                $compromissos = $model_compromissos->fetchAll($select_compromissos);
        
                // Assina na view os compromissos
                $this->view->compromissos             = $compromissos;

				// Meta Title
                 $this->view->headTitle()->prepend($produto->title);
                 $og_arr['titulo'] = $produto->title . ' | ' . $this->session_config->dados->nome_site;

                 // Meta Description
				 if (!empty($produto->titulo2)) {
					 $this->view->headMeta()->setName("description", substr(preg_replace("/\r|\n|nbsp;|&amp;/", "", strip_tags($produto->description)), 0, 250));
					 $og_arr['descricao'] = substr(preg_replace("/\r|\n|nbsp;|&amp;/", "", strip_tags($produto->titulo2)), 0, 250);
				 } else {
					 $this->view->headMeta()->setName("description", $produto->description);
					 $og_arr['descricao'] = $produto->description;
				 }

                 // Url
                 $og_arr['url'] = $this->view->url(['idproduto'=>$idproduto, 'slug'=>(new Clickweb_View_Helper_CreateSlug())->createslug($produto->titulo)], 'detalhe-produto');

                 // Imagem
                 if(!empty($produto->capa) && file_exists("common/uploads/produto_institucional/" . $produto->capa)) {
                     $og_arr['imagem'] = $this->dominio . "/thumb/produto_institucional/2/940/490/" . $produto->capa;
                 }
                 $this->view->og_arr = $og_arr;

                 // View
				$this->view->produto 	= $produto;
				$this->view->galeria    = $galeria;
			}else{
				// ERRO
				$this->messages->error = "Produto não encontrado.";
				$this->_redirectroute('produtos');
			}
		}else{
			// ERRO
			$this->messages->error = "Produto inválido.";
			$this->_redirectroute('produtos');
		}

        $config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path             = $path;
    }

	/**
     * Página Sobre nós
     */
    public function sobreNosAction()
    {

        $model_valores = new Admin_Model_valores();
        $select_valores = $model_valores->select()
			->order("ordenacao ASC");

		$valores = $model_valores->fetchAll($select_valores);

        $this->view->valores             = $valores;

        // Buscas os dados de compromissos
        $model_compromissos = new Admin_Model_Compromissos();
        $select_compromissos = $model_compromissos->select()
			->order("ordenacao ASC");
		$compromissos = $model_compromissos->fetchAll($select_compromissos);
        $this->view->compromissos             = $compromissos;

        // Busca os dados da linha do tempo
        $model_linhadotempo = new Admin_Model_Linhadotempo();
        $select_linhadotempo = $model_linhadotempo->select()
			->order("ordenacao ASC");
		$linhadotempo = $model_linhadotempo->fetchAll($select_linhadotempo);
        $this->view->timeline             = $linhadotempo;

		// Sobre
        $this->view->sobre = (new Admin_Model_Sobre())->fetchRow(array('idsobre = ?' => 1));

        $config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path             = $path;
    }

    /**
     * Página Dúvidas Frequentes
     */
    public function duvidasFrequentesAction()
    {
    	// Parametro
        $termo = $this->sanitize->sanitizestring($this->getParam('termo', ""), "search"); // get

        // Verifica se foi efetuado uma busca
        if ($this->_request->isPost()) {
            $busca = $this->sanitize->sanitizestring($this->_request->getParam("search", ""), "search"); // post

            // Atualiza a variável com o termo buscado
            $termo_txt = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $busca));

            //$comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');
            //$semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U');
            //$termo_txt  = str_replace($comAcentos, $semAcentos, $busca);

            if (!empty($termo_txt)) {
                // Redirect
                $this->_redirectroute('duvidas-frequentes', array('termo' => strtolower($termo_txt)));
            }
        }

        $config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path             = $path;

        // Dúvidas
		$select = (new Admin_Model_Perguntas())->select()
			->where("ativo = ?", 1)
			->order("ordenacao ASC");

		// Verifica se existe o termo get
        if(!empty($termo)) {
            // Instancia o db
            $db = Zend_Registry::get("db");

            // Limpa texto
            $termo = preg_replace('/[`^~\"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $termo));

            $select
                 ->where("
                     LOWER(pergunta) LIKE _utf8 " . $db->quote("%" . mb_strtolower($termo) . "%") . " COLLATE utf8_unicode_ci
                     OR LOWER(resposta) LIKE _utf8 " . $db->quote("%" . mb_strtolower($termo) . "%") . " COLLATE utf8_unicode_ci
                 ");

            // MetaTag
            $txtbusca_meta = 'Termo buscado `' . mb_strtolower($termo) . '`. | ';

            // SEO
            $og_arr['titulo'] = 'Dúvidas frequentes | ' . $txtbusca_meta . $this->session_config->dados->nome_site;
            $this->view->og_arr = $og_arr;

            // Meta title
            $this->view->headTitle()->append('Termo buscado `' . mb_strtolower($termo) . '`');
        }

		// Dúvidas
        $this->view->duvidas = (new Admin_Model_Perguntas())->fetchAll($select);
        $this->view->termo 	 = $termo;
    }

	/**
	 * Página textos internas
	 */
	public function paginaAction() {
        // Parametro
        $param = $this->sanitize->sanitizestring($this->_request->getParam("slug",""), "search");
        
        if(!empty($param)) {
            // Seleciona dados
            $interna_atual = (new Admin_Model_Internas())->fetchRow(array("parametro = ?" => $param));

            if(!empty($interna_atual->meta_titulo)) {
                $this->view->headTitle()->prepend($interna_atual->meta_titulo);
                $og_arr['titulo'] = $interna_atual->meta_titulo . ' | ' . $this->session_config->dados->nome_site;
            }else{
                $this->view->headTitle()->prepend($interna_atual->titulo);
                $og_arr['titulo'] = $interna_atual->titulo . ' | ' . $this->session_config->dados->nome_site;
            }

            if(!empty($interna_atual->meta_descricao)) {
                $this->view->headMeta()->setName("description", substr(preg_replace( "/\r|\n|nbsp;|&amp;/", "", strip_tags($interna_atual->meta_descricao)), 0,250));
                $og_arr['descricao'] = substr(preg_replace( "/\r|\n|nbsp;|&amp;/", "", strip_tags($interna_atual->meta_descricao)), 0,250);
            }else{
                $this->view->headMeta()->setName("description", substr(preg_replace( "/\r|\n|nbsp;|&amp;/", "", strip_tags($interna_atual->texto)), 0,250));
                $og_arr['descricao'] = substr(preg_replace( "/\r|\n|nbsp;|&amp;/", "", strip_tags($interna_atual->texto)), 0,250);
            }
            
            // Assina na view
            $this->view->parametro 		= $param;
            $this->view->interna_atual 	= $interna_atual;
            $this->view->og_arr         = $og_arr;
        }else{
            // Redireciona para index
            redirect_route('home');
        }

        $config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path             = $path;
    }
	
    /**
     * Página Contato
     */
    public function contatoAction()
    {
    	// Somente tela

        $config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path             = $path;
    }

    /**
     * Tela de retorno do envio de formulário
     * Pagina = email, contato...
     * Status = 'erro' ou 'sucesso'
     *
     * @param String $pagina
     * @param String $status
     *
     */
    public function telaretornoAction()
    {
        // Param
        $pagina = $this->sanitize->sanitizestring($this->_request->getParam("pagina", ""), "search");
        $status = $this->sanitize->sanitizestring($this->_request->getParam("status", ""), "search");

        if (!empty($pagina) && !empty($status)) {
            // Busca a sessão do retorno
            $retorno = new Zend_Session_Namespace("telaretorno");

            // Assina na view
            $this->view->pagina = $pagina;
            $this->view->status = $status;
            $this->view->title 	= $retorno->title;
            $this->view->msg 	= $retorno->mensagem;
        } else {
            // Adiciona a mensagem de erro à sessão
            $this->messages->error = "Envio inválido";
            $this->_redirect($_SERVER["HTTP_REFERER"]);
        }

        // Ativa o menu alternativo
        $this->view->alternative = true;

        $config = Zend_Registry::get("config");
        $path = $config->clickweb->config->basepath;

        $this->view->path             = $path;
    }
}
