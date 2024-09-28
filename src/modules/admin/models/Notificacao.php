<?php

/**
 * Modelo da tabela de notificações
 *
 * @name Admin_Model_Notificacao
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Notificacao extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "gm_notificacoes";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "id";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		//
		$this->setCampo("tipo", "Tipo de Notificação");
		$this->setCampo("item_id", "Id do Item da Notificação");

		$this->setDescription("tipo");

        $this->setVisibility("tipo", TRUE, TRUE, FALSE, FALSE);
        $this->setVisibility("item_id", TRUE, TRUE, FALSE, FALSE);
		
		//
		parent::init();
	}
}
