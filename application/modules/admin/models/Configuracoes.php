<?php

/**
 * Modelo da tabela
 *
 * @name Admin_Model_Configuracoes
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Configuracoes extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "gm_configuracoes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idconfiguracao";

	/**
	 * Armazena se bloqueia manipulação dos dados
	 *
	 * @access protected
	 * @name $_somenteview
	 * @var string
	 */
	protected $_somenteView = false;

	/**
	 * Armazena se bloqueia exportar xls no list
	 *
	 * @access protected
	 * @name $_gerarXls
	 * @var string
	 */
	protected $_gerarXls = false;

	/**
	 * Armazena se bloqueia exportar pdf no view
	 *
	 * @access protected
	 * @name $_gerarPdf
	 * @var string
	 */
	protected $_gerarPdf = false;
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
        // Adiciona os campos ao model
        $this->setCampo("nome_site", "Nome site");
		$this->setCampo("facebook", "Facebook");
		$this->setCampo("instagram", "Instagram");
		$this->setCampo("linkedin", "Linkedin");
		$this->setCampo("whatsapp", "Whatsapp");

		// Configs
        $this->setCampo("recaptcha_key", "Recaptcha key");
        $this->setCampo("recaptcha_secret", "Recaptcha secret key");
        $this->setCampo("share_tag", "Tag compartilhamento");
        $this->setCampo("codigo_final_head", "HTML final da head");
        $this->setCampo("codigo_inicio_body", "HTML início do body");
        $this->setCampo("codigo_final_body", "HTML final do body");
        $this->setCampo("politica_cookie_texto", "HTML final do body");

        // Seta o campo de descrição da tabela
		$this->setDescription("nome_site");

        // Seta visibilidade dos campos
        $this->setVisibility("nome_site", TRUE, TRUE, FALSE, TRUE);
		$this->setVisibility("facebook", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("instagram", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("linkedin", TRUE, TRUE, FALSE, FALSE);
		$this->setVisibility("whatsapp", TRUE, TRUE, FALSE, FALSE);
        // Configs
        $this->setVisibility("recaptcha_key", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("recaptcha_secret", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("share_tag", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("codigo_final_head", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("codigo_inicio_body", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("codigo_final_body", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("politica_cookie_texto", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor-big' => ''));

        // Continua o carregamento do model
        parent::init();
    }
}
