<?php

/**
 * Elemento password do formulario
 *
 * @name gazetamarista_Form_Password
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_Password extends Zend_Form_Element_Password {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "password");
		parent::setAttrib("class", "string password");
	}
}
