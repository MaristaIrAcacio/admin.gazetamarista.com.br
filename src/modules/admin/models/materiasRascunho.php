<?php

/**
 * Modelo
 *
 * @name Admin_Model_Materias
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_MateriasRascunho extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "gm_materias";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idNoticia";

	/**
	 * Armazena se bloqueia exportar xls no list
	 *
	 * @access protected
	 * @name $_gerarXls
	 * @var string
	 */
	protected $_gerarXls = false;

	/**
	 * Armazena se bloqueia manipulação dos dados
	 *
	 * @access protected
	 * @name $_somenteview
	 * @var string
	 */
	protected $_somenteView = false;
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("isRascunho", "Tipo de Envio de Matéria?");

		$this->setCampo("imagem_desktop", "Imagem de Capa da Notícia - Desktop");
		$this->setCampo("imagem_mobile", "Imagem de Capa da Notícia - Mobile");

		$this->setCampo("categoriaId", "Categoria da Notícia");
		$this->setCampo("autorId", "Autor");
		$this->setCampo("colaboradorId", "Colaborador");

		$this->setCampo("titulo", "Título da notícia", "Será usado no SEO da matéria");
		$this->setCampo("subtitulo", "Subtítulo", "Será usado no SEO da matéria");
		$this->setCampo("lide", "Lide da Notícia");
		$this->setCampo("texto", "Corpo do Texto");

		$this->setCampo("status", "Status da Notícia");
		$this->setCampo("apontamentos", "Apontamentos");
		$this->setCampo("dataPublicacao", "Data de Publicação");
		$this->setCampo("tags", "Tags", "Separadas por vírgula (,)");
		$this->setCampo("tipo", "Tipo de Texto");
		$this->setCampo("criadoEm", "Texto Criado Em");
		$this->setCampo("atualizadoEm", "Texto Atualizado Em");
		$this->setCampo("ultimaAlteracao", "Última Alteração Em");


		// Seta o campo de descrição da tabela
		$this->setDescription("titulo");

		// Seta visibilidade dos campos
		$this->setVisibility("imagem_desktop", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("imagem_mobile", TRUE, TRUE, FALSE, FALSE);

		$this->setVisibility("categoriaId", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("autorId", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("colaboradorId", TRUE, TRUE, FALSE, FALSE);

		$this->setVisibility("isRascunho", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("titulo", TRUE, TRUE, FALSE, TRUE);
		$this->setVisibility("subtitulo", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("lide", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor' => ''));
		$this->setVisibility("texto", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor' => ''));

		$this->setVisibility("status", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("apontamentos", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("dataPublicacao", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("tags", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("tipo", TRUE, TRUE, FALSE, TRUE);
		$this->setVisibility("criadoEm", FALSE, FALSE, FALSE, TRUE);
		$this->setVisibility("atualizadoEm", FALSE, FALSE, FALSE, FALSE);
		$this->setVisibility("ultimaAlteracao", FALSE, FALSE, FALSE, FALSE);

		// Seta autocomplete
		$this->setAutocomplete("categoriaId", "Admin_Model_MateriasCategoria");
		$this->setAutocomplete("colaboradorId", "Admin_Model_Usuarios");	
		
		// Seta os Modificadores
		$this->setModifier("imagem_desktop", array(
			'type' => "file",
			'preview' => "common/uploads/materias",
			'destination' => APPLICATION_PATH . "/../common/uploads/materias",
            'extension' => array('jpg', 'jpeg', 'png')
		));

		$this->setModifier("imagem_mobile", array(
			'type' => "file",
			'preview' => "common/uploads/materias",
			'destination' => APPLICATION_PATH . "/../common/uploads/materias",
            'extension' => array('jpg', 'jpeg', 'png')
		));

		// Continua o carregamento do model
		parent::init();
	}
}
