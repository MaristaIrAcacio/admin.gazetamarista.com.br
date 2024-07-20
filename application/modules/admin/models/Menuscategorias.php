<?php

/**
 * Modelo da tabela de menus_categorias
 *
 * @name Admin_Model_Menuscategorias
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Menuscategorias extends gazetamarista_Db_Table {
    /**
     * Armazena o nome da tabela
     *
     * @access protected
     * @name $_name
     * @var string
     */
    protected $_name = "menu_categorias";

    /**
     * Armazena o nome do campo da tabela primaria
     *
     * @access protected
     * @name $_primary
     * @var string
     */
    protected $_primary = "idcategoria";

    /**
     * Inicializa o model
     *
     * @name init
     */
    public function init() {
        //
        $this->setCampo("icone", "Icone", "ex: mdi-settings");
        $this->setCampo("descricao", "Descrição");
        $this->setCampo("ordenacao", "Ordenação");

        //
        $this->setDescription("descricao");

        $this->setVisibility("icone", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("descricao", TRUE, TRUE, TRUE, TRUE);
        $this->setVisibility("ordenacao", TRUE, TRUE, TRUE, TRUE );

        //
        parent::init();
    }
}

