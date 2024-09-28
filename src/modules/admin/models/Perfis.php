<?php

/**
 * Modelo da tabela de perfis
 *
 * @name Admin_Model_Perfis
 * @see Zend_Db_Table_Abstract
 */
class Admin_Model_Perfis extends gazetamarista_Db_Table {
	/**
	 * Armazena o nome da tabela
	 *
	 * @access protected
	 * @name $_name
	 * @var string
	 */
	protected $_name = "gm_perfis";

	/**
	 * Armazena o nome do campo da tabela primaria
	 *
	 * @access protected
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "idperfil";
	
	/**
	 * Inicializa o model
	 * 
	 * @name init
	 */
	public function init() {
		// Adiciona os campos ao model
		$this->setCampo("descricao", "Descrição");

		// Seta o campo de descrição da tabela
		$this->setDescription("descricao");

		// Seta visibilidade dos campos
		$this->setVisibility("descricao", TRUE, TRUE, TRUE, TRUE);
		
		// Busca a sessão do usuário
		$session = new Zend_Session_Namespace("loginadmin");
		if($session->logged_usuario['idperfil'] > 0) {
			$select = $this->select();
			$select->where("idperfil <= ?", $session->logged_usuario['idperfil']);
			$this->setQueryAutoComplete("default", $select);
		}
		
		// Continua o carregamento do model
		parent::init();
	}
}