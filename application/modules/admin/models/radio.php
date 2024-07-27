<?php

/**
 * Modelo
 *
 * @name Admin_Model_Radio
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Radio extends gazetamarista_Db_Table {
    /**
     * Armazena o nome da tabela
     *
     * @access protected
     * @name $_name
     * @var string
     */
    protected $_name = "gm_programacaoradio";

    /**
     * Armazena o nome do campo da tabela primaria
     *
     * @access protected
     * @name $_primary
     * @var string
     */
    protected $_primary = "idRadio";

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
        $this->setCampo("data", "Dia da Pauta");
        $this->setCampo("periodo", "Período");
        $this->setCampo("locutor1", "Locutor 1");
        $this->setCampo("locutor2", "Locutor 2");
        $this->setCampo("locutor3", "Locutor 3");
        $this->setCampo("calendario_sazonal", "Calendário Sazonal");
        $this->setCampo("musica1", "Música 1");
        $this->setCampo("comentario_musica1", "Comentário da Música 1");
        $this->setCampo("noticia1", "Notícia 1");
        $this->setCampo("musica2", "Música 2");
        $this->setCampo("comentario_musica2", "Comentário da Música 2");
        $this->setCampo("curiosidade_dia", "Curiosidade do Dia");
        $this->setCampo("musica3", "Música 3");
        $this->setCampo("comentario_musica3", "Comentário da Música 3");
        $this->setCampo("noticia_urgente", "Notícia Urgente");
        $this->setCampo("encerramento", "Encerramento");
        $this->setCampo("musica4", "Música 4");
        $this->setCampo("musica5", "Música 5");
        $this->setCampo("musica6", "Música 6");

        $this->setCampo("pauta_escrita", "Pauta da Rádio Digitada", "Personalização Livre");

        // Seta o campo de descrição da tabela
        $this->setDescription("data");

        // Seta visibilidade dos campos
        $this->setVisibility("data", TRUE, TRUE, FALSE, TRUE);
        $this->setVisibility("periodo", TRUE, TRUE, FALSE, TRUE);
        $this->setVisibility("locutor1", TRUE, TRUE, FALSE, TRUE);
        $this->setVisibility("locutor2", TRUE, TRUE, FALSE, TRUE);
        $this->setVisibility("locutor3", TRUE, TRUE, FALSE, TRUE);
        $this->setVisibility("calendario_sazonal", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor' => ''));
        $this->setVisibility("musica1", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("comentario_musica1", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("noticia1", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor' => ''));
        $this->setVisibility("musica2", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("comentario_musica2", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("curiosidade_dia", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("musica3", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("comentario_musica3", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("noticia_urgente", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("encerramento", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("musica4", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("musica5", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("musica6", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("pauta_escrita", TRUE, TRUE, FALSE, FALSE, FALSE, array('data-ckeditor-big' => ''));

        // Seta autocomplete
        $this->setAutocomplete("locutor1", "Admin_Model_Usuarios");  
        $this->setAutocomplete("locutor2", "Admin_Model_Usuarios");  
        $this->setAutocomplete("locutor3", "Admin_Model_Usuarios");  

        // Continua o carregamento do model
        parent::init();
    }
}
